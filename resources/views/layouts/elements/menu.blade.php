@if($user->can('companies.read') || $user->can('contacts.read'))
    <li class="nav-header text-uppercase">{{__('Clients')}}</li>
    @can('companies.read')
        <li class="nav-item">
            <a href="{{url('companies')}}" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>{{__('Companies')}}</p>
            </a>
        </li>
    @endcan
    {{-- @can('contacts.read')
        <li class="nav-item">
            <a href="{{url('contacts')}}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Contatti</p>
            </a>
        </li>
    @endcan --}}
@endif

{{-- @can('calendars.view')
    <li class="nav-header text-uppercase">calendario</li>
    <li class="nav-item">
        <a href="{{$user->default_calendar->url}}" class="nav-link" id="menu-cal">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Calendario</p>
        </a>
    </li>
@endcan --}}

{{-- @if($user->can('invoices.read') || $user->can('costs.read') || $user->can('products.read') || $user->can('expenses.read') || $user->can('stats.read'))
    <li class="nav-header text-uppercase">contabilità</li>

    @if( $user->can('invoices.read') || $user->can('costs.read') )
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-invoice"></i>
                <p>Fatture<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
                @can('invoices.read')
                    <li class="nav-item">
                        <a href="{{url('invoices')}}" class="nav-link">
                            <i class="far fa-circle nav-icon text-success"></i>
                            <p>Vendite</p>
                        </a>
                    </li>
                @endcan
                @can('costs.read')
                    <li class="nav-item">
                        <a href="{{url('costs')}}" class="nav-link">
                            <i class="far fa-circle nav-icon text-danger"></i>
                            <p>Acquisti</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endif

    @can('expenses.read')
        <li class="nav-item">
            <a href="{{url('expenses')}}" class="nav-link">
                <i class="nav-icon fas fa-cash-register"></i>
                <p>Spese</p>
            </a>
        </li>
    @endcan
    @can('stats.read')
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Statistiche<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{url('stats/aziende')}}" class="nav-link" id="menu-stats-aziende">
                        <i class="far fa-circle nav-icon text-success"></i>
                        <p>Clienti</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('stats/categorie?year='.date('Y'))}}" class="nav-link" id="menu-stats-categorie">
                        <i class="far fa-circle nav-icon text-danger"></i>
                        <p>Categorie Prodotti</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('stats/balance')}}" class="nav-link" id="menu-stats-bilancio">
                        <i class="far fa-circle nav-icon text-info"></i>
                        <p>Bilancio</p>
                    </a>
                </li>
            </ul>
        </li>
    @endcan
@endif --}}

@if($user->can('products.read'))
    <li class="nav-header text-uppercase">{{__('Products')}}</li>

    @can('products.read')
        <li class="nav-item">
            <a href="{{route('products.index')}}" class="nav-link">
                <i class="nav-icon fas fa-tags"></i>
                <p>{{__('Products')}}</p>
            </a>
        </li>
    @endcan

    {{-- @can('productsCRM.read')
        <li class="nav-item">
            <a href="{{route('products.orders')}}" class="nav-link">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>Prodotti Ordini</p>
            </a>
        </li>
    @endcan --}}

    @can('works.read')
        <li class="nav-item">
            <a href="{{route('works.index')}}" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>{{__('Works')}}</p>
            </a>
        </li>

    @endcan

@endif


<li class="nav-header text-uppercase">ERP</li>


<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-boxes"></i>
        <p>{{__('Store')}}<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('stores.index')}}" class="nav-link" id="menu-erp-store-klaxon">
                <i class="far fa-circle nav-icon text-secondary"></i>
                <p>{{__('Store')}} Klaxon </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('stores.fornitori')}}" class="nav-link" id="menu-erp-store-external">
                <i class="far fa-circle nav-icon text-danger"></i>
                <p>{{__('Workers Store')}}</p>
            </a>
        </li>
    </ul>
</li>


    {{-- <li class="nav-item">
        <a href="{{route('erp.orders.index')}}" class="nav-link">
            <i class="nav-icon fas fa-folder"></i>
            <p>{{__('Orders')}}</p>
        </a>
    </li> --}}


    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-folder"></i>
            <p>{{__('Orders')}}<i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('erp.orders.sales')}}" class="nav-link" id="menu-erp-ordini-sales">
                    <i class="far fa-circle nav-icon text-danger"></i>
                    <p>{{__('Sales')}}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('erp.orders.shippings')}}" class="nav-link" id="menu-erp-ordini-shippings">
                    <i class="far fa-circle nav-icon text-warning"></i>
                    <p>{{__('Shippings')}}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('erp.orders.purchases')}}" class="nav-link" id="menu-erp-ordini-purchases">
                    <i class="far fa-circle nav-icon text-primary"></i>
                    <p>{{__('Purchases')}}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('erp.orders.works')}}" class="nav-link" id="menu-erp-ordini-works">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>{{__('Works')}}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('erp.orders.index')}}" class="nav-link" id="menu-erp-ordini">
                    <i class="far fa-circle nav-icon text-secondary"></i>
                    <p>{{__('All')}}</p>
                </a>
            </li>

        </ul>
    </li>


    <li class="nav-item">
        <a href="{{route('erp.orders.create')}}" class="nav-link">
            <i class="nav-icon fas fa-folder-plus"></i>
            <p>{{__('Create') . ' ' . __('Order')}}</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{route('erp.ddt.index')}}" class="nav-link" id="menu-erp-ddt">
            <i class="nav-icon fas fa-shipping-fast"></i>
            <p>DDT</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{route('erp.logs')}}" class="nav-link">
            <i class="nav-icon fas fa-history"></i>
            <p>Logs</p>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon text-success"></i>
            <p>DDT</p>
        </a>
    </li> --}}





{{-- @if($user->can('newsletters.read') || $user->can('lists.read') || $user->can('templates.read') )

    <li class="nav-header text-uppercase">Campagne</li>

    @can('lists.read')
        <li class="nav-item">
            <a href="{{url('lists')}}" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
                <p>Liste</p>
            </a>
        </li>
    @endcan
    @can('lists.create')
        <li class="nav-item">
            <a href="{{url('create-list')}}?sort=updated_at|desc" class="nav-link">
                <i class="nav-icon fas fa-user-plus"></i>
                <p>Crea Lista</p>
            </a>
        </li>
    @endcan
    @can('templates.read')
        <li class="nav-item">
            <a href="{{url('templates')}}" class="nav-link">
                <i class="nav-icon fas fa-drafting-compass"></i>
                <p>Templates</p>
            </a>
        </li>
    @endcan
    @can('templates.read')
        <li class="nav-item">
            <a href="{{url('newsletters')}}" class="nav-link">
                <i class="nav-icon fas fa-paper-plane"></i>
                <p>Newsletters</p>
            </a>
        </li>
    @endcan
@endif --}}

@if( $user->can('users.read') || $user->can('roles.read') )
    <li class="nav-header text-uppercase">{{__('Users')}}</li>

    @can('users.read')
        <li class="nav-item">
            <a href="{{url('users')}}" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>{{__('Users')}}</p>
            </a>
        </li>
    @endcan

    @can('roles.read')
        <li class="nav-item">
            <a href="{{url('roles')}}" class="nav-link">
                <i class="nav-icon fas fa-user-tag"></i>
                <p>{{__('Roles')}}</p>
            </a>
        </li>
    @endcan

@endif
