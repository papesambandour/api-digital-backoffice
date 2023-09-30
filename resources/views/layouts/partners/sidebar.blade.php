<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-search">
            <span class="searchbar-toggle">  </span>
            <form id="searchForm" action="/partner/transaction" class="pcoded-search-box ">
                <input name="search_in_any_id_transaction" type="text" placeholder="Rechercher une transaction">
                <span onclick="document.getElementById('searchForm').submit()" class="search-icon"><i class="ti-search"
                                                                                                      aria-hidden="true"></i></span>
            </form>
        </div>
        @if(has(action_dashboard()) )

            <div class="pcoded-navigatio-lavel">Reporting</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="active">
                    <a href="/partner">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                        <span class="pcoded-mtext">Dashboard</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="active" style="display: none">
                    <a href="/partner/statistic">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                        <span class="pcoded-mtext">Statistique</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

            </ul>
        @endif
        @if(has(action_transaction()) || has(action_versement())  || has(action_mvm_compte()) || has(action_claim()) )
        <div class="pcoded-navigatio-lavel">Monétique</div>
        @endif
        <ul class="pcoded-item pcoded-left-item">
            @if(has(action_transaction()) )

                <li class="active">
                    <a href="/partner/transaction">
                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                        <span class="pcoded-mtext">Transactions</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif

            @if(has(action_versement()) )

                <li class="active">
                    <a href="/partner/versement">
                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                        <span class="pcoded-mtext">Versements</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif

            @if(has(action_mvm_compte()) )

                <li class="active">
                    <a href="/partner/mvm-compte">
                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                        <span class="pcoded-mtext">Mouvement compte</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
            @if(has(action_claim()) )

                <li class="active">
                    <a href="/partner/claim">
                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                        <span class="pcoded-mtext">Réclamation</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
        </ul>
        @if(has(action_service())  || has(action_apikey())  )
        <div class="pcoded-navigatio-lavel">Configurations</div>
        @endif
        <ul class="pcoded-item pcoded-left-item">
            @if(has(action_service()) )

                <li class="active">
                    <a href="/partner/service">
                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                        <span class="pcoded-mtext">Mes Services</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
            @if(has(action_apikey()) )

                <li class="active">
                    <a href="/partner/apikey">
                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                        <span class="pcoded-mtext">Mes Clées APIs</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
                @if(has(action_role()) || has(action_user()) )
            <div class="pcoded-navigatio-lavel">Utilisateur</div>
                @endif
            @if(has(action_role()) )

                <li class="active">
                    <a href="/partner/role">
                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>U</b></span>
                        <span class="pcoded-mtext">Mes roles</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
            @if(has(action_user()) )

                <li class="active">
                    <a href="/partner/user">
                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>U</b></span>
                        <span class="pcoded-mtext">Mes utilisateurs</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endif
        </ul>


    </div>
</nav>
