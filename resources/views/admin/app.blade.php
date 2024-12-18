<html lang="en">
<head><base href=""/>
    <title>Unfinished Memory</title>
    <meta charset="utf-8" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{('backend/assets/media/logos/favicon.ico')}}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{('backend/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{('backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{('backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
<div class="d-flex flex-column flex-root">

    <div class="page d-flex flex-row flex-column-fluid">
        <div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
            <div class="aside-logo flex-column-auto" id="kt_aside_logo">
                <a href="#">
                    <h4 style="color: white">Unfinished Memory</h4>
                </a>
                <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle me-n2" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
                    <i class="ki-outline ki-double-left fs-1 rotate-180"></i>
                </div>
            </div>

            <div class="aside-menu flex-column-fluid">
                <div class="hover-scroll-overlay-y my-2 py-2" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
                    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
                        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-element-11 fs-2"></i>
                                </span>

                                <span class="menu-title">Dashboards</span>
                            </span>
                        </div>

                        <div class="menu-item pt-5">
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Pages</span>
                            </div>
                        </div>

                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">

                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-address-book fs-2"></i>
                                </span>
                                <span class="menu-title">Book</span>
                                <span class="menu-arrow"></span>
                            </span>

                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link" href="{{route('book')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                      <span class="menu-title">Book List</span>
                                    </a>
                                </div>
                            </div>

                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link" href="{{route('chapter')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Book Chapter</span>
                                    </a>
                                </div>
                            </div>
                        </div>



                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">

                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-address-book fs-2"></i>
                                </span>
                                <span class="menu-title">Content</span>
                                <span class="menu-arrow"></span>
                            </span>


                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link" href="{{route('bangla.content')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Add Bangla Content</span>
                                    </a>
                                </div>
                            </div>

                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link" href="{{route('bangla.content.show')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Manage Bangla Content</span>
                                    </a>
                                </div>
                            </div>

                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link" href="#">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Add English Content</span>
                                    </a>
                                </div>
                            </div>

                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link" href="#">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Manage English Content</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <div id="kt_header" style="" class="header align-items-stretch">
                <div class="container-fluid d-flex align-items-stretch justify-content-between">
                    <div class="d-flex align-items-center d-lg-none ms-n4 me-1" title="Show aside menu">
                        <div class="btn btn-icon btn-active-color-white" id="kt_aside_mobile_toggle">
                            <i class="ki-outline ki-burger-menu fs-1"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="#" class="d-lg-none">
                            <img alt="Logo" src="assets/media/logos/demo13-small.svg" class="h-25px" />
                        </a>
                    </div>

                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                        <div class="d-flex align-items-stretch" id="kt_header_nav">
                            <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                                <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-state-primary menu-title-gray-800 menu-arrow-gray-400 align-items-stretch my-5 my-lg-0 px-2 px-lg-0 fw-semibold fs-6" id="#kt_header_menu" data-kt-menu="true">
                                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                                        <span class="menu-link py-3">
                                            <span class="menu-title">Dashboards</span>
                                            <span class="menu-arrow d-lg-none"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="topbar d-flex align-items-stretch flex-shrink-0">
                            <div class="d-flex align-items-center">
                                <a href="#" class="topbar-item px-3 px-lg-4" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                    <i class="ki-outline ki-night-day theme-light-show fs-1"></i>
                                    <i class="ki-outline ki-moon theme-dark-show fs-1"></i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                    <div class="menu-item px-3 my-0">
                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-outline ki-night-day fs-2"></i>
                                            </span>
                                            <span class="menu-title">Light</span>
                                        </a>
                                    </div>
                                    <div class="menu-item px-3 my-0">
                                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-outline ki-moon fs-2"></i>
                                            </span>
                                            <span class="menu-title">Dark</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-stretch" id="kt_header_user_menu_toggle">
                                <div class="topbar-item cursor-pointer symbol px-3 px-lg-5 me-n3 me-lg-n5 symbol-30px symbol-md-35px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                                    <img src="{{URL::to('backend/assets/media/avatars/300-1.jpg')}}" alt="metronic" />
                                </div>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                                    <div class="menu-item px-5 my-1">
                                        <a href="#" class="menu-link px-5">Account Settings</a>
                                    </div>
                                    <div class="menu-item px-5">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
              @yield('admin_content')
            </div>
        </div>
    </div>
</div>



<script src="{{('backend/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{('backend/assets/js/scripts.bundle.js')}}"></script>
<script src="{{('backend/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{('backend/assets/js/widgets.bundle.js')}}"></script>
<script src="{{('backend/assets/js/custom/widgets.js')}}"></script>
<script src="{{('backend/assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{('backend/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{('backend/assets/js/custom/utilities/modals/create-app.js')}}"></script>
<script src="{{('backend/assets/js/custom/utilities/modals/users-search.js')}}"></script>

</body>
</html>
