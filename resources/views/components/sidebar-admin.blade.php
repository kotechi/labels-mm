<div class="fixed top-0 left-0 h-screen w-64 p-6 bg-white shadow-lg flex flex-col">
  <div class="flex items-center gap-2 mb-6">
      <img src="{{ asset('storage/images/icon/LAblesMM.png') }}" alt="Logo" class="w-auto h-auto">
      <span class="text-lg font-bold text-gray-700"></span>
  </div>

  <!-- Navigation -->
  <nav class="flex-1">
      <ul>
          <li class="mb-4 flex items-center">
              <i data-lucide="layout-dashboard" class="w-5 h-5 mr-2"></i>
              <a href="{{ route('admin.index') }}" class="text-gray-700 hover:text-gray-900 font-bold">Dashboard</a>
          </li>
          <li class="mb-4 flex items-center">
              <i data-lucide="credit-card" class="w-5 h-5 mr-2"></i>
              <a href="{{ route('admin.pengeluaran.index') }}" class="text-gray-700 hover:text-gray-900 font-bold">Pengeluaran</a>
          </li>
          <li class="mb-4 flex items-center">
              <i data-lucide="wallet" class="w-5 h-5 mr-2"></i>
              <a href="{{ route('pemasukan.index') }}" class="text-gray-700 hover:text-gray-900 font-bold">Pemasukan</a>
          </li>
          <li class="mb-4 flex items-center">
              <i data-lucide="image" class="w-5 h-5 mr-2"></i>
              <a href="{{ route('products') }}" class="text-gray-700 hover:text-gray-900 font-bold">Galeri</a>
          </li>
          <li class="mb-4 flex items-center">
              <i data-lucide="user" class="w-5 h-5 mr-2"></i>
              <a href="{{ route('users.index') }}" class="text-gray-700 hover:text-gray-900 font-bold">User</a>
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
</div>