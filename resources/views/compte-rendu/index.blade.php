@extends("exention.header")
@extends("exention.navbar")
@section("content")

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-2">
            <h1>Compte Rendu Journalier.</h1>
            <a href="{{ route('compte-rendu.create') }}" class="btn btn-success my-3">Ajouter</a>
        </div>
    </div>
</div>

@endsection