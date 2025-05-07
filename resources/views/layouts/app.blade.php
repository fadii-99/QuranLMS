<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title') - quranLMS</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="min-h-screen flex flex-col">
    @include('partials.nav')
    <main class="flex-grow p-6">@yield('content')</main>
  </div>
</body>
</html>
