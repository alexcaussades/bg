<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('home') }}"><i class="bi bi-house-fill"></i> Home</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route("history") }}"><i class="bi bi-clipboard2-data"></i> Historique</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-geo-alt"></i> Puits
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ Route("history.puit") }}">Recherche Puits</a></li>
                <li><a class="dropdown-item" href="{{ Route("puits.show") }}">Liste des puits</a></li>
              <li><a class="dropdown-item" href="{{ Route("puits.retard") }}">En retard</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-database-add"></i> Import
            </a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ Route('import_data') }}"><i class="bi bi-filetype-csv"></i> Import Mesures</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ Route('import.Borehole') }}"><i class="bi bi-filetype-xml"></i> Import Boreholes</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href={{ Route("import.route") }}><i class="bi bi-filetype-xml"></i> Import Route pour le reglages</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ Route('note') }}"><i class="bi bi-journal-plus"></i> Note</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ Route('consignation.index') }}" title="Consignation & maintenance"><i class="bi bi-wrench-adjustable"></i> Consigner une action</a>
          </li>
          @if (Cookie::get("last_id") != null)
            <li class="nav-item">
              <a class="nav-link" href="{{ Route('reglage.formule', ['id' => Cookie::get("last_id") + 1]) }}"><i class="bi bi-calculator"></i> Réglage</a>
            </li>
          @endif
        </ul>
        <form action="{{ route("sr") }}" method="get" class="d-flex" role="search">
          <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>