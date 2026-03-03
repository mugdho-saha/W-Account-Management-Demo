<div class="nk-sidebar-element">
    <div class="nk-sidebar-content">
        <div class="nk-sidebar-menu" data-simplebar>
            <ul class="nk-menu">
                @role('admin|observer')
                <li class="nk-menu-item"><a href="{{route('dashboard')}}" class="nk-menu-link"><span class="nk-menu-icon"><em class="icon ni ni-presentation"></em></span><span class="nk-menu-text">Dashboard</span></a></li>
                @endrole

                @role('admin')
                <li class="nk-menu-item"><a href="{{route('users.index')}}" class="nk-menu-link"><span class="nk-menu-icon"><em class="icon ni ni-users"></em></span><span class="nk-menu-text">Users</span></a></li>
                <li class="nk-menu-item"><a href="{{route('category.index')}}" class="nk-menu-link"><span class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span><span class="nk-menu-text">Categories</span></a></li>
                @endrole

                @role('admin|moderator')
                <li class="nk-menu-item"><a href="{{route('transactions.index')}}" class="nk-menu-link"><span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span><span class="nk-menu-text">Transactions</span></a></li>
                @endrole

                @role('admin|moderator|observer')
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span><span class="nk-menu-text">Reports</span></a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item"><a href="{{route('reports.datewise')}}" class="nk-menu-link"><span class="nk-menu-text">Date-wise Report</span></a></li>
                        <li class="nk-menu-item"><a href="{{route('reports.balancesheet')}}" class="nk-menu-link"><span class="nk-menu-text">Balance Sheet Report</span></a></li>
                    </ul>
                </li>
                @endrole
            </ul>
        </div>
    </div>
</div>
