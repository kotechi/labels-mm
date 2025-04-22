<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/images/icon/logo.jpg') }}">
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

    {{-- main content style --}}
    main {
        transition: padding-left 0.3s ease-in-out;
    }

    {{-- loading screen styles --}}
    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.5s ease-out;
    }
    
    .loading-spinner {
        text-align: center;
    }
    
    .spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 0 auto 15px;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    {{-- validation form message --}}
    .text-red-500 {
        transition: opacity 0.5s ease-out;
    }
    .text-red-500.hide {
        opacity: 0;
    }

    {{-- DataTables styles --}}
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


    aside {
        transition: width 0.3s ease-in-out;
        overflow: visible !important;
        width: 220px; 
    }
    
    aside.collapsed {
        width: 4rem !important;
        padding: 1.25rem;
    }
    
    aside.collapsed #sidebar-toggle {
        opacity: 0;
    }
    aside.collapsed:hover #sidebar-toggle {
        opacity: 1;
    }


    aside.collapsed .sidebar-text {
        display: none;
    }
    
    aside.collapsed .sidebar-logo span {
        display: none;
    }
    
    aside.collapsed .sidebar-logo img {
        width: 2.5rem;
        height: 2.5rem;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    aside.collapsed nav ul li {
        justify-content: center;
        padding-left: 0 !important; 
    }
    
    aside.collapsed nav ul li i {
        margin-right: 0 !important; 
    }

    aside.collapsed nav ul li a {
        margin-left: 0 !important; 
        justify-content: center !important;
    }

    aside.collapsed .mt-auto form {
        justify-content: center;
        padding-left: 0 !important;
    }
    
    aside.collapsed:hover {
        width: 220px !important; 
    }

    aside.collapsed:hover .sidebar-text {
        display: inline;
    }

    aside.collapsed:hover .sidebar-logo img {
        width: auto;
        height: auto;
        margin: 0; 
    }

    aside.collapsed:hover nav ul li {
        justify-content: flex-start;
    }

    aside.collapsed:hover nav ul li i {
        margin-right: 0.5rem !important; 
    }

    aside.collapsed:hover nav ul li a {
        justify-content: flex-start !important;
        margin-left: 0 !important;
    }

    aside.collapsed:hover .mt-auto form {
        justify-content: flex-start;
    }

    #sidebar-toggle {
        position: absolute;
        top: 1rem;
        right: 15px;
        background: #f9fafb;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #374151;
        z-index: 60;
        transform: translateX(50%);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    #sidebar-toggle:hover {
        background: #f3f4f6;
        color: #1f2937;
    }
    
    #sidebar-toggle svg {
        transition: transform 0.3s ease;
    }
    
    aside.collapsed #sidebar-toggle img {
        transform: rotate(180deg);
    }
    



    .sidebar-notification {
        position: absolute;
        right: 4px;
        top: -4px;
        min-width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        z-index: 10; 
    }
    
    main.sidebar-collapsed {
        padding-left: 4rem !important;
    }

    aside.collapsed .sidebar-notification {
        transform: scale(0.5);
        right: 10px;
    }

    aside.collapsed li:hover div[class*="absolute left-full"] {
        left: 4rem;
        top: 0;
    }

    aside.collapsed:hover .sidebar-notification {
        right: 4px;
        transform: scale(1);
    }

    aside:not(.collapsed) li:hover div[class*="absolute left-full"] {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    aside li div[class*="absolute left-full"] {
        z-index: 100;
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
        display: none;
    }

    aside li:hover div[class*="absolute left-full"] {
        opacity: 1;
        visibility: visible;
        display: block;
    }

    aside li .absolute.left-full {
        left: 100%;
        top: 0;
        margin-left: 8px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    aside li:hover .absolute.left-full {
        opacity: 1;
        visibility: visible;
    }

    aside.collapsed li .absolute.left-full {
        left: 4rem;
    }

    aside.collapsed:hover li .absolute.left-full {
        left: 100%;
    }

    .tooltip {
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        margin-left: 12px;
        background: #1f2937;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 14px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        z-index: 100;
        pointer-events: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    /* Tooltip arrow */
    aside li .tooltip::after {
        content: '';
        position: absolute;
        right: 100%;
        top: 50%;
        transform: translateY(-50%);
        border-width: 5px;
        border-style: solid;
        border-color: transparent #1f2937 transparent transparent;
    }

    aside li:hover .tooltip {
        opacity: 1;
        visibility: visible;
    }

    aside.collapsed li .tooltip {
        left: calc(4rem + 12px);
    }

    aside.collapsed:hover li .tooltip {
        left: 100%;
    }
</style>
<body class="min-h-screen font-sans bg-gray-100">
    <!-- Loading Screen -->
<div id="loading-screen">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <p>Loading...</p>
    </div>
</div>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-screen w-48 lg:w-[220px] p-6 bg-white shadow-lg flex z-50 flex-col">
            <!-- Toggle Button -->
            <button id="sidebar-toggle" aria-label="Toggle Sidebar" class="w-2 h-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            
            <div class="flex items-center gap-2 mb-4 sidebar-logo">
                <img src="{{ asset('storage/images/icon/logo.svg') }}" alt="Logo" class="w-[230] h-auto">
                <span class="text-lg font-bold text-gray-700 sidebar-text"></span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 items-center">
                <ul>
                    <li class="mb-4 flex items-center">
                        <a href="{{ route('admin.index') }}" class="flex items-center text-gray-900 hover:text-gray-700">
                            <i class="w-7 h-7" data-lucide="layout-dashboard"></i>
                            <span class="ml-2 text-lg font-semibold sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-4 flex items-center">
                        <a href="{{ route('admin.pengeluaran.index') }}" class="flex items-center text-gray-900 hover:text-gray-700">
                            <i class="w-7 h-7" data-lucide="credit-card"></i>
                            <span class="ml-2 text-lg font-semibold sidebar-text">Pengeluaran</span>
                        </a>
                    </li>
                    <li class="mb-4 flex items-center">
                        <a href="{{ route('pemasukan.index') }}" class="flex items-center text-gray-900 hover:text-gray-700">
                            <i class="w-7 h-7" data-lucide="wallet"></i>
                            <span class="ml-2 text-lg font-semibold sidebar-text">Pemasukan</span>
                        </a>
                    </li>
                    <li class="mb-4 flex items-center relative">
                        <a href="{{ route('products') }}" class="flex items-center text-gray-900 hover:text-gray-700">
                            <i class="w-7 h-7" data-lucide="image"></i>
                            <span class="ml-2 text-lg font-semibold sidebar-text">Model</span>
                            @if(isset($outOfStockCount) && $outOfStockCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center sidebar-notification">
                                    {{ $outOfStockCount }}
                                </span>
                                <div class="tooltip">
                                    {{ $outOfStockCount }} model habis stok!
                                </div>
                            @endif
                        </a>
                    </li>
                    <li class="mb-4 flex items-center">
                        <a href="{{ route('users.index') }}" class="flex items-center text-gray-900 hover:text-gray-700">
                            <i class="w-7 h-7" data-lucide="users"></i>
                            <span class="ml-2 text-lg font-semibold sidebar-text">User</span>
                        </a>
                    </li>
                    <li class="mb-4 flex items-center">
                        <a href="{{ route('admin.profile.index') }}" class="flex items-center text-gray-900 hover:text-gray-700">
                            <i class="w-7 h-7" data-lucide="user-pen"></i>
                            <span class="ml-2 text-lg font-semibold sidebar-text">Profile</span>
                        </a>
                    </li>
                    <li class="mb-4 flex items-center">
                        <a href="{{ route('admin.company.index') }}" class="flex items-center text-gray-900 hover:text-gray-700">
                            <i class="w-7 h-7" data-lucide="layout-template"></i>
                            <span class="ml-2 text-lg font-semibold sidebar-text">Company Profile</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Logout -->
            <div class="mt-auto">
                <form action="{{ route('logout') }}" method="POST" class="flex space-x-2">
                    @csrf
                    <button type="submit" class="flex items-center">
                        <div class="w-9 h-9 p-2 flex items-center justify-center bg-black rounded-lg hover:bg-gray-800 cursor-pointer" id="logout_icon">
                            <i data-lucide="log-out" class="h-6 text-white"></i>
                        </div>
                        <span class="ml-3 text-gray-700 hover:text-red-800 font-bold sidebar-text">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 h-full pl-48 mt-2 lg:pl-[220px]">
            <!-- Content Area -->
            <div class="px-5 pb-5 h-full">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('aside');
            const mainContent = document.querySelector('main');
            const toggleButton = document.getElementById('sidebar-toggle');
            
            // Check local storage for sidebar state
            const isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            // Apply saved state on page load
            if (isSidebarCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('sidebar-collapsed');
                
                // Update toggle button icon
                toggleButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                `;
            }
            
            // Toggle sidebar on button click
            toggleButton.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('sidebar-collapsed');
                
                // Save state to local storage
                const isNowCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isNowCollapsed);
                
                // Update toggle button icon based on state
                if (isNowCollapsed) {
                    toggleButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg"  width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    `;
                } else {
                    toggleButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg"  width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    `;
                }
            });
        });

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sembunyikan loading screen saat halaman selesai dimuat
            const loadingScreen = document.getElementById('loading-screen');
            
            // Tambahkan delay kecil untuk memastikan semua aset dimuat
            setTimeout(function() {
                loadingScreen.style.opacity = '0';
                setTimeout(function() {
                    loadingScreen.style.display = 'none';
                }, 500); // Waktu sesuai dengan durasi transisi CSS
            }, 300);
        });
        
        // Tampilkan loading saat navigasi halaman
        document.addEventListener('click', function(e) {
            // Periksa jika yang diklik adalah link halaman internal
            const target = e.target.closest('a');
            if (target && target.href && target.href.startsWith(window.location.origin) && !target.hasAttribute('data-no-loading')) {
                const loadingScreen = document.getElementById('loading-screen');
                loadingScreen.style.display = 'flex';
                loadingScreen.style.opacity = '1';
            }
        });
    </script>

    @stack('scripts')
</body>
</html>