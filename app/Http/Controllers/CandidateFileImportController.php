<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\Assign;
use App\Models\candidate;
use App\Models\CandidateFileImport;
use App\Models\CandidateRemark;
use App\Models\CandidateResume;
use App\Models\Dashboard;
use App\Models\Employee;
use App\Models\ImportCandidateData;
use App\Models\TemporaryImportedData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory; // For handling .xls, .xlsx files
use Smalot\PdfParser\Parser as PdfParser; // For handling PDF files

class CandidateFileImportController extends Controller
{
    public $user;


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check user authorization
        if (is_null($this->user) || !$this->user->can('import.index')) {
            abort(403, 'Unauthorized');
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'daterange' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get validated data
        $validated = $validator->validated();

        // Initialize variables
        $start = $end = Carbon::now()->toDateString();

        // Parse date range if provided
        if (array_key_exists('daterange', $validated) && !empty($validated['daterange'])) {
            [$start, $end] = explode(' - ', $validated['daterange']);
        }

        // Apply filters
        $history_data = TemporaryImportedData::where('created_by', Auth::id())
            ->where('status', 1);

        if ($start && $end) {
            $history_data->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end . ' 23:59:59');
        }

        // Paginate the results and append the date range to pagination links
        $history_data = $history_data->paginate(10)->appends(['daterange' => $validated['daterange'] ?? null]);

        // Pass other required data to the view
        $importData = ImportCandidateData::where('user_id', Auth::id())->get();
        $temporary_data = TemporaryImportedData::where('created_by', Auth::id())
            ->where('status', 0)
            ->paginate(10);
        // $assignPerson = Employee::where('employee_status', 1)->where('roles_id', 8)->get();

        $teamLeaders = Employee::where('manager_users_id', $this->employeeId())
        ->where('roles_id', 11)
        ->get();

        $assignPerson = Employee::whereIn('team_leader_users_id', $teamLeaders->pluck('id'))->get();

        return view('admin.candidate.import', compact('importData', 'temporary_data', 'history_data', 'assignPerson', 'start', 'end'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CandidateFileImport $candidateFileImport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CandidateFileImport $candidateFileImport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CandidateFileImport $candidateFileImport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CandidateFileImport $candidateFileImport)
    {
        //
    }

    public function upload_old(Request $request)
    {

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $uploadedFiles = [];

            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();

                // Check if the file extension is allowed
                if (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
                    // Store the file
                    $path = FileHelper::uploadFile($file);
                    // Read the file content (you might need specific logic per file type)
                    $data = $this->extractData($path, $extension);

                    $uploadedFiles[] = [
                        'path' => $path,
                        'data' => $data,
                    ];
                }
            }

            return view('admin.candidate.import')->with('uploadedFiles', $uploadedFiles);
        }

        return back()->with('error', 'No valid files were selected.');
    }
    public function upload(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('upload.files')) {
        //     abort(403, 'Unauthorized');
        // }
        $validatedData = $request->validate([
            'files.*' => 'mimes:pdf,docx,xlsx,txt'
        ]);

        if ($request->hasFile('files')) {
            $uploadedFiles = [];
            foreach ($request->file('files') as $file) {

                if ($file->getClientOriginalExtension() == 'docx') {
                    // $filename = $file->getClientOriginalName();
                    $path = FileHelper::uploadFile($file);

                    $domPdfPath = base_path('vendor/dompdf/dompdf');
                    \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    // Load Word file
                    $wordFilePath = public_path('storage/' . $path);


                    $Content = \PhpOffice\PhpWord\IOFactory::load($wordFilePath);

                    // Extract the desired part from the filename
                    $afterUploads = Str::after($path, 'uploads');
                    $beforeDocx = Str::before($afterUploads, '.docx');

                    // Save as PDF
                    $pdfFilePath = public_path('storage/uploads' . $beforeDocx . '.pdf');
                    $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
                    $PDFWriter->save($pdfFilePath);
                    ImportCandidateData::create([
                        'user_id' => Auth::user()->id,
                        'resume_path' => 'uploads' . $beforeDocx . '.pdf',
                    ]);
                    $delete_path = 'app/public/uploads' . $beforeDocx . '.docx';
                    // unlink(storage_path($delete_path));
                } elseif ($file->getClientOriginalExtension() == 'doc') {
                    $filename = $file->getClientOriginalName();
                    $path = FileHelper::uploadFile($file);

                    $domPdfPath = base_path('vendor/dompdf/dompdf');
                    \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    // Load Word file
                    $wordFilePath = public_path('storage/' . $path);
                    $Content = \PhpOffice\PhpWord\IOFactory::load($wordFilePath);

                    // Extract the desired part from the filename
                    $afterUploads = Str::after($path, 'uploads');
                    $beforeDocx = Str::before($afterUploads, '.doc');

                    // Save as PDF
                    $pdfFilePath = public_path('storage/uploads' . $beforeDocx . '.pdf');
                    $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
                    $PDFWriter->save($pdfFilePath);
                    ImportCandidateData::create([
                        'user_id' => Auth::user()->id,
                        'resume_path' => 'uploads' . $beforeDocx . '.pdf',
                    ]);
                    $delete_path = 'app/public/uploads' . $beforeDocx . '.doc';
                    // unlink(storage_path($delete_path));
                } elseif ($file->getClientOriginalExtension() == 'xlsx') {
                    $filename = $file->getClientOriginalName();
                    $path = FileHelper::uploadFile($file);
                    // Extract the desired part from the filename
                    $afterUploads = Str::after($path, 'uploads');
                    $beforeXlsx = Str::before($afterUploads, '.xlsx');
                    $pdfFilePath = public_path('storage/uploads' . $beforeXlsx . '.pdf');

                    $preadSheet = IOFactory::load(public_path('storage/' . $path));
                    $writer = IOFactory::createWriter($preadSheet, 'Mpdf');
                    $pdfFile = $pdfFilePath;
                    $writer->save($pdfFile);

                    // Store record in the database
                    ImportCandidateData::create([
                        'user_id' => Auth::user()->id,
                        'resume_path' => 'uploads' . $beforeXlsx . '.pdf',
                    ]);

                    // Delete the original XLSX file
                    $delete_path = 'app/public/uploads' . $beforeXlsx . '.xlsx';
                    unlink(storage_path($delete_path));
                } else {
                    $filename = $file->getClientOriginalName();
                    $path = FileHelper::uploadFile($file);
                    //    dd($path);
                    //$file->storeAs('uploads', $filename); // Store file in storage/uploads directory
                    ImportCandidateData::create([
                        'user_id' => Auth::user()->id,
                        'resume_path' => $path
                    ]);
                }
                // $uploadedFiles[] = $path;
            }

            // return view('admin.candidate.import');
            return back()->with('success', 'Uploaded successfully.');
            // return response()->json(compact('uploadedFiles'));

        }

        return back()->with('error', 'No files were selected.');
    }


    public function extractInfo(Request $request)
    {

        if ($request->has('selectedFile')) {
            $file = $request->selectedFile;
            $filePath = Storage::path('public/'.$file);
            $resume_text = '';
        
            try {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                    // Handle PDF file
                    $parser = new PdfParser();
                    if (file_exists($filePath)) {
                        $pdf = $parser->parseFile($filePath);
                        $resume_text = $pdf->getText();
                    }
        
                } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'docx') {
                    // Handle DOCX file
                    if (file_exists($filePath)) {
                        $phpWord = IOFactory::load($filePath);
                        foreach ($phpWord->getSections() as $section) {
                            foreach ($section->getElements() as $element) {
                                if (method_exists($element, 'getText')) {
                                    $resume_text .= $element->getText();
                                }
                            }
                        }
                    }
        
                } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'doc') {
                    // Handle DOC file (Use unoconv or a different library for DOC files)
                    // For example, using PHPWord for DOC files if needed.
                    if (file_exists($filePath)) {
                        $phpWord = IOFactory::load($filePath);
                        foreach ($phpWord->getSections() as $section) {
                            foreach ($section->getElements() as $element) {
                                if (method_exists($element, 'getText')) {
                                    $resume_text .= $element->getText();
                                }
                            }
                        }
                    }
        
                } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'xls' || pathinfo($file, PATHINFO_EXTENSION) === 'xlsx') {
                    // Handle Excel files
                    if (file_exists($filePath)) {
                        $spreadsheet = SpreadsheetIOFactory::load($filePath);
                        $sheet = $spreadsheet->getActiveSheet();
                        foreach ($sheet->getRowIterator() as $row) {
                            foreach ($row->getCellIterator() as $cell) {
                                $resume_text .= $cell->getValue() . " ";
                            }
                        }
                    }
        
                } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
                    // Handle TXT files
                    if (file_exists($filePath)) {
                        $resume_text = file_get_contents($filePath);
                    }
                }
        
                // Extract information from the text
                if (preg_match('/\b(Name:|name:|Name\s*:|name\s*:|Mr\.|Mrs\.|Ms\.|Md\.|Dr\.|Mister|Miss)\s+([A-Za-z. ]+)/mi', $resume_text, $matches)) {
                    $name = trim($matches[2]);
                } else {
                    $name = "Name not found";
                }
        
                // Extract email
                if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $resume_text, $matches)) {
                    $email = trim($matches[0]);
                } else {
                    $email = "Email not found";
                }
        
                // Extract gender
                if (preg_match('/\b(male|female)\b/i', $resume_text, $matches)) {
                    $gender = ucfirst(strtolower($matches[0]));
                } else {
                    $gender  = "Gender not found!";
                }
        
                // Extract phone number
                if (preg_match('/\+?[0-9]{6,}/', $resume_text, $matches)) {
                    $phone_no = trim($matches[0]);
                } else {
                    $phone_no = "Phone number not found";
                }
        
                // Ensure that the user has permission to extract info
                if (is_null($this->user) || !$this->user->can('extract.info')) {
                    abort(403, 'Unauthorized');
                }
        
                $myPath = asset('storage/' . $file);
        
                return response()->json(compact('resume_text', 'name', 'email', 'phone_no', 'myPath', 'gender'));
                
            } catch (\Exception $e) {
                return response('Error processing the file: ' . $e->getMessage(), 500);
            }
        } else {
            return 'File not found.';
        }
    }


    public function deleteUploadedData(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('delete.uploaded.data')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'selectedFile' => 'required|string'
        ]);

        $selectedFile = $request->input('selectedFile');
        $item = ImportCandidateData::where('resume_path', $selectedFile)->first();
        if ($item && $item->user_id == Auth::user()->id) {
            $deletePath = Str::after($selectedFile, 'uploads');
            $item->delete();
            $delete_path = 'app/public/uploads' . $deletePath;
            
            if (file_exists(storage_path($delete_path))) {
                unlink(storage_path($delete_path));
            }
            
        }

        return redirect()->back()->with('success', 'Selected items deleted successfully.');
    }

    public function temporaryDataSave(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('temporary.data.save')) {
        //     abort(403, 'Unauthorized');
        // }
        // return $request;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_no' => 'required|string|max:20',
            'gender' => 'nullable|string|max:200',
            'assign_to' => 'required|numeric|exists:employees,id',
            'resume_path' => 'required|string|max:255',
            'resume_text' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();

        $fullPath = $request->resume_path;
        $baseUrl = url('/storage') . '/';
        $relativePath = str_replace($baseUrl, '', $fullPath);
        $validatedData['resume_path'] = $relativePath;
        $validatedData['resume_path'] = $relativePath;
        $validatedData['phone_no'] = $request->country_code . ' '. $validatedData['phone_no'];
        $data = ImportCandidateData::where('resume_path', $relativePath)->first();

        try {
            DB::beginTransaction();

            TemporaryImportedData::create($validatedData);
            ImportCandidateData::find($data->id)->delete();

            DB::commit();
            return redirect()->route('import.index')->with('success', 'Candidate Listed successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function temporaryDataDelete($id)
    {
        // if (is_null($this->user) || !$this->user->can('temporary.data.delete')) {
        //     abort(403, 'Unauthorized');
        // }
        $data = TemporaryImportedData::find($id);

        if ($data) {
            $fullPath = $data->resume_path;
            $filePath = storage_path("app/public/{$fullPath}");

            if (file_exists($filePath)) {
                // Perform the desired action, e.g., delete the file
                Storage::delete("public/{$fullPath}");
            }
            TemporaryImportedData::find($id)->delete();
        }

        return back()->with('success', 'Deleted successfully');
    }
    public function importCandidateData(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('import.candidate.data')) {
        //     abort(403, 'Unauthorized');
        // }

        $temporaryData = json_decode($request->input('temporary_data'), true);

        DB::beginTransaction();
        try {
            foreach ($temporaryData['data'] as $data) {
                $candidate = candidate::where('candidate_email', $data['email'])->first();
                if(!$candidate) {
                    $team = get_team($data['assign_to']);
                    $candidate = candidate::create([
                        'candidate_name' => $data['name'],
                        'candidate_email' => $data['email'],
                        'candidate_mobile' => $data['phone_no'],
                        'candidate_joindate' => Carbon::now()->format('Y-m-d'),
                        'manager_id' => $team['manager_id'],
                        'team_leader_id' => $team['team_leader_id'],
                        'consultant_id' => $team['consultant_id'],
                    ]);

                    CandidateRemark::create([
                        'candidate_id' => $candidate->id,
                        'remarkstype_id' => 11,
                        'isNotice' => 0,
                        'remarks' => 'Candidate generate from Import',
                    ]);

                    $datas = [
                        'candidate_id' => $candidate->id,
                        'manager_id' => $candidate->manager_id,
                        'teamleader_id' => $candidate->team_leader_id,
                        'consultent_id' => $candidate->consultant_id,
                        'insert_by' => Auth::user()->id,
                        'assign_to' => $data['assign_to'],
                    ];

                    Dashboard::create($datas);
                    Assign::create($datas);

                    $candidate->update(['candidate_code' => 'Cand-' . $candidate->id]);
                }

                CandidateResume::create([
                    'candidate_id' => $candidate->id,
                    'resume_file_path' => $data['resume_path'],
                    'resume_text' => $data['resume_text'],
                    'isMain' => 1
                ]);

                TemporaryImportedData::find($data['id'])
                    ->update(['candidate_id' => $candidate->id, 'status' => 1]);
            }
            DB::commit();
            return back()->with('success', 'Candidate uploaded successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }

    }

    public function candidateSearch()
    {
        return view('admin.candidate.search');
    }

    public function candidateSearchResult(Request $request)
    {
        $keyword = $request->input('keyword');
        $dateRange = $request->input('daterange');

        [$startDate, $endDate] = explode(' - ', $dateRange);

        $candidates = Candidate::with(['resumes'])
                            ->where(function ($query) use ($startDate, $endDate, $keyword) {
                                $query->whereBetween('candidate_joindate', [$startDate, $endDate])
                                    ->orWhere('candidate_name', 'like', '%' . $keyword . '%')
                                    ->orWhere('candidate_email', 'like', '%' . $keyword . '%')
                                    ->orWhere('candidate_mobile', 'like', '%' . $keyword . '%')
                                    ->orWhere(function ($query) use ($keyword) {
                                        $query->whereHas('remarks', function ($remarksQuery) use ($keyword) {
                                            $remarksQuery->where('remarks', 'like', "%$keyword%");
                                        })
                                        ->orWhereHas('resumes', function ($resumesQuery) use ($keyword) {
                                            $resumesQuery->where('isMain', 1)->where('resume_text', 'like', "%$keyword%");
                                        });
                                    });
                            })->get();

        $data = [];
        foreach ($candidates as $key => $candidate) {
            $candidateDetails = [
                'candidate_id' => $candidate->id,
                'candidate_name' => $candidate->candidate_name,
                'candidate_email' => $candidate->candidate_email,
                'candidate_mobile' => $candidate->candidate_mobile,
                'resume_file_path' => $candidate->resumes->isNotEmpty() ? $candidate->resumes[0]->resume_file_path : '',
                'resume_text' => $candidate->resumes->isNotEmpty() ? $candidate->resumes[0]?->resume_text : '',
            ];
            $data[] = $candidateDetails;
        }

        return view('admin.candidate.search', compact('data', 'keyword', 'dateRange'));
    }

    public function getCandidateRemark(candidate $candidate)
    {
       $remarks = $candidate->remarks()->orderByDesc('created_at')->get();

       $data = [];
        foreach ($remarks as $remark) {
            $data[] = [
                'candidate_name' => $remark->candidate->candidate_name ?? '',
                'assign_to' => $remark->Assign->name ?? '',
                'remarkstype' => $remark->remarksType->remarkstype_code ?? '',
                'remarks' => $remark->remarks,
                'client' => $remark->assign_client->client->client_name ?? '',
                'created_by' => $remark->Assign->name,
                'date' => Carbon::parse($remark->created_at)->format('H:i:s d-M-Y'),
                'create_time' => Carbon::parse($remark->created_at)->format('H:i:s'),
                'create_date' => Carbon::parse($remark->created_at)->format('d-M-Y'),
            ];
        }

        return response()->json(['remarks' => $data]);
    }

    public function getCandidateTeamleader()
    {
        $auth = Auth::user()->employe;
        $teamleader = Employee::select('id', 'employee_name');

        if($auth->roles_id == 4)
        {
            $teamleader = $teamleader->where('manager_users_id', $auth->id);
        }

        $teamleader = $teamleader->where('roles_id', 11)->get();

        return response()->json(['teamleader' => $teamleader]);
    }

    public function getCandidateRc()
    {
        $auth = Auth::user()->employe;
        $rc = Employee::select('id', 'employee_name');

        if ($auth->roles_id == 4) {
            $rc = $rc->where('manager_users_id', $auth->id);
        } elseif($auth->roles_id == 11) {
        $rc = $rc->where('team_leader_users_id', $auth->id);
        }

        $rc = $rc->whereIn('roles_id', [8, 12])->get();

        return response()->json(['rc' => $rc]);
    }
}
