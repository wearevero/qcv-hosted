<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QCVeintory-Dev</title>
    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- Custom Styles --}}
    <link rel="stylesheet" href="{{ asset('css/qcventory.css') }}">
    {{-- Custom Icon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('icon/qcventory.png') }}">
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <?php
        $requrl = Request::path();
        $segment = explode("/", $requrl);
        $group = $segment[0];
        switch($group) {
            case 'Inventory': $header = 'Templatez.header-inventory'; break;
            case 'Jujo': $header = 'Templatez.header-jujo'; break;
            default: $header = 'Templatez.header';
        }
        ?>
        {{-- @include('Templatez.header') --}}
        @include($header)
    </div>
    @include('Templatez.page-header')
    
    @yield('content')
    @yield('modals')
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.socket.io/4.3.2/socket.io.min.js"></script>
    <script>
    const socket = io('http://10.10.11.11:3010');
    </script>
    @yield('scripts')

</div>
</body>

</html>