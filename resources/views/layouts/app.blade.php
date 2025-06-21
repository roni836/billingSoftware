<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory Billing</title>
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @livewireStyles
</head>
<body class="bg-gray-100 font-sans">
  <nav class="bg-white shadow p-4">
    <div class="container mx-auto flex justify-between">
      <a href="{{ route('products') }}" class="text-xl font-bold">Inventory</a>
      <div>
        <a href="{{ route('products') }}" class="mr-4">Products</a>
        <a href="{{ route('purchases') }}" class="mr-4">Purchases</a>
        <a href="{{ route('sales') }}">Sales</a>
      </div>
    </div>
  </nav>
  <main class="container mx-auto p-4">
    {{ $slot }}
  </main>
  @livewireScripts
  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
