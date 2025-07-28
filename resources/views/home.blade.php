@extends("exention.header")
@extends("exention.navbar")
@section("content")

<div class="container mt-5">
  @auth()
    <div class="fs-5 m-2">Bienvenue: {{ auth()->user()->name }}</div>
  @endauth
    
    <div class="card text-white bg-dark mt-2">
      <div class="card-body">
        <h4 class="card-title"><i class="bi bi-calculator"></i> Débit </h4>
        <p class="card-text">Voici une méthode de calcul simplifiée pour estimer le débit de biogaz :  <a href="{{ route("debit") }}"><button class="btn btn-info" type="submit"><i class="bi bi-arrow-right-circle"></i> Plus d'infos</button></a></p>
      </div>
    </div>

    <div class="card text-white bg-dark mt-2">
      <div class="card-body">
        <h4 class="card-title"><i class="bi bi-calculator"></i> Réglage </h4>
        <p class="card-text"> Le réglage au taux particulier qui fait référence à l'optimisation de la collecte et de l'extraction du biogaz :  <a href="{{ route("reglage.index") }}"><button class="btn btn-info" type="submit"><i class="bi bi-arrow-right-circle"></i> Plus d'infos </button></a></p>
      </div>
    </div>

        <h4 class="mt-2"> <i class="bi bi-activity"></i> Statistiques </h4>
            <div class="text-center row mt-2">
              <div class="col-sm-4 mt-2">
                <div class="card text-white bg-dark">
                  <div class="card-body">
                    <h4 class="card-title"><i class="bi bi-activity"></i></h4>
                    <p class="card-text fs-3 fw-bold">
                      Puits: {{ $puits }}
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 mt-2">
                <div class="card text-white bg-dark">
                  <div class="card-body">
                    <h4 class="card-title"><i class="bi bi-hurricane"></i></h4>
                    <p class="card-text fs-3 fw-bold">
                      Mesures: {{ $data }}
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 mt-2">
                <div class="card text-white bg-dark">
                  <div class="card-body">
                    <h4 class="card-title"><i class="bi bi-card-checklist"></i></h4>
                    <p class="card-text fs-3 fw-bold">
                      Notes: {{ $note }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-12">
      <a href="https://github.com/alexcaussades/bg"><i class="bi bi-github fs-2 link-dark float-end pm-2 ms-2"></i></a>
      <button type="button" class="btn btn-sm btn-dark float-end pm-2 ms-2 text-bg-dark" data-bs-toggle="modal" data-bs-target="#githubModal">
        Issues <span class="badge text-bg-success text-bg-dark">{{ $open_issues }}</span>
      </button>
      <a href="mailto:contact@regbio.fr"><i class="bi bi-envelope-at-fill fs-2 link-dark float-end pm-2 ms-2"></i></a>
      <div class=" float-end ms-2 pt-2">{{ $last_release }}</div>
    </div>
  </div>
</div>

@endsection