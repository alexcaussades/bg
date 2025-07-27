@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Nouveau Relevé de la TTCR")
@section("content")


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Nouveau Relevé de la TTCR</h1>
            <form action="{{ route('ttcr.store') }}" method="post">
                @csrf
                <div class="form-group mt-2">
                    <label for="compteur">Compteur totalisateur: </label>
                    <input type="number" name="compteur" id="compteur" class="form-control" placeholder="Compteur totalisateur en M3 " required>
                    <label for="hauteur" class="mt-2">Volume restant dans la bâche: </label>
                    <input type="number" name="hauteur" id="hauteur" class="form-control" placeholder="Lecture de la hauteur cm ex: (1.5 taper 150) " required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Enregistrer</button>
                <a href="{{ route('ttcr.index') }}" class="btn btn-secondary mt-2">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection