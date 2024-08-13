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
    <div class="row py-3 px-3">
        <div class="col-lg-4 col-sm-6 mx-auto">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Current Status</th>
                    </tr>
                </thead>
                <tbody id="bc-tbody">
                    @foreach ($bcstatus as $bc)
                        <tr>
                            <td>{{ $bc->barcode }}</td>
                            <td>{{ $bc->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>     
    </div>
    
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.socket.io/4.3.2/socket.io.min.js"></script>
    <script src="{{ asset('js/shared.js') }}"></script>
    <script src="{{ asset('js/dashboard.js')}}"></script>
</div>
</body>

</html>