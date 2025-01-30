<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
            <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="...">
            <span class="ms-3 font-weight-bold">Soft UI Dashboard Laravel</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-tv ps-2 pe-2 text-center top-0 text-dark {{ Request::is('dashboard') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Laravel Examples</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('user-profile') ? 'active' : '' }} " href="{{ url('user-profile') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-user-circle ps-2 pe-2 top-0 text-center text-dark {{ Request::is('user-profile') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Profile</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::is('admin.user.*') ? 'active' : '' }}"
                    href="{{ route('admin.user.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-list-ul text-dark {{ Route::is('admin.user-management.*') ? 'text-white' : 'text-dark' }}"
                            style="font-size: 1rem;"
                            aria-hidden="true">
                        </i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Example pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('tables') ? 'active' : '' }}" href="{{ url('tables') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-table ps-2 pe-2 top-0 text-center text-dark {{ Request::is('tables') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tables</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.products.*') || Route::is('admin.categories.*')||Route::is('admin.subcategory.*') ? 'active' : '' }}" href="#manageProductSubmenu"
                   data-bs-toggle="collapse"
                   aria-expanded="{{ Route::is('admin.products.*') || Route::is('admin.categories.*')||Route::is('admin.subcategory.*') ? 'true' : 'false' }}"
                   class="dropdown-toggle">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="fas fa-box text-dark top-0"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Product</span>
                </a>
                <ul class="collapse list-unstyled ms-4 mt-2 {{ Route::is('admin.products.*')||Route::is('admin.categories.*')||Route::is('admin.subcategory.*') ? 'show' : '' }}" id="manageProductSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.products.create') ? 'active' : '' }}" href="{{ route('admin.products.create') }}">
                            <span class="nav-link-text ms-1">Create Product</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.products.index') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <span class="nav-link-text ms-1">List Product</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.categories.index') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <span class="nav-link-text ms-1">Category</span>
                        </a>
                    </li>
                </ul>
            </li>



            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.email-templates.create') ? 'active' : '' }}" href="{{route('admin.email-templates.create')}}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-envelope text-dark top-0"></i>
                    </div>
                    <span class="nav-link-text ms-1">Email-Templates</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link " href="#">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user text-dark top-0"></i>
                    </div>
                    <span class="nav-link-text ms-1">All Staff</span>
                </a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.billing') ? 'active' : '' }}" href="{{route('admin.billing')}}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-dollar-sign text-dark top-0"></i>
                    </div>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.menu.*') ? 'active' : '' }}" href="{{route('admin.menu.index')}}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-dollar-sign text-dark top-0"></i>
                    </div>
                    <span class="nav-link-text ms-1">Menu</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.pages.*') ? 'active' : '' }}" href="{{route('admin.pages.index')}}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-dollar-sign text-dark top-0"></i>
                    </div>
                    <span class="nav-link-text ms-1">page Builder</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.setting.index') ? 'active' : '' }}" href="{{ route('admin.setting.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center"><i class="m-0 fas fa-cog  top-0"></i></div>
                    <div class="text">Settings</div>
                </a>
            </li>
        </ul>
    </div>
</aside>
