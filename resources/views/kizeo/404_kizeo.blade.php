@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Aucun résultat trouvé")
@section("content")



<div class="container mt-5">
    <h1> <i class="bi bi-sign-stop"></i> Aucune donnée disponible</h1>
    <div class="alert alert-danger" role="alert">
        <p>La recherche sur la date <strong>{{ $date }}</strong> n'a donné aucun résultat.</p>
    </div>
    <a href="{{ route('kizeo.index') }}" class="btn btn-primary">Retour aux formulaires</a>
</div>


@endsection