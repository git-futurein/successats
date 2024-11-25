<header id="page-topbar" class="isvertical-topbar">
    @php
        $notifications = Auth::user()->notifications;
    @endphp
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/admin/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('build/images/logo-dark-sm.png') }}" alt="" height="26">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('build/images/logo-dark-sm.png') }}" alt="" height="26">
                    </span>
                </a>

                <a href="/admin/" class="logo logo-light">
                    <span class="logo-lg">
                        <img src="{{ URL::asset('build/images/logo-dark-sm.png') }}" alt="" height="30">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ URL::asset('build/images/logo-dark-sm.png') }}" alt="" height="26">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
                <i class="bx bx-menu align-middle"></i>
            </button>

            <!-- start page title -->
            <div class="page-title-box align-self-center d-none d-md-block">
                <h4 class="page-title mb-0">@yield('page-title')</h4>
            </div>
            <!-- end page title -->
        </div>

        @php
            $emp = Auth::user()->employe
        @endphp
        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown-v"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-bell icon-sm align-middle"></i>
                    <span class="noti-dot bg-danger rounded-pill">{{count($emp->notifications)}}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown-v">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-15"> Notifications </h5>
                            </div>
                            {{-- <div class="col-auto">
                                <a href="#!" class="small fw-semibold text-decoration-underline"> Mark all as
                                    read</a>
                            </div> --}}
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 250px;">
                        @if (count($emp->notifications) > 0)
                            @foreach ($emp->notifications as $notification)
                                @php
                                    $data = $notification->data;
                                    $time = null;
                                    if (isset($data['time'])) {
                                        try {
                                            $carbonTime = Carbon\Carbon::parse($data['time']);
                                            $time = $carbonTime->format('h:i A');
                                        } catch (\Exception $e) {
                                            $time = null;
                                        }
                                    }
                                    $parsedDate = null;
                                    if (isset($data['new_date'])) {
                                        try {
                                            $carbonDate = Carbon\Carbon::parse($data['new_date']);
                                            $parsedDate = $carbonDate->format('F j, Y');
                                        } catch (\Exception $e) {
                                            $parsedDate = null;
                                        }
                                    }
                                    $candidate = App\Models\Candidate::select('candidate_name', 'candidate_mobile')->find($data['candidate_id']);
                                @endphp
                                <a href="#!" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-sm me-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-18">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted font-size-13 mb-0 float-end">{{ $data['title'] }}</p>
                                            <h6 class="mb-1">{{$candidate->candidate_name}} ({{$candidate->candidate_mobile}})</h6>
                                            <div>
                                                <p class="mb-0">{{$parsedDate}} <strong>{{$time}}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @if(Auth::guard('web')->user())
            <div class="dropdown d-inline-block">
                <button type="button" class="btn  header-item user text-start d-flex align-items-center"
                    id="page-header-user-dropdown-v" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">{{Str::ucfirst(Auth::guard('web')->user()->name)}}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="p-3 border-bottom">
                        <h6 class="mb-0">{{Str::ucfirst(Auth::guard('web')->user()->name)}}</h6>
                        <p class="mb-0 font-size-11 text-muted">{{Str::ucfirst(Auth::guard('web')->user()->email)}}</p>
                    </div>
                   <!-- <a class="dropdown-item" href="javascript:void(0)"><i
                            class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i> <span
                            class="align-middle">Profile</span></a>
                    <a class="dropdown-item" href="javascript:void(0)"><i
                            class="mdi mdi-message-text-outline text-muted font-size-16 align-middle me-2"></i> <span
                            class="align-middle">Messages</span></a>
                    <a class="dropdown-item" href="javascript:void(0)"><i
                            class="mdi mdi-lifebuoy text-muted font-size-16 align-middle me-2"></i> <span
                            class="align-middle">Help</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)"><i
                            class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-2"></i> <span
                            class="align-middle me-3">Settings</span><span
                            class="badge badge-soft-success ms-auto">New</span></a>
                    <a class="dropdown-item" href="javascript:void(0)"><i
                            class="mdi mdi-lock text-muted font-size-16 align-middle me-2"></i> <span
                            class="align-middle">Lock screen</span></a>
                    <div class="dropdown-divider"></div>-->
                    <a class="dropdown-item" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="mdi mdi-logout text-muted font-size-16 align-middle me-2"></i> <span
                            class="align-middle">Logout</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            @else
                <script>window.location = "/ATS/Employee";</script>
            @endif
        </div>
    </div>
</header>
