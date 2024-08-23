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
        <div class="col jumbotronz">
            <h1>Inventory Quality Control System</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="{{ url('/Inventory')}}">Inventory</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="{{ url('/Jujo')}}">Jujo</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">MELTING</div>
                <div class="card-body">
                    <h4>Current Progress Status</h4>
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
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">CASTING</div>
                <div class="card-body"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">CUTTING</div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
    
    
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.socket.io/4.3.2/socket.io.min.js"></script>
    <script src="{{ asset('js/shared.js') }}"></script>
    <script src="{{ asset('js/dashboard.js')}}"></script>
</div>
</body>

</html>