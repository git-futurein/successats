@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('page-title')
    Dashboard
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link href="{{ URL::asset('build/libs/fullcalendar/main.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')
    <style>
        .fc-event-time {
            display: none;
        }

        .fc-daygrid-event-dot {
            display: none;
        }

        .fixed-table-container {
            position: fixed;
            bottom: 0;
            width: 78%;
            background-color: #fff;
            border-top: 1px solid #ddd;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            height: 250px;
            overflow: scroll;
        }

        @keyframes slideInFromBottom {
            from {
                transform: translate3d(0, 100%, 0);
            }

            to {
                transform: translate3d(0, 0, 0);
            }
        }

        .modal.bottom .modal-dialog {
            animation: slideInFromBottom 0.8s ease-out;
            transform-origin: 50% 100%;
            height: 400px;
            margin: 0;
        }

        .modal.bottom .modal-content {
            width: 100vw;
            border-radius: 0;
        }

        .form-select {
            font-size: 0.8rem;
            line-height: 1;
            padding: 0 0.8rem;
            margin: 0;
        }
    </style>
    <body>
@endsection
@section('content')
    @php
        $auth = Auth::user()->employe;
    @endphp
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @if ($own_manager != [])
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="accordion accordion-flush-man" id="accordionFlushExample">
                                        <div class="accordion-item">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapse-own-manager"
                                                    aria-expanded="false" aria-controls="flush-collapse-own-manager">
                                                    Own Manager: - {{ count($own_manager) }} Resumes
                                                </button>
                                            </h2>
                                            <div id="flush-collapse-own-manager" class="accordion-collapse collapse"
                                                aria-labelledby="flush-heading-own-manager"
                                                data-bs-parent="#accordionFlushExample" style="">
                                                <table class="table table-bordered mb-0 dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Candidate Name</th>
                                                            <th>Candidate Email</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($own_manager ?? [] as $manager)

                                                            <tr>
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ $manager->candidate->candidate_name }}</td>
                                                                <td>{{ $manager->candidate->candidate_email }}</td>
                                                                <td class="d-flex flex-row">
                                                                    @php
                                                                        $main = \App\Models\CandidateResume::where('candidate_id', $manager->candidate->id)->where('isMain', 1)->first();
                                                                        if($main != null)
                                                                        {
                                                                            $resume_file_path = $main->resume_file_path;
                                                                        } else{
                                                                            $resume_file_path = null;
                                                                        }
                                                                    @endphp
                                                                    {{-- @if($resume_file_path != null) --}}
                                                                    <a title="Add Remarks"  class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$manager->candidate['id'].'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                    <button title="Show Resume" type="button"
                                                                        class="btn btn-info me-2 resumePath btn-sm"
                                                                        data-bs-toggle="modal" data-bs-target="#showResume"
                                                                        data-file-path="{{$resume_file_path }}" {{ $resume_file_path != null ? '' : 'disabled' }}>D</button>
                                                                    {{-- @endif --}}
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div><!-- end accordion -->
                                </div><!-- end card-body -->
                            </div>
                        </div>
                    @endif
                    @foreach ($managers as $key => $manager)
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="accordion accordion-flush-man" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-heading{{ $loop->index }}">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapse{{ $loop->index }}"
                                                    aria-expanded="false" aria-controls="flush-collapse{{ $loop->index }}">
                                                    Managers: {{ $manager->employee_name }} - {{ count($candidatesByManager[$manager->id]) }} Resumes
                                                </button>
                                            </h2>
                                            <div id="flush-collapse{{ $loop->index }}" class="accordion-collapse collapse"
                                                aria-labelledby="flush-heading{{ $loop->index }}"
                                                data-bs-parent="#accordionFlushExample" style="">
                                                <table class="table table-bordered mb-0 dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Candidate Name</th>
                                                            <th>Candidate Email</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($candidatesByManager[$manager->id] ?? [] as $dashboard)

                                                            <tr>
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ $dashboard->candidate->candidate_name }}</td>
                                                                <td>{{ $dashboard->candidate->candidate_email }}</td>
                                                                <td class="d-flex flex-row">
                                                                    @php
                                                                        $main = \App\Models\CandidateResume::where('candidate_id', $dashboard->candidate->id)->where('isMain', 1)->first();
                                                                        if($main != null)
                                                                        {
                                                                            $resume_file_path = $main->resume_file_path;
                                                                        } else{
                                                                            $resume_file_path = null;
                                                                        }
                                                                    @endphp
                                                                    {{-- @if($resume_file_path != null) --}}
                                                                    <a title="Add Remarks"  class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$dashboard->candidate['id'].'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                    <button title="Show Resume" type="button"
                                                                        class="btn btn-info me-2 resumePath btn-sm"
                                                                        data-bs-toggle="modal" data-bs-target="#showResume"
                                                                        data-file-path="{{$resume_file_path }}" {{ $resume_file_path != null ? '' : 'disabled' }}>D</button>
                                                                    {{-- @endif --}}
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div><!-- end accordion -->
                                </div><!-- end card-body -->
                            </div>
                        </div>
                    @endforeach
                    @foreach ($team_leaders as $team)
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="accordion accordion-flush" id="accordionFlushExample-tl-{{$team->id}}">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-heading_lead{{ $loop->index }}">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapse-tl{{ $loop->index }}"
                                                    aria-expanded="false"
                                                    aria-controls="flush-collapse-tl{{ $loop->index }}">
                                                    Team Leader: {{ $team->employee_name }} - {{ count($candidatesByTeam[$team->id]) }} Resumes
                                                </button>
                                            </h2>
                                            <div id="flush-collapse-tl{{ $loop->index }}" class="accordion-collapse collapse"
                                                aria-labelledby="flush-heading_lead{{ $loop->index }}"
                                                data-bs-parent="#accordionFlushExample-tl-{{$team->id}}" style="">
                                                <table class="table table-bordered mb-0 dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Candidate Name</th>
                                                            <th>Candidate Email</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($candidatesByTeam[$team->id] ?? [] as $team_leader)
                                                            <tr>
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ $team_leader->candidate->candidate_name }}</td>
                                                                <td>{{ $team_leader->candidate->candidate_email }}</td>
                                                                <td class="d-flex flex-row">
                                                                    @php
                                                                        $main = \App\Models\CandidateResume::where('candidate_id', $team_leader->candidate->id)->where('isMain', 1)->first();
                                                                        if($main != null)
                                                                        {
                                                                            $resume_file_path = $main->resume_file_path;
                                                                        } else{
                                                                            $resume_file_path = null;
                                                                        }
                                                                    @endphp
                                                                    {{-- @if($resume_file_path != null) --}}
                                                                    <a title="Add Remarks" class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$team_leader->candidate->id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                    <button title="Show Resume" type="button"
                                                                        class="btn btn-info me-2 resumePath btn-sm"
                                                                        data-bs-toggle="modal" data-bs-target="#showResume"
                                                                        data-file-path="{{$resume_file_path }}" {{ $resume_file_path != null ? '' : 'disabled' }}>D</button>
                                                                    {{-- @endif --}}
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div><!-- end accordion -->
                                </div><!-- end card-body -->
                            </div>
                        </div>
                    @endforeach
                    @foreach ($consultants as $consultant)
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="accordion accordion-flush" id="accordionFlushExample_con-{{$consultant->id}}">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-heading-con{{ $loop->index }}">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapse-con{{ $loop->index }}"
                                                    aria-expanded="false"
                                                    aria-controls="flush-collapse-con{{ $loop->index }}">
                                                    {{ $consultant->id == $auth->id ? 'Manage Own' : 'Consultant: '. $consultant->employee_name }} - {{ count($candidatesByConsultent[$consultant->id]) }} Resumes
                                                </button>
                                            </h2>
                                            <div id="flush-collapse-con{{ $loop->index }}" class="accordion-collapse collapse"
                                                aria-labelledby="flush-heading-con{{ $loop->index }}"
                                                data-bs-parent="#accordionFlushExample_con-{{$consultant->id}}" style="">
                                                <table class="table table-bordered mb-0 dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Candidate Name</th>
                                                            <th>Candidate Email</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($candidatesByConsultent[$consultant->id] ?? [] as $consultant)
                                                            <tr>
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ $consultant->candidate->candidate_name }}</td>
                                                                <td>{{ $consultant->candidate->candidate_email }}</td>
                                                                <td class="d-flex flex-row">
                                                                    @php
                                                                        $main = \App\Models\CandidateResume::where('candidate_id', $consultant->candidate->id)->where('isMain', 1)->first();
                                                                        if($main != null)
                                                                        {
                                                                            $resume_file_path = $main->resume_file_path;
                                                                        } else{
                                                                            $resume_file_path = null;
                                                                        }
                                                                    @endphp
                                                                    {{-- @if($resume_file_path != null) --}}
                                                                    <a title="Add Remarks" class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$consultant->candidate->id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                    <button title="Show Resume" type="button"
                                                                        class="btn btn-info me-2 resumePath btn-sm"
                                                                        data-bs-toggle="modal" data-bs-target="#showResume"
                                                                        data-file-path="{{$resume_file_path }}" {{ $resume_file_path != null ? '' : 'disabled' }}>D</button>
                                                                    {{-- @endif --}}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-active-resume" id="accordionactive-resumeExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="active-resume-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#active-resume-collapse"
                                                aria-expanded="false" aria-controls="active-resume-collapse">
                                                Active Resume
                                            </button>
                                        </h2>
                                        <div id="active-resume-collapse" class="accordion-collapse collapse p-2"
                                            aria-labelledby="active-resume-heading"
                                            data-bs-parent="#accordionactive-resumeExample" style="">
                                            <h5 class="bg-success px-4 py-1 text-white">Candidates Detail</h5>
                                            <table class="table table-bordered mb-0 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                        @else
                                                            <th>Manager</th>
                                                        @endif
                                                        <th>Consultant / Leader</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($activeResumes ?? [] as $candidate)
                                                        <tr style="cursor: pointer" class="accordion-row"
                                                            id="{{ $candidate['candidate_id'] }}"
                                                            data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                            <td>{{ $candidate->candidate['candidate_home_phone'] }}</td>
                                                            <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                            @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                            @else
                                                                <td>{{ $candidate->candidate['manager']['employee_name'] ?? '' }}
                                                                </td>
                                                            @endif
                                                            <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                            </td>
                                                            <td class="d-flex flex-row">
                                                                @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                    @include('admin.dashboard.inc.select')
                                                                @endif
                                                                <a title="Add Remarks" class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                @if($candidate->candidate->getMainResumeFilePath() != null)
                                                                <button title="Show Resume" type="button"
                                                                    class="btn btn-info me-2 resumePath  btn-sm"
                                                                    data-bs-toggle="modal" data-bs-target="#showResume"
                                                                    data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                @endif
                                                                <a title="Block" onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath">X</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-follow_ups" id="follow_ups">
                                    <div class="accordion-item">
                                        {{-- {{ $loop->index }} --}}
                                        <h2 class="accordion-header" id="follow_ups-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#follow_ups-collapse"
                                                aria-expanded="false" aria-controls="follow_ups-collapse">
                                                Follow Ups
                                            </button>
                                        </h2>

                                        <div id="follow_ups-collapse" class="accordion-collapse collapse p-2"
                                            aria-labelledby="follow_ups-heading" data-bs-parent="#follow_ups"
                                            style="">
                                            <h5 class="bg-success px-4 py-1 text-white">Candidates Detail</h5>

                                            @foreach ($followUps ?? [] as $day => $candidates)
                                                <p class="bg-info px-4 py-1 text-bold mt-2"><strong>Day
                                                        {{ $day >= 6 ? 'More Then 5 Day' : $day }}</strong></p>
                                                <table class="table table-bordered mb-0 dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Candidate Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                            @else
                                                                <th>Manager</th>
                                                            @endif
                                                            <th>Consultant / Leader</th>
                                                            <th>Date Time</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($candidates ?? [] as $candidate)
                                                            <tr style="cursor: pointer" class="accordion-row"
                                                                id="{{ $candidate['candidate_id'] }}"
                                                                data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                                <td>{{ $candidate->candidate['candidate_home_phone'] }}
                                                                </td>
                                                                <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                                @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                                @else
                                                                    <td>{{ $candidate->candidate['manager']['employee_name'] ?? '' }}
                                                                    </td>
                                                                @endif
                                                                <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($candidate->candidate['created_at'])->format('d-M-Y') }}
                                                                </td>
                                                                <td class="d-flex flex-row">
                                                                     @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                        @include('admin.dashboard.inc.select')
                                                                    @endif
                                                                    <a title="Add Remarks" class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                    @if($candidate->candidate->getMainResumeFilePath() != null)
                                                                        <button  title="Show Resume" type="button"
                                                                            class="btn btn-info btn-sm me-2 resumePath  btn-sm"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#showResume"
                                                                            data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                    @endif
                                                                    <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath  btn-sm">X</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-blacklist" id="blacklist">
                                    <div class="accordion-item">
                                        {{-- {{ $loop->index }} --}}
                                        <h2 class="accordion-header" id="blacklist-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#blacklist-collapse"
                                                aria-expanded="false" aria-controls="blacklist-collapse">
                                                Not Suitable/FAJ/Blacklist/Drop
                                            </button>
                                        </h2>

                                        <div id="blacklist-collapse" class="accordion-collapse collapse p-2"
                                            aria-labelledby="blacklist-heading" data-bs-parent="#blacklist"
                                            style="">
                                            <h5 class="bg-success px-4 py-1 text-white">Candidates Detail</h5>
                                            <table class="table table-bordered mb-0 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                        @else
                                                            <th>Manager</th>
                                                        @endif
                                                        <th>Consultant / Leader</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($blackListed ?? [] as $candidate)
                                                        {{-- remark_id --}}
                                                        <tr style="cursor: pointer" class="accordion-row"
                                                            id="{{ $candidate['candidate_id'] }}"
                                                            data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                            <td
                                                                class="{{ $candidate['remark_id'] == 8 ? 'text-danger' : '' }}">
                                                                {{ $loop->index + 1 }}</td>
                                                            <td
                                                                class="{{ $candidate['remark_id'] == 8 ? 'text-danger' : '' }}">
                                                                {{ $candidate->candidate['candidate_name'] }}</td>
                                                            <td
                                                                class="{{ $candidate['remark_id'] == 8 ? 'text-danger' : '' }}">
                                                                {{ $candidate->candidate['candidate_home_phone'] }}
                                                            </td>
                                                            <td
                                                                class="{{ $candidate['remark_id'] == 8 ? 'text-danger' : '' }}">
                                                                {{ $candidate->candidate['candidate_email'] }}
                                                            </td>
                                                            @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                            @else
                                                                <td class="{{ $candidate['remark_id'] == 8 ? 'text-danger' : '' }}">
                                                                {{ $candidate->candidate['manager']['employee_name'] ?? '' }}
                                                            </td>
                                                            @endif
                                                            <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                            </td>
                                                            <td class="d-flex flex-row {{ $candidate['remark_id'] == 8 ? 'text-danger' : '' }}">
                                                                @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                    @include('admin.dashboard.inc.select')
                                                                @endif
                                                                <a title="Add Remarks" class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                @if($candidate->candidate->getMainResumeFilePath() != null)
                                                                <button  title="Show Resume" type="button"
                                                                    class="btn btn-info me-2 resumePath btn-sm"
                                                                    data-bs-toggle="modal" data-bs-target="#showResume"
                                                                    data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                @endif
                                                                <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger me-2 resumePath btn-sm">X</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-kiv-heading" id="kiv">
                                    <div class="accordion-item">
                                        {{-- {{ $loop->index }} --}}
                                        <h2 class="accordion-header" id="kiv-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#kiv-collapse"
                                                aria-expanded="false" aria-controls="kiv-collapse">
                                                KIV
                                            </button>
                                        </h2>

                                        <div id="kiv-collapse" class="accordion-collapse collapse p-2"
                                            aria-labelledby="kiv-heading" data-bs-parent="#kiv" style="">
                                            <h5 class="bg-success px-4 py-1 text-white">Candidates Detail</h5>
                                            <table class="table table-bordered mb-0 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                        @else
                                                            <th>Manager</th>
                                                        @endif
                                                        <th>Consultant / Leader</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if (isset($kivs))
                                                        @foreach ($kivs ?? [] as $candidate)
                                                            <tr style="cursor: pointer" class="accordion-row"
                                                                id="{{ $candidate['candidate_id'] }}"
                                                                data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                                <td>{{ $candidate->candidate['candidate_home_phone'] }}
                                                                </td>
                                                                <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                                @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                                @else
                                                                    <td>{{ $candidate->candidate['manager']['employee_name'] ?? '' }}
                                                                </td>
                                                                @endif
                                                                <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                                </td>
                                                                <td class="d-flex flex-row">
                                                                    @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                        @include('admin.dashboard.inc.select')
                                                                    @endif
                                                                    <a title="Add Remarks" class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                    @if($candidate->candidate?->getMainResumeFilePath() != null)
                                                                    <button  title="Show Resume" type="button"
                                                                        class="btn btn-info btn-sm me-2 resumePath"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#showResume"
                                                                        data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                    @endif
                                                                    <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath">X</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-shortlist" id="shortlist">
                                    <div class="accordion-item p-2">
                                        {{-- {{ $loop->index }} --}}
                                        <h2 class="accordion-header" id="shortlist-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#shortlist-collapse"
                                                aria-expanded="false" aria-controls="shortlist-collapse ">
                                                Shortlisted Candidates
                                            </button>
                                        </h2>

                                        <div id="shortlist-collapse" class="accordion-collapse collapse"
                                            aria-labelledby="shortlist-heading" data-bs-parent="#shortlist"
                                            style="">
                                            <table class="table table-bordered mb-0 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        <th>Client Name</th>
                                                        <th>Consultant / Leader</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($shortlists ?? [] as $candidate)
                                                        <tr style="cursor: pointer" class="accordion-row"
                                                            id="{{ $candidate['candidate_id'] }}"
                                                            data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                            <td>{{ $candidate->candidate['candidate_home_phone'] }}
                                                            </td>
                                                            <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                            <td>{{ $candidate->client?->client_name }}</td>
                                                            <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                            </td>
                                                            <td class="d-flex flex-row">
                                                                @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                    @include('admin.dashboard.inc.select')
                                                                @endif
                                                                <a title="Add Remarks"  class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                @if($candidate->candidate?->getMainResumeFilePath() != null)
                                                                <button  title="Show Resume" type="button"
                                                                    class="btn btn-info btn-sm me-2 resumePath"
                                                                    data-bs-toggle="modal" data-bs-target="#showResume"
                                                                    data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                @endif
                                                                <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath">X</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-rework" id="rework">
                                    <div class="accordion-item p-2">
                                        {{-- {{ $loop->index }} --}}
                                        <h2 class="accordion-header" id="rework-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#rework-collapse"
                                                aria-expanded="false" aria-controls="rework-collapse ">
                                                Re-work
                                            </button>
                                        </h2>

                                        <div id="rework-collapse" class="accordion-collapse collapse"
                                            aria-labelledby="rework-heading" data-bs-parent="#rework"
                                            style="">
                                            <table class="table table-bordered mb-0 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        <th>Client Name</th>
                                                        <th>Consultant / Leader</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($rework ?? [] as $candidate)
                                                        <tr style="cursor: pointer" class="accordion-row"
                                                            id="{{ $candidate['candidate_id'] }}"
                                                            data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                            <td>{{ $candidate->candidate['candidate_home_phone'] }}
                                                            </td>
                                                            <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                            <td>{{ $candidate->client?->client_name }}</td>
                                                            <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                            </td>
                                                            <td class="d-flex flex-row">
                                                                @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                    @include('admin.dashboard.inc.select')
                                                                @endif
                                                                <a title="Add Remarks"  class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                @if($candidate->candidate?->getMainResumeFilePath() != null)
                                                                <button  title="Show Resume" type="button"
                                                                    class="btn btn-info btn-sm me-2 resumePath"
                                                                    data-bs-toggle="modal" data-bs-target="#showResume"
                                                                    data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                @endif
                                                                <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath">X</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-total-candidate" id="total-candidate">
                                    <div class="accordion-item p-2">
                                        {{-- {{ $loop->index }} --}}
                                        <h2 class="accordion-header" id="total-candidate-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#total-candidate-collapse"
                                                aria-expanded="false" aria-controls="total-candidate-collapse ">
                                                Assigned to Client
                                            </button>
                                        </h2>

                                        <div id="total-candidate-collapse" class="accordion-collapse collapse"
                                            aria-labelledby="total-candidate-heading" data-bs-parent="#total-candidate"
                                            style="">
                                            <table class="table table-bordered mb-0 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        <th>Client Name</th>
                                                        <th>Consultant / Leader</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($assignToClient[1] ?? [] as $candidate)
                                                        <tr style="cursor: pointer" class="accordion-row"
                                                            id="{{ $candidate['candidate_id'] }}"
                                                            data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                            <td>{{ $candidate->candidate['candidate_home_phone'] }}
                                                            </td>
                                                            <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                            <td>{{ $candidate->client?->client_name }}</td>
                                                            <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                            </td>
                                                            <td class="d-flex flex-row">
                                                                @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                    @include('admin.dashboard.inc.select')
                                                                @endif
                                                                <a title="Add Remarks"  class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                @if($candidate->candidate?->getMainResumeFilePath() != null)
                                                                <button  title="Show Resume" type="button"
                                                                    class="btn btn-info btn-sm me-2 resumePath"
                                                                    data-bs-toggle="modal" data-bs-target="#showResume"
                                                                    data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                @endif
                                                                <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath">X</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-twobusinessdayclients" id="twobusinessdayclients">
                                    <div class="accordion-item p-2">
                                        <h2 class="accordion-header" id="twobusinessdayclients-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#twobusinessdayclients-collapse"
                                                aria-expanded="false" aria-controls="twobusinessdayclients-collapse ">
                                                2 Business Days Follow Up with Client
                                            </button>
                                        </h2>

                                        <div id="twobusinessdayclients-collapse" class="accordion-collapse collapse"
                                            aria-labelledby="twobusinessdayclients-heading" data-bs-parent="#twobusinessdayclients"
                                            style="">
                                            <table class="table table-bordered mb-0 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        <th>Client Name</th>
                                                        <th>Consultant / Leader</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($assignToClient[2] ?? [] as $candidate)
                                                        <tr style="cursor: pointer" class="accordion-row"
                                                            id="{{ $candidate['candidate_id'] }}"
                                                            data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                            <td>{{ $candidate->candidate['candidate_home_phone'] }}
                                                            </td>
                                                            <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                            <td>{{ $candidate->client?->client_name }}</td>
                                                            <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                            </td>
                                                            <td class="d-flex flex-row">
                                                                @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                    @include('admin.dashboard.inc.select')
                                                                @endif
                                                                <a title="Add Remarks"  class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                @if($candidate->candidate?->getMainResumeFilePath() != null)
                                                                <button  title="Show Resume" type="button"
                                                                    class="btn btn-info btn-sm me-2 resumePath"
                                                                    data-bs-toggle="modal" data-bs-target="#showResume"
                                                                    data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                @endif
                                                                <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath">X</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($auth->roles_id == 8)
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-active-resume" id="accordionactive-resumeExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="active-resume-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#active-resume-collapse"
                                                aria-expanded="false" aria-controls="active-resume-collapse">
                                                New Candidate Assigned to You
                                            </button>
                                        </h2>
                                        <div id="active-resume-collapse" class="accordion-collapse collapse p-2"
                                            aria-labelledby="active-resume-heading"
                                            data-bs-parent="#accordionactive-resumeExample" style="">
                                            <h5 class="bg-success px-4 py-1 text-white">Candidates Detail</h5>
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                        @else
                                                            <th>Manager</th>
                                                        @endif
                                                        <th>Consultant / Leader</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($activeResumes ?? [] as $candidate)
                                                        <tr style="cursor: pointer" class="accordion-row"
                                                            id="{{ $candidate['candidate_id'] }}"
                                                            data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                            <td>{{ $candidate->candidate['candidate_home_phone'] }}</td>
                                                            <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                            @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                            @else
                                                                <td>{{ $candidate->candidate['manager']['employee_name'] ?? '' }}
                                                            </td>
                                                            @endif
                                                            <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                            </td>
                                                            <td class="d-flex flex-row">
                                                                @include('admin.dashboard.inc.select')
                                                                @if($candidate->candidate->getMainResumeFilePath() != null)
                                                                <a title="Add Remarks"  class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                <button  title="Show Resume" type="button"
                                                                    class="btn btn-info me-2 resumePath btn-sm"
                                                                    data-bs-toggle="modal" data-bs-target="#showResume"
                                                                    data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                @endif
                                                                <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath">X</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-callback" id="callback">
                                    <div class="accordion-item">
                                        {{-- {{ $loop->index }} --}}
                                        <h2 class="accordion-header" id="callback-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#callback-collapse"
                                                aria-expanded="false" aria-controls="callback-collapse">
                                                Call Back
                                            </button>
                                        </h2>

                                        <div id="callback-collapse" class="accordion-collapse collapse p-2"
                                            aria-labelledby="callback-heading" data-bs-parent="#callback"
                                            style="">
                                            <h5 class="bg-success px-4 py-1 text-white">Candidates Detail</h5>

                                            @foreach ($callbacks ?? [] as $day => $candidates)
                                                <p class="bg-info px-4 py-1 text-bold mt-2"><strong>Day
                                                        {{ $day >= 6 ? 'More Then 5 Day' : $day }}</strong></p>
                                                <table class="table table-bordered mb-0 dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Candidate Name</th>
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                            @else
                                                                <th>Manager</th>
                                                            @endif
                                                            <th>Consultant / Leader</th>
                                                            <th>Date Time</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($candidates ?? [] as $candidate)
                                                            <tr style="cursor: pointer" class="accordion-row"
                                                                id="{{ $candidate['candidate_id'] }}"
                                                                data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                                <td>{{ $candidate->candidate['candidate_home_phone'] }}
                                                                </td>
                                                                <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                                @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                                @else
                                                                    <td>{{ $candidate->candidate['manager']['employee_name'] ?? '' }}
                                                                </td>
                                                                @endif
                                                                <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($candidate->candidate['created_at'])->format('d-M-Y') }}
                                                                </td>
                                                                <td class="d-flex flex-row">
                                                                    @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                        @include('admin.dashboard.inc.select')
                                                                    @endif
                                                                    <a title="Add Remarks" class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                    @if($candidate->candidate->getMainResumeFilePath() != null)
                                                                        <button  title="Show Resume" type="button"
                                                                            class="btn btn-info btn-sm me-2 resumePath  btn-sm"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#showResume"
                                                                            data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                    @endif
                                                                    <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath  btn-sm">X</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-Interview" id="Interview">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="Interview-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#Interview-collapse"
                                                aria-expanded="false" aria-controls="Interview-collapse">
                                                Interviews
                                            </button>
                                        </h2>

                                        <div id="Interview-collapse" class="accordion-collapse collapse p-2"
                                            aria-labelledby="Interview-heading" data-bs-parent="#Interview"
                                            style="">
                                            <h5 class="bg-success px-4 py-1 text-white">Candidates Detail</h5>
                                            <table class="table table-bordered mb-0 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                        @else
                                                            <th>Manager</th>
                                                        @endif
                                                        <th>Consultant / Leader</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($interviewData ?? [] as $candidate)
                                                        <tr style="cursor: pointer" class="accordion-row"
                                                            id="{{ $candidate['candidate_id'] }}"
                                                            data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                            <td>{{ $candidate->candidate['candidate_home_phone'] }}
                                                            </td>
                                                            <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                            @if ($auth->roles_id == 8 || $auth->roles_id == 12)
                                                            @else
                                                                <td>{{ $candidate->candidate['manager']['employee_name'] ?? '' }}
                                                                </td>
                                                            @endif
                                                            </td>
                                                            <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                            </td>
                                                            <td class="d-flex flex-row">
                                                                 @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                    @include('admin.dashboard.inc.select')
                                                                @endif
                                                                <a title="Add Remarks" class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                @if($candidate->candidate->getMainResumeFilePath() != null)
                                                                <button  title="Show Resume" type="button"
                                                                    class="btn btn-info btn-sm me-2 resumePath btn-sm"
                                                                    data-bs-toggle="modal" data-bs-target="#showResume"
                                                                    data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                @endif
                                                                <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath btn-sm">X</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-threedaynoaction" id="threedaynoaction">
                                    <div class="accordion-item p-2">
                                        {{-- {{ $loop->index }} --}}
                                        <h2 class="accordion-header" id="threedaynoaction-heading">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#threedaynoaction-collapse"
                                                aria-expanded="false" aria-controls="threedaynoaction-collapse ">
                                                Three Days No Action
                                            </button>
                                        </h2>

                                        <div id="threedaynoaction-collapse" class="accordion-collapse collapse"
                                            aria-labelledby="threedaynoaction-heading" data-bs-parent="#threedaynoaction"
                                            style="">
                                            <table class="table table-bordered mb-0 dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th style="width: 100px">Mobile</th>
                                                        <th>Email</th>
                                                        <th>Client Name</th>
                                                        <th>Consultant / Leader</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($threedaynoaction ?? [] as $candidate)
                                                        <tr style="cursor: pointer" class="accordion-row"
                                                            id="{{ $candidate['candidate_id'] }}"
                                                            data-candidate-name="{{ $candidate->candidate['candidate_name'] }}">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $candidate->candidate['candidate_name'] }}</td>
                                                            <td>{{ $candidate->candidate['candidate_home_phone'] }}
                                                            </td>
                                                            <td>{{ $candidate->candidate['candidate_email'] }}</td>
                                                            <td>{{ $candidate->client?->client_name }}</td>
                                                            <td>{{ $candidate->candidate?->consultant?->employee_code ?? $candidate->candidate?->team_leader?->employee_code }}
                                                            </td>
                                                            <td class="d-flex flex-row">
                                                                 @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                                    @include('admin.dashboard.inc.select')
                                                                @endif
                                                                <a title="Add Remarks"  class="btn btn-warning btn-sm me-2 resumePath" href="{{ URL::to('/ATS/candidate/'.$candidate->candidate_id.'/edit#remark') }}"><i class="fas fa-plus"></i> R</a>
                                                                @if($candidate->candidate?->getMainResumeFilePath() != null)
                                                                <button  title="Show Resume" type="button"
                                                                    class="btn btn-info btn-sm me-2 resumePath"
                                                                    data-bs-toggle="modal" data-bs-target="#showResume"
                                                                    data-file-path="{{ $candidate->candidate->getMainResumeFilePath() }}">D</button>
                                                                @endif
                                                                <a onclick="changeRemarkBlock({{ $candidate['id'] }})" class="btn btn-danger btn-sm me-2 resumePath">X</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed-table-container" id="resumeTable" style="display: none">
            <div class="d-flex bd-highlight">
                <div class="flex-grow-1 bd-highlight">
                    <h6><span id="cand_name"></span> Remarks</h6>
                </div>
                <div class="bd-highlight" style="margin: 0">
                    <h1 onclick="removeRemark()" style="cursor: pointer; margin: 0 0 0;">-</h1>
                </div>
            </div>

            <table class="table" id="resumeDataTable">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Client</th>
                        <th scope="col">Remark Type</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Create By</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody id="candidateResume">

                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

        <div style='clear:both'></div>

        @include('admin.candidate.inc.resume__modal')
    @endsection
    @section('scripts')
        <link rel="stylesheet" type="text/css"
            href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css" />
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <script src="{{ URL::asset('build/libs/fullcalendar/main.min.js') }}"></script>
        {{-- <script src="{{ URL::asset('build/js/pages/calendar.init.js') }}"></script> --}}
        <script>
            // Get all accordion items
            const accordionItems = document.querySelectorAll('.accordion-item');

            // Add event listener to each accordion item
            accordionItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Close all accordion items except the clicked one
                    accordionItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            const collapse = otherItem.querySelector('.accordion-collapse');
                            const accordionButton = otherItem.querySelector('.accordion-button');
                            if (collapse.classList.contains('show')) {
                                collapse.classList.remove('show');
                                accordionButton.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                let defaultEvents = @json($calander_datas);

                /* initialize the calendar */
                let calendarEl = document.getElementById('calendar');

                let calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    themeSystem: 'bootstrap',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    events: defaultEvents,
                    eventClick: function(info) {
                        if (info.event.extendedProps && info.event.extendedProps.url) {
                            // Open the URL in a new tab
                            window.open(info.event.extendedProps.url, '_blank');
                        }
                    },
                    eventMouseEnter: function(info) {
                        $(info.el).tooltip({
                            title: info.event.title,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                        $(info.el).tooltip('show');
                    },
                });
                calendar.render();
            });
        </script>
        <script>
            $(document).ready(function() {
                $('.dataTable').DataTable();
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let rows = document.querySelectorAll('.accordion-row');
                let dataTableInitialized = false;

                rows.forEach(function(row) {
                    row.addEventListener('click', function() {
                        let candidate_id = this.getAttribute('id');

                        let candidate_name = this.getAttribute('data-candidate-name');
                        document.getElementById('cand_name').innerHTML = candidate_name;

                        $.ajax({
                            type: 'GET',
                            url: '/ATS/get/candidate/remarks/' + candidate_id,
                            success: function(response) {
                                console.log(response);
                                let resumeTable = document.getElementById('resumeTable');

                                if (resumeTable.style.display === 'none') {
                                    resumeTable.style.display = 'block';
                                }

                                let remarkData = response.remarks;
                                if (dataTableInitialized) {
                                    $('#resumeDataTable').DataTable().destroy();
                                }
                                $('#candidateResume').empty();
                                for (let i = 0; i < remarkData.length; i++) {
                                    let count = 1 + i;
                                    let newRowHtml = '<tr>' +
                                        '<th scope="row">' + count + '</th>' +
                                        '<td>' + remarkData[i].candidate_name + '</td>' +
                                        '<td>' + remarkData[i].remarkstype + '</td>' +
                                        '<td>' + remarkData[i].remarks + '</td>' +
                                        '<td>' + remarkData[i].created_by + '</td>' +
                                        '<td>' + remarkData[i].date + '</td>' +
                                        '</tr>';

                                    $('#candidateResume').append(newRowHtml);
                                }

                                if (!dataTableInitialized) {
                                    $('#resumeDataTable').DataTable({
                                        "pageLength": 3
                                    });
                                    dataTableInitialized = true;
                                } else {
                                    $('#resumeDataTable').DataTable().destroy();
                                    $('#resumeDataTable').DataTable({
                                        "pageLength": 3
                                    });
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.resumePath').on('click', function() {
                    let filePath = $(this).data('file-path');
                    const iframe = document.getElementById('pdfViewer');
                    if (filePath) {
                        let publicUrl = "{{ asset(Storage::url('')) }}" + "/" + filePath;

                        // Check if the publicUrl exists
                        $.ajax({
                            url: publicUrl,
                            type: 'HEAD',
                            success: function() {
                                $('#pdfViewer').show();
                                // File exists
                                iframe.src = publicUrl;
                                iframe.width = "100%";
                                iframe.height = "600px";
                                $('#noCVMessage').hide();
                            },
                            error: function() {
                                $('#pdfViewer').hide();
                                $('#noCVMessage').show();
                            }
                        });
                    } else {
                        // If filePath is empty or invalid
                        iframe.src = ''; // Clear the iframe src
                        iframe.width = "0";
                        iframe.height = "0";
                    }
                });

            });

            $(function() {
                $('input[name="daterange"]').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    endDate: moment().format('YYYY-MM-DD')
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                        .format('YYYY-MM-DD'));
                });
            });

            function removeRemark() {
                let resumeTable = document.getElementById('resumeTable');
                if (resumeTable.style.display === 'block') {
                    resumeTable.style.display = 'none';
                }
                $('#candidateResume').empty();
            }

            $(document).ready(function() {
                $('select.form-select').change(function() {
                    var dashboardId = $(this).attr('id').split('_')[1];
                    var remarkId = $(this).val();
                    var confirmed = confirm('Are you sure you want to change?');

                    if (confirmed) {
                        var redirectUrl = '/ATS/change/dashboard/remark/' + dashboardId + '/' + remarkId;
                        window.location.href = redirectUrl;
                    }
                });
            });

            function changeRemarkBlock(dashboard) {
                let remarkId = 8;
                var confirmed = confirm('Are you sure you want to proceed?');
                if (confirmed) {
                    window.location.href = '/ATS/change/dashboard/remark/' + dashboard + '/' + remarkId;
                }
            }

        </script>
    @endsection
