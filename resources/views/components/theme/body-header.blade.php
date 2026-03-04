<div class="nk-header is-light nk-header-fixed is-light">
    <div class="container-xl wide-xl">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ms-n1 me-3"><a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a></div>
            <div class="nk-header-brand d-xl-none"><a href="index-2.html" class="logo-link"><img class="logo-light logo-img" src="images/logo.png" srcset="/demo9/images/logo2x.png 2x" alt="logo"><img class="logo-dark logo-img" src="images/logo-dark.png" srcset="/demo9/images/logo-dark2x.png 2x" alt="logo-dark"></a></div>

            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown notification-dropdown">
                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                            <div class="dropdown-head"><span class="sub-title nk-dropdown-title">Notifications</span><a href="#">Mark All as Read</a></div>
                            <div class="dropdown-body">
                                <div class="nk-notification">
                                    <div class="nk-notification-item dropdown-inner">
                                        <div class="nk-notification-icon"><em class="icon icon-circle bg-primary-dim ni ni-share"></em></div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">Iliash shared <span>Dashlite-v2</span> with you.</div>
                                            <div class="nk-notification-time">Just now</div>
                                        </div>
                                    </div>
                                    <div class="nk-notification-item dropdown-inner">
                                        <div class="nk-notification-icon"><em class="icon icon-circle bg-info-dim ni ni-edit"></em></div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">Iliash <span>invited</span> you to edit <span>DashLite</span> folder</div>
                                            <div class="nk-notification-time">2 hrs ago</div>
                                        </div>
                                    </div>
                                    <div class="nk-notification-item dropdown-inner">
                                        <div class="nk-notification-icon"><em class="icon icon-circle bg-primary-dim ni ni-share"></em></div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">You have shared <span>project v2</span> with Parvez.</div>
                                            <div class="nk-notification-time">7 days ago</div>
                                        </div>
                                    </div>
                                    <div class="nk-notification-item dropdown-inner">
                                        <div class="nk-notification-icon"><em class="icon icon-circle bg-success-dim ni ni-spark"></em></div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">Your <span>Subscription</span> renew successfully.</div>
                                            <div class="nk-notification-time">2 month ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-foot center"><a href="#">View All</a></div>
                        </div>
                    </li>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm"><em class="icon ni ni-user-alt"></em></div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar"><span>AB</span></div>
                                    <div class="user-info"><span class="lead-text">Abu Bin Ishtiyak</span><span class="sub-text">info@softnio.com</span></div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="{{route('profile.edit')}}"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                    <li><a href="user-profile-setting.html"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                    <li><a href="user-profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <em class="icon ni ni-signout"></em>
                                            <span>Sign out</span>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
