<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/images/icon/favicon.ico') }}">
    <title>Admin | @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/lucid.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.responsive.min.js') }}" ></script>
    <link rel="preload" href="public/fonts/Poppins-Regular.woff2" as="font" type="font/woff2" crossorigin>
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    
</head>
<style>
    @import 'fonts.css';
    body {
        font-family: 'Poppins', sans-serif;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 16px;
    }

    .border-purple {
        border: 1px solid #9e3b78;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #9e3b78; 
        border-radius: 4px;
        padding: 6px 12px;
        margin-left: 8px;
        font-family: 'Poppins', sans-serif;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #8A0181;
        box-shadow: 0 0 0 2px rgba(138, 1, 129, 0.1);
    }

    .dataTables_wrapper .dataTables_filter label {
        font-weight: 500;
        color: #374151;
    }

    .bg-green-100-important {
        background-color: rgba(0, 255, 89, 0.151) !important;
    }
    .bg-red-100-important {
        background-color: rgba(255, 0, 0, 0.103) !important;
    }

    .datatable tr.bg-green-100-important:hover,
    .datatable tr.bg-red-100-important:hover {
        opacity: 0.9;
    }
    .bg-thead {
        background-color: #9A1573;
    }

    .bg-labels {
        background-color: #9A1573;
    }

    .datatable td {
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center !important;
    }

    .datatable thead th {
        position: relative;
        text-align: center;
        padding-right: 20px;
    }

    .datatable td:hover {
        white-space: normal;
        overflow: visible;
        position: relative;
        z-index: 1;
    }

    .dataTables_wrapper,
    .dataTables_wrapper,
    .dataTables_wrapper,
    .dataTables_wrapper {
        text-align: center !important;
        float: none !important;
        margin: 10px 0;
    }

    table.dataTable thead .sorting,
    table.dataTable thead .sorting_asc,
    table.dataTable thead .sorting_desc {
        background-image: url('{{ asset('storage/images/icon/sort_both.png') }}');
        background-repeat: no-repeat;
        background-position: center right;
    }

    table.dataTable thead .sorting_asc {
        background-image: url('{{ asset('storage/images/icon/sort_asc.png') }}');
    }

    table.dataTable thead .sorting_desc {
        background-image: url('{{ asset('storage/images/icon/sort_desc.png') }}');
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #8A0181 !important;
        color: white !important;
        border: 1px solid #8A0181;
        border-radius: 4px;
    }

    /* New pagination button styling */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #9A1573 !important;
        border: 1px solid transparent;
        border-radius: 4px;
        padding: 6px 12px;
        margin: 0 4px;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: rgba(154, 21, 115, 0.1) !important;
        border-color: rgba(154, 21, 115, 0.2);
        color: #9A1573 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #999 !important;
        background: transparent !important;
        border-color: transparent;
    }
</style>
<body class="min-h-screen font-sans bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-screen w-48 lg:w-[220px] p-6 bg-white shadow-lg flex z-50 flex-col">
            <div class="flex items-center gap-2 mb-6">
                <img src="{{ asset('storage/images/icon/LAblesMM.png') }}" alt="Logo" class="w-[230] h-auto">
                <span class="text-lg font-bold text-gray-700"></span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 items-center">
                <ul>
                    <li class="mb-6 flex items-center">
                        <i class="w-7 h-7 mr-2" data-lucide="layout-dashboard"></i>
                        <a href="{{ route('admin.index') }}" class="text-gray-900 hover:text-gray-700 text-lg font-semibold">Dashboard</a>
                    </li>
                    <li class="mb-6 flex items-center">
                        <i class="w-7 h-7 mr-2" data-lucide="credit-card"></i>
                        <a href="{{ route('admin.pengeluaran.index') }}" class="text-gray-900 hover:text-gray-700 text-lg font-semibold">Pengeluaran</a>
                    </li>
                    <li class="mb-6 flex items-center">
                        <i class="w-7 h-7 mr-2" data-lucide="wallet"></i>
                        <a href="{{ route('pemasukan.index') }}" class="text-gray-900 hover:text-gray-700 text-lg font-semibold">Pemasukan</a>
                    </li>
                    <li class="mb-6 flex items-center">
                        <i class="w-7 h-7 mr-2" data-lucide="image"></i>
                        <a href="{{ route('products') }}" class="text-gray-900 hover:text-gray-700 text-lg font-semibold">Model</a>
                    </li>
                    <li class="mb-6 flex items-center">
                        <i class="w-7 h-7 mr-2" data-lucide="users"></i>
                        <a href="{{ route('users.index') }}" class="text-gray-900 hover:text-gray-700 text-lg font-semibold">User</a>
                    </li>
                    <li class="mb-6 flex items-center">
                        <i class="w-7 h-7 mr-2" data-lucide="user-pen"></i>
                        <a href="{{ route('admin.profile.index') }}" class="text-gray-900 hover:text-gray-700 text-lg font-semibold">Profile</a>
                    </li>
                </ul>
            </nav>

            <!-- Logout -->
            <div class="mt-auto">
                <form action="{{ route('logout') }}" method="POST" class="flex items-center space-x-3">
                    @csrf
                    <div class="w-10 h-10 flex items-center justify-center bg-black rounded-lg">
                        <i data-lucide="log-out" class="h-6 text-white"></i>
                    </div>
                    <button type="submit" class="text-gray-700 hover:text-red-800 font-bold">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1  h-full pl-48 lg:pl-[220px]">

            <!-- Content Area -->
            <div class="px-5 pb-5 h-full">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        $(document).ready(function() {
        $('table.datatable').DataTable({
            responsive: true,
            ordering: true,
            language: {
                search: "" // Menghilangkan label "Search:"
            },
            "createdRow": function(row, data, dataIndex, cells) {
                // Ambil kategori dari data attribute
                const kategori = $(row).data('kategori');
                if (kategori === 'pemasukan') {
                    $(row).addClass('bg-green-100-important');
                } else if (kategori === 'pengeluaran') {
                    $(row).addClass('bg-red-100-important');
                }
            },
            "initComplete": function() {
                $('.dataTables_filter input').attr('placeholder', 'Search here...');
            }
        });
        });

        // SweetAlert for delete confirmation
        $('.delete-button').on('click', function() {
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>

    @if(session('success'))
    <script>
        window.onload = function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}"
            });
        }
    </script>
    @endif

    @if(session('error'))
    <script>
        window.onload = function() {
            Swal.fire({
                icon: 'error',
                title: 'error!',
                text: "{{ session('error') }}"
            });
        }
    </script>
    @endif


    @stack('scripts')
</body>
</html>