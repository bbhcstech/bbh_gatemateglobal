<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @include('admin.layout.header')
</head>
<body>

@include('admin.layout.manu')

<main class="container-fluid mt-3">
    @yield('content')
</main>

@include('admin.layout.footer')

{{-- VERY IMPORTANT --}}
@stack('scripts')

</body>
</html>
