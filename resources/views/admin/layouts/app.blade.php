<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Pin Paws Affiliates Backoffice">
    <meta name="keywords" content="Pin Paws, Affiliates Backoffice">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/img/favicon.png') }}" />
    <title>Pin Paws Affiliates Backoffice</title>
    @include('admin.layouts.includes.header_css')
</head>

<body>
    {{-- <div class="loader"></div> --}}
    <div class="container-scroller">
        @include('admin.layouts.includes.sidebar')
        <div class="container-fluid page-body-wrapper">
            @include('admin.layouts.includes.header')
            <div class="main-panel">
                @yield('content')
                @include('admin.layouts.includes.footer')
            </div>
        </div>
    </div>
</body>
@include('admin.layouts.includes.footer_js')

</html>
