<nav class="topnav navbar navbar-light bg-primary">
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

{{--    <form class="form-inline mr-auto searchform text-muted">--}}
{{--        <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Type something..." aria-label="Search">--}}
{{--    </form>--}}

    <ul class="nav">

        <li class="nav-item d-none d-lg-flex bg-light border font-weight-bold rounded my-lg-auto shadow align-items-center" style="min-width: auto; width: max-content;">
            @auth('admin')
                <a href="#" class="mr-5 px-0 nav-link">
                    <span class="mx-2">{{ __('admin/labels.hi') }}</span>
                    <span>{{ auth('admin')->user()->name }}</span>
                </a>

                <a class="nav-link p-lg-0 {{ $lang === 'ar' ? 'mr-2' : 'ml-2' }} align-items-center justify-content-center">
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm shadow border bg-light rounded-circle pb-0 px-2  mx-1">
                    <span>
                        <i class="fe fe-power  fe-16 text-danger"></i>
                    </span>
                        </button>
                    </form>
                </a>
            @endauth
        </li>

        <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
                <i class="fe fe-sun fe-16"></i>
            </a>
        </li>

        <li class="nav-item dropdown my-lg-auto bg-light border fw-bold rounded py-1 shadow my-sm-3" style="min-width: auto; width: max-content;">
            <a class="nav-link dropdown-toggle text-muted mx-2 p-1" href="#" id="navbarScrollingDropdownLang" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <small>{{ strtoupper(App::getLocale()) }}</small>
            </a>
            <div class="dropdown-menu rounded font-weight-bold pb-0 shadow" aria-labelledby="navbarScrollingDropdownLang" style="min-width: auto; width: max-content;">
                @foreach($languages as $langs)
                    <a href="{{ route('language.switch', $langs->abbr) }}" class="dropdown-item mb-2 {{ App::getLocale() === $langs->abbr ? 'active' : '' }}">
                        {{ __('admin/labels.'. $langs->name) }}
                    </a>
                @endforeach
            </div>
        </li>

    </ul>
</nav>
