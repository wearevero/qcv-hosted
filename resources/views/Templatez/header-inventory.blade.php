<nav class="navbar navbar-expand-lg bg-qcventory" data-bs-theme="light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ url('/') }}">QCVentory</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0"> 
            <li class="nav-item nav-boxed">
                <a class="nav-link" href="{{route('inventory.index')}}">Buat Paket</a>
            </li>   
            <li class="nav-item nav-boxed">
                <a class="nav-link" href="{{route('inventory.index')}}">Terima Box</a>
            </li>   
        </ul>
        <form class="d-flex" role="search" id="search-form">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search-box">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
      
    </div>
  </nav>