<nav class="pcoded-navbar menu-light ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div ">

            <div class="">
                <div class="main-menu-header mb-3">
                    <img class="img-radius" src="{{ back_asset('images/user/avatar-2.jpg') }}" alt="User-Profile-Image">
                    <div class="user-details">
                        <div id="more-details" class="text-capitalize">{{ auth()->user()->name }}</div>
                    </div>
                </div>
            </div>

            <ul class="nav pcoded-inner-navbar ">
                <!-- <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="index.html">Default</a></li>
                        <li><a href="dashboard-sale.html">Sales</a></li>
                        <li><a href="dashboard-crm.html">CRM</a></li>
                        <li><a href="dashboard-analytics.html">Analytics</a></li>
                        <li><a href="dashboard-project.html">Project</a></li>
                    </ul>
                </li> -->
                <li class="nav-item"><a href="{{ url('/') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a></li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="fas fa-baseball-ball"></i></span><span class="pcoded-mtext">Games</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ url(admin().'/games') }}">Games</a></li>
                        <li><a href="{{ url(admin().'/playerRoles') }}">Player Roles</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a href="{{ url(admin().'/teams') }}" class="nav-link "><span class="pcoded-micon"><i class="fas fa-users"></i></span><span class="pcoded-mtext">Teams</span></a></li>
                <li class="nav-item"><a href="{{ url(admin().'/players') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Players</span></a></li>
                <li class="nav-item"><a href="{{ url(admin().'/events') }}" class="nav-link "><span class="pcoded-micon"><i class="fas fa-trophy"></i></span><span class="pcoded-mtext">Events</span></a></li>
                <li class="nav-item"><a href="{{ url(admin().'/stadiums') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-map-pin"></i></span><span class="pcoded-mtext">Stadiums</span></a></li>
                <li class="nav-item"><a href="{{ url(admin().'/matches') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-minimize-2"></i></span><span class="pcoded-mtext">Matches</span></a></li>
                <li class="nav-item"><a href="{{ url(admin().'/eventAwards') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-award"></i></span><span class="pcoded-mtext">Awards</span></a></li>
                <li class="nav-item"><a href="{{ url(admin().'/eventWinners') }}" class="nav-link "><span class="pcoded-micon"><i class="fas fa-crown"></i></span><span class="pcoded-mtext">Winners</span></a></li>
                <li class="nav-item"><a href="{{ url(admin().'/eventWallpapers') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-image"></i></span><span class="pcoded-mtext">Wallpapers</span></a></li>
                <li class="nav-item"><a href="{{ url(admin().'/applications') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-smartphone"></i></span><span class="pcoded-mtext">Applications</span></a></li>
                <li class="nav-item"><a href="{{ url(admin().'/applicationWallpapers') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-smartphone"></i></span><span class="pcoded-mtext">Application Wallpaper</span></a></li>
                <li class="nav-item"><a href="{{ url(admin().'/applicationVideos') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-smartphone"></i></span><span class="pcoded-mtext">Application Videos</span></a></li>
            </ul>

        </div>
    </div>
</nav>