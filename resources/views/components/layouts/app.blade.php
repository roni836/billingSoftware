<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Motorcycle Service Center - Inventory System</title>
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  @livewireStyles
  <style>
    .sidebar {
      transition: all 0.3s;
    }
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }
      .sidebar.active {
        transform: translateX(0);
      }
      .content-area {
        margin-left: 0 !important;
      }
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">
  <nav class="bg-white shadow p-4">
    <div class="container mx-auto flex justify-between">
      <div class="flex items-center">
        <button id="sidebar-toggle" class="mr-2 md:hidden text-gray-800">
          <i class="fas fa-bars"></i>
        </button>
        <a href="{{ route('products') }}" class="text-xl font-bold">Motorcycle Service Center</a>
      </div>
      <div class="flex items-center">
        <span class="mr-4 hidden md:inline-block">Admin</span>
        <div class="relative">
          <button id="profile-menu-button" class="flex items-center focus:outline-none">
            <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
              <i class="fas fa-user text-gray-600"></i>
            </div>
          </button>
        </div>
      </div>
    </div>
  </nav>

  <div class="flex">
    <!-- Sidebar -->
    <div class="sidebar bg-gray-800 text-white w-64 min-h-screen fixed md:static z-30 md:transform-none">
      <div class="p-4">
        <div class="mb-8 mt-4">
          <h2 class="text-2xl font-semibold">Admin Panel</h2>
        </div>
        <ul>
          <li class="mb-3">
            <a href="{{ route('dashboard') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
              <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
          </li>
          <li class="mb-3">
            <a href="{{ route('products') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
              <i class="fas fa-tools mr-3"></i> Spare Parts
            </a>
          </li>
          <li class="mb-3">
            <a href="{{ route('product-categories') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
              <i class="fas fa-tags mr-3"></i> Part Categories
            </a>
          </li>
          <li class="mb-3">
            <a href="{{ route('purchases') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
              <i class="fas fa-shopping-cart mr-3"></i> Purchases
            </a>
          </li>
          <li class="mb-3">
            <a href="{{ route('sales') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
              <i class="fas fa-cash-register mr-3"></i> Sales
            </a>
          </li>
          <li class="mb-3">
            <a href="{{ route('services') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
              <i class="fas fa-wrench mr-3"></i> Services
            </a>
          </li>
          <li class="mb-3">
            <a href="{{ route('customers') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
              <i class="fas fa-users mr-3"></i> Customers
            </a>
          </li>
          <li class="mb-3">
            <a href="{{ route('reports') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
              <i class="fas fa-chart-bar mr-3"></i> Reports
            </a>
          </li>
          <li class="mb-3">
            <a href="{{ route('settings') }}" class="flex items-center p-2 hover:bg-gray-700 rounded">
              <i class="fas fa-cog mr-3"></i> Settings
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Main Content -->
    <div class="content-area flex-1 p-4">
      {{ $slot }}
    </div>
  </div>

  @livewireScripts
  <script src="{{ mix('js/app.js') }}"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Sidebar toggle for mobile
      const sidebarToggle = document.getElementById('sidebar-toggle');
      const sidebar = document.querySelector('.sidebar');
      
      if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
          sidebar.classList.toggle('active');
        });
      }
      
      // Close sidebar when clicking outside of it on mobile
      document.addEventListener('click', function(event) {
        if (window.innerWidth < 768 && sidebar.classList.contains('active')) {
          if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
            sidebar.classList.remove('active');
          }
        }
      });
    });

  </script>
</body>
</html>
