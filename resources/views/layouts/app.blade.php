<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard &mdash;</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/gear.svg') }}" type="image/x-icon">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap4.css') }}" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    @livewireStyles
</head>

<body style="background: #e2e8f0">
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">

                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('logout') }}" style="cursor: pointer" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route('dashboard.index') }}">Finance APP</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{ route('dashboard.index') }}">Finance</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">MAIN MENU</li>
                        <li class="{{ setActive('/dashboard') }}">
                            <a class="nav-link"href="{{ route('dashboard.index') }}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                        </li>
                        <li class="{{ setActive('/accounts') }}">
                            <a class="nav-link" href="{{ route('accounts.index') }}">
                                <i class="fas fa-file"></i><span>Account</span>
                            </a>
                        </li>
                        <li class="{{ setActive('/journals') }}">
                            <a class="nav-link" href="{{ route('journals.index') }}">
                                <i class="fas fa-book"></i><span>Journal</span>
                            </a>
                        </li>
                        <li class="{{ setActive('/expenses') }}">
                            <a class="nav-link" href="{{ route('expenses.index') }}">
                                <i class="fas fa-money-bill-wave"></i><span>Expense</span>
                            </a>
                        </li>
                        {{-- <li class="{{ setActive('/transactions') }}">
                            <a class="nav-link" href="{{ route('transactions.index') }}">
                                <i class="fas fa-exchange-alt"></i><span>Transaction</span>
                            </a>
                        </li> --}}
                        <li class="{{ setActive('/budget-plans') }}">
                            <a class="nav-link" href="{{ route('budget-plans.index') }}">
                                <i class="fas fa-chart-line"></i><span>Budget Plan</span>
                            </a>
                        </li>
                        <li class="{{ setActive('/taxes') }}">
                            <a class="nav-link" href="{{ route('taxes.index') }}">
                                <i class="fas fa-file-invoice-dollar"></i><span>Tax</span>
                            </a>
                        </li>
                        <li class="{{ setActive('/vendrs') }}">
                            <a class="nav-link" href="{{ route('vendrs.index') }}">
                                <i class="fas fa-store"></i><span>Vendor</span>
                            </a>
                        </li>
                        <li class="{{ setActive('/ledgers') }}">
                            <a class="nav-link" href="{{ route('ledgers.index') }}">
                                <i class="fas fa-book-open"></i><span>Ledger</span>
                            </a>
                        </li>
                        <li class="{{ setActive('/neracas') }}">
                            <a class="nav-link" href="{{ route('neracas.index') }}">
                                <i class="fas fa-balance-scale"></i><span>Neraca</span>
                            </a>
                        </li>
                        <li class="{{ setActive('/reports') }}">
                            <a class="nav-link" href="{{ route('reports.index') }}">
                                <i class="fas fa-balance-scale"></i><span>Profit Loss</span>
                            </a>
                        </li>



                        @if(auth()->user()->can('roles.index') || auth()->user()->can('permission.index') || auth()->user()->can('users.index'))
                        <li class="menu-header">PENGATURAN</li>
                        @endif

                        @can('sliders.index')
                        <li class="{{ setActive('admin/slider') }}"><a class="nav-link"
                                href="#"><i class="fas fa-laptop"></i>
                                <span>Sliders</span></a></li>
                        @endcan

                        <li
                            class="dropdown {{ setActive('admin/role'). setActive('admin/permission'). setActive('admin/user') }}">
                            @if(auth()->user()->can('roles.index') || auth()->user()->can('permission.index') || auth()->user()->can('users.index'))
                                <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Users
                                Management</span></a>
                            @endif

                            <ul class="dropdown-menu">
                                @can('roles.index')
                                    <li class="{{ setActive('admin/role') }}"><a class="nav-link"
                                        href="{{ route('roles.index') }}"><i class="fas fa-unlock"></i> Roles</a>
                                </li>
                                @endcan

                                @can('permissions.index')
                                    <li class="{{ setActive('/permission') }}"><a class="nav-link"
                                    href="{{ route('permissions.index') }}"><i class="fas fa-key"></i>
                                    Permissions</a></li>
                                @endcan

                                @can('users.index')
                                    <li class="{{ setActive('/user') }}"><a class="nav-link"
                                        href="{{ route('users.index') }}"><i class="fas fa-users"></i> Users</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            @yield('content')

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2024 <div class="bullet"></div> Finance APP <div class="bullet"></div> RSU 'Aisyiyah Purworejo
                </div>
                <div class="footer-right">
                    <div class="bullet"></div> Semangat yaa🫰<div class="bullet"></div>
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        //active select2
        $(document).ready(function () {
            $('select').select2({
                theme: 'bootstrap4',
                width: 'style',
            });
        });

        //flash message
        @if(session()->has('success'))
        swal({
            type: "success",
            icon: "success",
            title: "BERHASIL!",
            text: "{{ session('success') }}",
            timer: 1500,
            showConfirmButton: false,
            showCancelButton: false,
            buttons: false,
        });
        @elseif(session()->has('error'))
        swal({
            type: "error",
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            timer: 1500,
            showConfirmButton: false,
            showCancelButton: false,
            buttons: false,
        });
        @endif
    </script>

    @livewireScripts
</body>
</html>
