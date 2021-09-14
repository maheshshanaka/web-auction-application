<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <div class="logo">
        <a href="#" class="simple-text logo-normal">
            {{ config('app.name') }}
        </a>
        <div class="simple-text">
         <h6> User: {{ Auth::user()->name ?? null }}</h6>
         </div>
    </div>

    @if(!isset($activePage))
    @php
    $$activePage = "";
    @endphp
    @endIf
    @if(!isset($titlePage))
    @php
    $titlePage = "";
    @endphp
    @endIf
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{ $activePage == 'items' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('items.index') }}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Item List') }}</p>
                </a>
            </li>
            <li class="nav-item {{ ($activePage == 'admin' || $activePage == 'settings') ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                    <i class="material-icons">settings</i>
                    <p>{{ __('Settings') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExample">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'admin' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('items.create') }}">
                                <i class="material-icons">manage_accounts</i>
                                <p>{{ __('Admin Settings') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'setting' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('settings.create') }}">
                                <i class="material-icons">watch_later</i>
                                <p>{{ __('Max Bid Amount') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
