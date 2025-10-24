<header class="app-header sticky" id="header">

    <div class="main-header-container container-fluid">

        <div class="header-content-left">

            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="{{ url('index') }}" class="header-logo">
                        <img src="{{ asset('build/assets/images/brand-logos/desktop-logo.png') }}" alt="logo"
                            class="desktop-logo">
                        <img src="{{ asset('build/assets/images/brand-logos/toggle-logo.png') }}" alt="logo"
                            class="toggle-logo">
                        <img src="{{ asset('build/assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                            class="desktop-dark">
                        <img src="{{ asset('build/assets/images/brand-logos/toggle-dark.png') }}" alt="logo"
                            class="toggle-dark">
                    </a>
                </div>
            </div>
            <div class="header-element mx-lg-0 mx-2">
                <a aria-label="Hide Sidebar"
                    class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                    data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
            </div>
            {{-- The header-search element has been removed here --}}

        </div>

        <ul class="header-content-right">

            <li class="header-element country-selector d-flex align-items-center">
                <a href="{{ route('set.locale', Session::get('locale') == 'fr' ? 'en' : 'fr') }}" class="header-link"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Switch Language">
                    @if (Session::get('locale') == 'fr')
                        <img src="{{ asset('build/assets/images/flags/french_flag.jpg') }}" alt="French Flag"
                            class="rounded-circle">
                    @else
                        <img src="{{ asset('build/assets/images/flags/us_flag.jpg') }}" alt="English Flag"
                            class="rounded-circle">
                    @endif
                </a>
            </li>
            <li class="header-element header-theme-mode">
                <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none" />
                            <path d="M108.11,28.11A96.09,96.09,0,0,0,227.89,147.89,96,96,0,1,1,108.11,28.11Z"
                                opacity="0.2" />
                            <path d="M108.11,28.11A96.09,96.09,0,0,0,227.89,147.89,96,96,0,1,1,108.11,28.11Z"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                        </svg>
                    </span>
                    <span class="dark-layout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none" />
                            <circle cx="128" cy="128" r="56" opacity="0.2" />
                            <line x1="128" y1="40" x2="128" y2="32" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <circle cx="128" cy="128" r="56" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                            <line x1="64" y1="64" x2="56" y2="56" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="64" y1="192" x2="56" y2="200" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="192" y1="64" x2="200" y2="56" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="192" y1="192" x2="200" y2="200" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="40" y1="128" x2="32" y2="128" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="128" y1="216" x2="128" y2="224" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="216" y1="128" x2="224" y2="128" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                        </svg>
                    </span>
                </a>
            </li>
            {{-- <li class="header-element notifications-dropdown dropdown">
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M56,104a72,72,0,0,1,144,0c0,35.82,8.3,64.6,14.9,76A8,8,0,0,1,208,192H48a8,8,0,0,1-6.88-12C47.71,168.6,56,139.81,56,104Z" opacity="0.2"/><path d="M96,192a32,32,0,0,0,64,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M56,104a72,72,0,0,1,144,0c0,35.82,8.3,64.6,14.9,76A8,8,0,0,1,208,192H48a8,8,0,0,1-6.88-12C47.71,168.6,56,139.81,56,104Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                    <span class="header-icon-pulse bg-secondary rounded pulse pulse-secondary"></span>
                </a>
                <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    <div class="p-3 bg-primary text-fixed-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-16">Notifications</p>
                            <a href="javascript:void(0);" class="badge bg-light text-default border">Clear All</a>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="list-unstyled mb-0" id="header-notification-scroll">
                        <li class="dropdown-item position-relative"><a href="{{url('chat')}}" class="stretched-link"></a><div class="d-flex align-items-start gap-3"><div class="lh-1"><span class="avatar avatar-sm avatar-rounded bg-primary-transparent"><img src="{{asset('build/assets/images/faces/1.jpg')}}" alt=""></span></div><div class="flex-fill"><span class="d-block fw-semibold">New Message</span><span class="d-block text-muted fs-12">You have received a new message from John Doe</span></div><div class="text-end"><span class="d-block mb-1 fs-12 text-muted">11:45am</span><span class="d-block text-primary d-none"><i class="ri-circle-fill fs-9"></i></span></div></div></li>
                        <li class="dropdown-item position-relative"><a href="{{url('chat')}}" class="stretched-link"></a><div class="d-flex align-items-start gap-3"><div class="lh-1"><span class="avatar avatar-sm avatar-rounded bg-primary-transparent"><i class="ri-notification-line fs-16"></i></span></div><div class="flex-fill"><span class="d-block fw-semibold">Task Reminder</span><span class="d-block text-muted fs-12">Don't forget to submit your report by 3 PM today</span></div><div class="text-end"><span class="d-block mb-1 fs-12 text-muted">02:16pm</span><span class="d-block text-primary d-none"><i class="ri-circle-fill fs-9"></i></span></div></div></li>
                        <li class="dropdown-item position-relative"><a href="{{url('chat')}}" class="stretched-link"></a><div class="d-flex align-items-start gap-3"><div class="lh-1"><span class="avatar avatar-sm avatar-rounded bg-primary-transparent fs-5"><img src="{{asset('build/assets/images/faces/12.jpg')}}" alt=""></span></div><div class="flex-fill"><span class="d-block fw-semibold">Friend Request</span><span class="d-block text-muted fs-12">Jane Smith sent you a friend request</span></div><div class="text-end"><span class="d-block mb-1 fs-12 text-muted">10:04am</span><span class="d-block text-primary"><i class="ri-circle-fill fs-9"></i></span></div></div></li>
                        <li class="dropdown-item position-relative"><a href="{{url('chat')}}" class="stretched-link"></a><div class="d-flex align-items-start gap-3"><div class="lh-1"><span class="avatar avatar-sm avatar-rounded bg-primary-transparent fs-5"><i class="ri-notification-line fs-16"></i></span></div><div class="flex-fill"><span class="d-block fw-semibold">Event Reminder</span><span class="d-block text-muted fs-12">You have an upcoming event: Team Meeting on October 25 at 10 AM.</span></div><div class="text-end"><span class="d-block mb-1 fs-12 text-muted">12:58pm</span><span class="d-block text-primary"><i class="ri-circle-fill fs-9"></i></span></div></div></li>
                        <li class="dropdown-item position-relative"><a href="{{url('chat')}}" class="stretched-link"></a><div class="d-flex align-items-start gap-3"><div class="lh-1"><span class="avatar avatar-sm avatar-rounded bg-primary-transparent fs-5"><i class="ri-notification-line fs-16"></i></span><div class="flex-fill"><span class="d-block fw-semibold">File Uploaded</span><span class="d-block text-muted fs-12">The file "Project_Proposal.pdf" has been uploaded successfully</span></div><div class="text-end"><span class="d-block mb-1 fs-12 text-muted">05:13pm</span><span class="d-block text-primary"><i class="ri-circle-fill fs-9"></i></span></div></div></li>
                    </ul>
                    <div class="p-5 empty-item1 d-none">
                        <div class="text-center">
                            <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                <i class="ri-notification-off-line fs-2"></i>
                            </span>
                            <h6 class="fw-medium mt-3">No New Notifications</h6>
                        </div>
                    </div>
                </div>
            </li> --}}
            @php
                // Generate user initials safely
                $fullName = optional(currentUser())->full_name ?? (auth()->user()?->full_name ?? '');
                $nameParts = explode(' ', trim($fullName));
                $initials = '';
                foreach ($nameParts as $part) {
                    if (!empty($part)) {
                        $initials .= strtoupper(substr($part, 0, 1));
                    }
                }
                $initials = substr($initials, 0, 2);
            @endphp
            <li class="header-element dropdown">
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div>
                        <span class="header-link-icon fw-bold fs-5"
                            style="background: #32acce !important; color: white !important;">{{ $initials }}</span>
                        {{-- <img src="{{ asset('build/assets/images/faces/12.jpg') }}" alt="img"
                            class="header-link-icon"> --}}
                    </div>
                </a>
                <div class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="mainHeaderProfile">
                    <div class="p-3 bg-primary text-fixed-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-16">Profile</p>
                            <a href="javascript:void(0);" class="text-fixed-white"><i
                                    class="ti ti-settings-cog"></i></a>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="p-3">
                        <div class="d-flex align-items-start gap-2">

                            <div class="lh-1">
                                <span class="avatar-text fw-bold fs-5"
                                    style="color: white !important;">{{ $initials }}</span>
                            </div>
                            <div>
                                <span
                                    class="d-block fw-semibold lh-1">{{ optional(currentUser())->full_name ?? (auth()->user()?->full_name ?? '') }}</span>
                                <span
                                    class="text-muted fs-12">{{ optional(currentUser()->subscription_type)->name ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <ul class="list-unstyled mb-0 sub-list">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ url('profile') }}"><i
                                            class="ti ti-settings-cog me-2 fs-18"></i>{{ __('messages.settings') }}</a>
                                </li>
                                {{-- <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ url('mail-settings') }}"><i
                                            class="ti ti-settings-cog me-2 fs-18"></i>Account Settings</a>
                                </li> --}}
                            </ul>
                        </li>
                        <li>
                            <ul class="list-unstyled mb-0 sub-list">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i
                                            class="ti ti-lifebuoy me-2 fs-18"></i>Support</a>
                                </li>
                                {{-- <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i
                                            class="ti ti-bolt me-2 fs-18"></i>Activity Log</a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);"><i
                                            class="ti ti-calendar me-2 fs-18"></i>Events</a>
                                </li> --}}
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ti ti-logout me-2 fs-18"></i>{{ __('messages.logout') }}
                            </a>
                        </li>

                        <!-- Hidden Logout Form (Include this somewhere in your master layout, if it's not already there) -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</header>
