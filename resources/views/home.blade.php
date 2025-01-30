@extends("exention.header")

@section("content")

<div class="container mt-5">
    
    <div class="card text-white bg-dark">
      <div class="card-body">
        <h4 class="card-title"><i class="bi bi-calculator"></i> Débit </h4>
        <p class="card-text">Voici une méthode de calcul simplifiée pour estimer le débit de biogaz :  <a href="{{ route("debit") }}"><button class="btn btn-info" type="submit"><i class="bi bi-arrow-right-circle"></i> Plus d'infos</button></a></p>
      </div>
    </div>

    <div class="card text-white bg-dark mt-2">
      <div class="card-body">
        <h4 class="card-title"><i class="bi bi-calculator"></i> Réglage au taux </h4>
        <p class="card-text"> le réglage au taux particulier qui fait référence à l'optimisation de la collecte et de l'extraction du biogaz :  <a href="{{ route("debit") }}"><button class="btn btn-info" type="submit"><i class="bi bi-arrow-right-circle"></i> Plus d'infos </button></a></p>
      </div>
    </div>
    
</div>

@endsection