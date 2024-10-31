<nav class="navbar navbar-expand-lg bg-qcventory" data-bs-theme="light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ url('/') }}">QCVentory</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0"> 
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
              Inventory
            </a>
            <ul class="dropdown-menu">
              <li><a href="#" class="dropdown-item" @disabled(true)>MELTING</a></li>
              <li><a href="{{route('inventory.index')}}" class="dropdown-item">Create Package</a></li>
              <li><a href="{{route('inventory.index')}}" class="dropdown-item">Receive Box</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a href="#" class="dropdown-item" @disabled(true)>CASTING</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a href="#" class="dropdown-item" @disabled(true)>CUTTING</a></li>
            </ul>
          </li>
          {{-- <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
              Jujo
            </a>
            <ul class="dropdown-menu">
              <li><a href="#" class="dropdown-item" @disabled(true)>MELTING</a></li>
              <li><a href="{{route('melting.jujo')}}" class="dropdown-item">Melting Receive</a></li>
              <li><a href="{{route('melting.jujo-box')}}" class="dropdown-item">Melting Box</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a href="#" class="dropdown-item" @disabled(true)>CASTING</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a href="#" class="dropdown-item" @disabled(true)>CUTTING</a></li>
            </ul>
          </li> --}}
          
        </ul>
        <form class="d-flex" role="search" id="search-form">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search-box">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
      
    </div>
  </nav>