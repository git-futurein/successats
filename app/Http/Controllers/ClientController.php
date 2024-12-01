<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Helpers\FileHelper;
use App\Http\Requests\ClientRequest;
use App\Imports\ClientImport;
use App\Models\candidate;
use App\Models\client;
use App\Models\ClientDepartment;
use App\Models\ClientFollowUp;
use App\Models\ClientSupervisor;
use App\Models\clientTerm;
use App\Models\ClientUploadFile;
use App\Models\Employee;
use App\Models\IndustryType;
use App\Models\jobcategory;
use App\Models\TncTemplate;
use App\Models\uploadfiletype;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
// use Maatwebsite\Excel\Excel;
use Excel;
use setasign\Fpdi\Fpdi;

class ClientController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function test()
    {
        $auth = Auth::user()->employe;
        $managers = [];
        $candidatesByManager = [];
        $consultents = [];
        $candidatesByConsultent = [];
        $team_leader = [];
        $candidatesByTeam = [];
        $followUps = [];
        $activeResume = [];
        $interviews = [];
        $blackListed = [];
        $assignToClients = [];
        $kivs = [];
        $activeResumes = [];

        if ($auth->roles_id == 1) {
            $managers = Employee::where('roles_id', 4)->get();
            foreach ($managers as $manager) {
                $managerId = $manager->id;
                $candidatesForManager = Employee::getCandidatesForManager($managerId);
                $candidatesByManager[$managerId] = $candidatesForManager;
                $followUps = Employee::getCandidatesForManagerLatestRemark($managerId);
                $interviews = Employee::getCandidatesForManagerInterviews($managerId);
                $blackListed = Employee::getCandidatesForManagerblackListed($managerId);
                $assignToClients = Employee::getCandidatesForManagerassignToClient($managerId);
                $kivs = Employee::getCandidatesForManagerKIV($managerId);
                $activeResumes = Employee::getCandidatesForManagerActiveResumes($managerId);
            }
        } elseif ($auth->roles_id == 4) {
            $team_leader = Employee::where('roles_id', 11)->where('manager_users_id', $auth->id)->get();
            foreach ($team_leader as $team) {
                $teamId = $team->id;
                $candidatesForTeam = Employee::getCandidatesForTeamLeader($teamId);
                $candidatesByTeam[$teamId] = $candidatesForTeam;
                $consultents = Employee::where('roles_id', 8)->where('team_leader_users_id', $teamId)->get();
                foreach ($consultents as $consultent) {
                    $consultentId = $consultent->id;
                    $candidatesForConsultent = Employee::getCandidatesForConsultent($consultentId);
                    $candidatesByConsultent[$consultentId] = $candidatesForConsultent;
                }
            }
        } elseif ($auth->roles_id == 11) {
            $consultents = Employee::where('roles_id', 8)->where('team_leader_users_id', $auth->id)->get();
            foreach ($consultents as $consultent) {
                $consultentId = $consultent->id;
                $candidatesForConsultent = Employee::getCandidatesForConsultent($consultentId);
                $candidatesByConsultent[$consultentId] = $candidatesForConsultent;
            }
        }

        return view('admin.client.test', compact(
            'candidatesByManager',
            'managers',
            'candidatesByTeam',
            'team_leader',
            'candidatesByConsultent',
            'consultents',
            'followUps',
            'interviews',
            'blackListed',
            'assignToClients',
            'kivs',
            'activeResumes',
        ));
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('clients.index')) {
            abort(403, 'Unauthorized');
        }

        $datas = client::latest()->with('industry_type', 'Employee');

        $auth = Auth::user()->employe;
        if ($auth->roles_id == 7) {
            $datas->where('payroll_employees_id', $auth->id);
        } elseif($auth->roles_id == 8) {
            $datas->where('consultant_id', $auth->id);
        } elseif($auth->roles_id == 11) {
            $datas->where('team_leader_id', $auth->id);
        } elseif($auth->roles_id == 4) {
            $datas->where('manager_id', $auth->id);
        }

        $datas = $datas->get();

        return view('admin.client.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('clients.create')) {
            abort(403, 'Unauthorized');
        }

        $data = [];
        $auth = Auth::user()->employe;
        $incharges = Employee::select('id', 'employee_name')->latest();

        if ($auth->roles_id == 8) {
            $incharges->where('id', $auth->id);
        } elseif ($auth->roles_id == 11) {
            $incharges->where('team_leader_users_id', $auth->id);
        } elseif ($auth->roles_id == 4) {
            $incharges->where('manager_users_id', $auth->id);
        }

        $data['incharges'] = $incharges->whereIn('roles_id', [4, 8, 11, 12])->get()->toArray();

        if ($auth->roles_id != 1) {
            // Create a new array representing the authenticated user
            $newIncharge = [
                'id' => $auth->id,
                'employee_name' => $auth->employee_name,
            ];

            // Append the new array to the existing array of $data['incharges']
            $data['incharges'][] = $newIncharge;
        }

        // return $data['incharges'];
        $data['payrolls'] = Employee::select('id', 'employee_name')->latest()->whereIn('roles_id', [7, 13, 14])->get();
        $data['tncs'] = TncTemplate::orderBy('tnc_template_seqno')->where('tnc_template_status', 1)->select('id', 'tnc_template_code')->get();
        $data['client_terms'] = clientTerm::orderBy('client_term_seqno')->where('client_term_status', 1)->select('id', 'client_term_code')->get();
        $data['job_categories'] = jobcategory::select('id', 'jobcategory_name')->get();

        return view('admin.client.create', compact('data'));
    }

    public function store(ClientRequest $request)
    {
        $request['client_contact_number'] = $request->country_code .' '. $request['client_contact_number'];
        $request['client_phone'] = $request->client_country_code .' '. $request['client_phone'];

        if (is_null($this->user) || !$this->user->can('clients.store')) {
            abort(403, 'Unauthorized');
        }

        $team = get_team($request['employees_id']);
        $request['manager_id'] = $team['manager_id'];
        $request['team_leader_id'] = $team['team_leader_id'];
        $request['consultant_id'] = $team['consultant_id'];

        $client = client::create($request->except('_token'));

        $auth = Auth::user()->employe;
        ClientFollowUp::create([
            'clients_id' => $client->id,
            'description' => 'Client created',
            'created_by' => $auth->id,
            'modify_by' => $auth->id,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client added successfully.');
    }

    public function show(client $client)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(client $client)
    {
        if (is_null($this->user) || !$this->user->can('clients.edit')) {
            abort(403, 'Unauthorized');
        }

        $auth = Auth::user()->employe;

        $manager_id = null;
        $team_leader_id = null;
        $consultant_id = null;

        if ($auth->roles_id == 11) {
            $team_leader_id = $auth->id;
        } elseif($auth->roles_id == 4) {
            $manager_id = $auth->id;
        } elseif($auth->roles_id == 8) {
            $consultant_id = $auth->id;
        }

        if ($client->team_leader_id == $team_leader_id || $auth->roles_id == 1 || $client->manager_id == $manager_id|| $client->consultent_id == $consultant_id) {
            $data = [];

            $data['incharges'] = Employee::select('id', 'employee_name')->latest()->whereIn('roles_id', [4, 8, 11, 12])->get();
            $data['payrolls'] = Employee::select('id', 'employee_name')->latest()->where('roles_id', 7)->get();
            $data['tncs'] = TncTemplate::orderBy('tnc_template_seqno')->where('tnc_template_status', 1)->select('id', 'tnc_template_code')->get();
            $data['client_terms'] = clientTerm::orderBy('client_term_seqno')->where('client_term_status', 1)->select('id', 'client_term_code')->get();
            $data['job_categories'] = jobcategory::select('id', 'jobcategory_name')->get();
            $data['departments'] = ClientDepartment::where('client_id', $client->id)->latest()->get();
            $data['fileTypes'] = uploadfiletype::where('uploadfiletype_status', 1)->where('uploadfiletype_for', 0)->latest()->get();

            $data['client_files'] = ClientUploadFile::where('client_id', $client->id)->get();
            $data['client_followup'] = ClientFollowUp::where('clients_id', $client->id)->orderBy('created_at', 'DESC')->get();

            return view('admin.client.edit', compact('data', 'client'));
        } else {
           return redirect()->back()->with('error', 'Sorry! You enter invalid Client id');
       }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, client $client)
    {
        if (is_null($this->user) || !$this->user->can('clients.update')) {
            abort(403, 'Unauthorized');
        }

        $request['client_contact_number'] = $request->country_code . ' ' . $request['client_contact_number'];
        $request['client_phone'] = $request->client_country_code . ' ' . $request['client_phone'];
        $team = get_team($request['employees_id']);
        $request['manager_id'] = $team['manager_id'];
        $request['team_leader_id'] = $team['team_leader_id'];
        $request['consultant_id'] = $team['consultant_id'];
        $client->update($request->except('_token'));

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(client $client)
    {
        if (is_null($this->user) || !$this->user->can('candidate.destroy')) {
            abort(403, 'Unauthorized');
        }
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }

    public function fileUpload(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.file.upload')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'file_path' => 'required|mimes:pdf|max:2048',
            'file_type_id' => 'required',
        ]);

        $file_path = $request->file('file_path');

        // Check if $file_path is not empty before proceeding

        if ($file_path) {
            $uploadedFilePath = FileHelper::uploadFile($file_path, 'client');

            $employee = Auth::user()->id;
            ClientUploadFile::create([
                'client_id' => $id,
                'file_path' => $uploadedFilePath,
                'file_type_id' => $request->file_type_id,
                'created_by' => $employee,
                'modify_by' => $employee,
            ]);

            $url = '/ATS/clients/' . $id . '/edit#upload_file';
            return redirect($url)->with('success', 'Created successfully.');
        } else {
            $url = '/ATS/clients/' . $id . '/edit#upload_file';
            return redirect($url)->with('error', 'Please select a file.');
        }
    }
    public function fileDelete($id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.file.delete')) {
            abort(403, 'Unauthorized');
        }
        $file_path_name = ClientUploadFile::where('id', $id)->value('file_path');

        $filePath = storage_path("app/public/{$file_path_name}");

        if (file_exists($filePath)) {
            Storage::delete("public/{$file_path_name}");
        }
        ClientUploadFile::where('id', $id)->delete();
        $url = '/ATS/clients/' . request()->file_delete . '/edit#upload_file';
        return redirect($url)->with('success', 'Successfully Deleted.');
    }
    public function followUp(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.followup')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'description' => 'required',
            'clients_id' => 'required'
        ]);
        $employee = Auth::user()->id;
        ClientFollowUp::create([
            'description' => $request->description,
            'clients_id' => $request->clients_id,
            'created_by' => $employee,
            'modify_by' => $employee,
        ]);

        $url = '/ATS/clients/' . $request->clients_id . '/edit#follow_up';

        return redirect($url)->with('success', 'Follow up added successfully.');
    }

    public function folowupDelete($id)
    {
        if (is_null($this->user) || !$this->user->can('candidate.followup.delete')) {
            abort(403, 'Unauthorized');
        }

        ClientFollowUp::where('id', $id)->delete();

        $url = '/ATS/clients/' . request()->followup_delete . '/edit#follow_up';

        return redirect($url)->with('success', 'Successfully Deleted.');
    }

    public function clientImport(Request $request)
    {
        Excel::import(new ClientImport, $request->file('client_import_file'));
    }

    public function clientDepartmentStore(Request $request)
    {
        $request->validate([
            'client_id' => 'required|integer',
            'name' => 'string|required',
            'remarks' => 'nullable',
        ]);

        ClientDepartment::create([
            'client_id' => $request->client_id,
            'name' => $request->name,
            'remarks' => $request->remarks
        ]);

        $url = '/ATS/clients/' . $request->client_id . '/edit#department';

        return redirect($url)->with('success', 'Successfully Created.');
    }

    public function clientDepartmentDelete($id)
    {
        ClientDepartment::find($id)->delete();

        $url = '/ATS/clients/' . request()->department_delete . '/edit#department';
        return redirect($url)->with('success', 'Successfully Deleted.');
    }

    public function supervisorStore(Request $request, client $client)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'department' => 'string',
            'direct_number' => 'string',
            'remark' => 'string',
            'defination' => 'string',
            'log_email' => 'required|email',
        ]);

        $url = '/ATS/clients/' . $client->id . '/edit#supervisor';
        if ($validator->fails()) {
            return redirect($url)
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->log_email,
                'password' => bcrypt($request->password),
                'role' => 9,
            ]);

            ClientSupervisor::create([
                'client_id' => $client->id,
                'user_id' => $user->id,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'department' => $request->department,
                'direct_number' => $request->direct_number,
                'remark' => $request->remark,
                'defination' => $request->defination,
            ]);

            DB::commit();
            return redirect($url)->with('success', 'Successfully Added.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect($url)->with('error', $e->getMessage());
        }
    }

    public function deleteSupervisor(ClientSupervisor $supervisor)
    {
        $url = '/ATS/clients/' . $supervisor->client_id . '/edit#supervisor';
        DB::beginTransaction();

        try {
            User::destroy($supervisor->user_id);

            $supervisor->delete();
            DB::commit();
            return redirect($url)->with('success', 'Successfully Added.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect($url)->with('error', $e->getMessage());
        }
    }


    public function updateFollowUp(Request $request, $id)
    {

        $request->validate([
            'description' => 'required',
            'clients_id' => 'required'
        ]);

        $followup = ClientFollowUp::find($id);

        $followup->update([
            'description' => $request->description,
            'clients_id' => $request->clients_id
        ]);

        $url = '/ATS/clients/' . $request->clients_id . '/edit#follow_up';

        return redirect($url)->with('success', 'Follow up added successfully.');
    }

    public function getClientRemark(client $client)
    {
        $remarks = [];
        foreach ($client->followUps()->orderByDesc('created_at')->get() as $key => $remark) {
            $remarkData = [
                'created_by' => $remark->client->client_name,
                'description' => $remark->description,
                'create_time' => Carbon::parse($remark->created_at)->format('h:i a'),
                'create_date' => Carbon::parse($remark->created_at)->format('j M Y')
            ];
            $remarks[] = $remarkData;
        }
        return response()->json(['remarks' => $remarks]);
    }

    public function client_tnctemplate_download(client $client)
    {
        $file_path = public_path('/storage/'.$client->tnc_template->tnc_template_file_path);
        $file_name = basename($file_path);
        $output_directory = public_path('/storage/tnc/convert/');
        $output_file_path = $output_directory . $file_name;
        if (!is_dir($output_directory)) {
            mkdir($output_directory, 0777, true);
        }

        $this->file_convert($file_path, $output_file_path);

        return response()->file($output_file_path);
    }

    private function file_convert($file_path, $output_file_path)
    {
        $fpdi = new Fpdi();
        $count = $fpdi->setSourceFile($file_path);

        // Add a blank page before the existing pages
        $fpdi->AddPage();

        // Add content to the blank page
        $this->addTextToPage($fpdi, $this->text(), 10);

        $this->addCustomTextToPage($fpdi, $this->customText(), 55, 30);

        // Loop through existing pages and add content
        for ($i = 1; $i <= $count; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);

            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            // Add content to the current page
            $this->addTextToPage($fpdi, $this->text(), 10);
        }

        return $fpdi->Output($output_file_path, 'F');
    }

    private function customText()
    {
        return [
            [date('d M, Y', strtotime(now())), "Arial", "", 11, [0, 0, 0], 1],
            ["", "Arial", "", 12, [0, 0, 0], .7],
            ["Stell \nSatsaco Group Pte Ltd", "Arial", "B", 11, [0, 0, 0], .4],
            ["", "Arial", "", 12, [0, 0, 0], .7],
            ["Dear Stell,", "Arial", "", 12, [0, 0, 0], 1],
            ["", "Arial", "", 12, [0, 0, 0], .7],
            ["RE : TERMS AND CONDITIONS FOR RECRUITMENT OF PERMANENT \n STAFF/ CONTRACT STAFF/TEMPORARY STAFF", "Arial", "BU", 13, [0, 0, 0], .4],
            ["", "Arial", "", 12, [0, 0, 0], .7],
            ["We enclose here with a set of our Terms and Conditions for your perusal and retention.", "Arial", "", 12, [0, 0, 0], .4],
            ["", "Arial", "", 12, [0, 0, 0], .5],
            ["If the terms and conditions are acceptable, kindly confirm by counter-signing and return to us via scan/fax.", "Arial", "", 12, [0, 0, 0], .4],
            ["", "Arial", "", 12, [0, 0, 0], .5],
            ["We thank you for giving us the opportunity to be of service to your esteemed organization.", "Arial", "", 12, [0, 0, 0], .5],
            ["", "Arial", "", 12, [0, 0, 0], 1.4],
            ["Yours Faithfully \n for SUCCESS RESOURCE CENTRE PTE LTD", "Arial", "", 12, [0, 0, 0], .4],
            ["", "Arial", "", 12, [0, 0, 0], 1.4],
            ["Jansen Chua", "Arial", "I", 12, [39, 191, 49], .3],
            ["Jansen Chua", "Arial", "", 12, [0, 0, 0], .3],
        ];

    }

    private function addTextToPage($fpdi, $textLinesWithStyles, $top)
    {
        foreach ($textLinesWithStyles as $textWithStyle) {
            $top = $top + 5;

            list($text, $font, $style, $size, $color) = $textWithStyle;
            $fpdi->SetFont($font, $style, $size);
            $fpdi->SetTextColor($color[0], $color[1], $color[2]);
            $textWidth = $fpdi->GetStringWidth($text);
            $width = (int)$fpdi->GetPageWidth();
            $x = ($width - $textWidth) / 2;
            $fpdi->Text($x, $top, $text);
        }
    }

    private function addCustomTextToPage($fpdi, $textLinesWithStyles, $top)
    {
        $leftMargin = 20;
        $rightMargin = 20;

        $defaultFont = "Arial";
        $defaultSize = 12;
        $defaultColor = [0, 0, 0];

        $fpdi->SetFont($defaultFont, "", $defaultSize);
        $fpdi->SetTextColor(...$defaultColor);
        $availableWidth = $fpdi->GetPageWidth() - $leftMargin - $rightMargin;

        foreach ($textLinesWithStyles as $line) {
            list($text, $font, $style, $size, $color, $lineHeightMultiplier) = $line;

            $lineHeight = $lineHeightMultiplier * $size;
            $leftPosition = $leftMargin;

            $fpdi->SetFont($font, $style, $size);
            $fpdi->SetTextColor(...$color);
            $fpdi->SetXY($leftPosition, $top);
            $fpdi->MultiCell($availableWidth, $lineHeight, $text);
            $top += $lineHeight;
        }
    }



    private function text()
    {
        return [
            ["SUCCESS RESOURCE CENTRE PTE LTD", "Arial", "B", 15, [39, 191, 49]],
            ["3 Shenton Way, #19-01 Shenton House, Singapore 068805", "Arial", "", 10, [16, 16, 16]],
            ["Tel: 63373183 Fax: 63370329 / 63370425", "Arial", "", 10, [16, 16, 16]],
            ["Email: jansen@successhrc.com.sg", "Arial", "", 10, [16, 16, 16]],
            ["Registration Number:", "Arial", "", 10, [16, 16, 16]],
            ["EA License Number: 04C3201", "Arial", "", 10, [16, 16, 16]]
        ];
    }
}
