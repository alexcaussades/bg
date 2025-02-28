@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Nouveau Relevé de la TTCR</h1>
            <form action="{{ route('ttcr.store') }}" method="post">
                @csrf
                <div class="form-group mt-2">
                    <label for="compteur">Compteur totalisateur: </label>
                    <input type="number" name="compteur" id="compteur" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary mt-5">Enregistrer</button>
                <a href="{{ route('ttcr.index') }}" class="btn btn-secondary mt-5">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection