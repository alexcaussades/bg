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
        

@endsection