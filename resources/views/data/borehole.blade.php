@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container mt-5">
<h3>Vous avez un nouveau fichier Borehole ? </h3>

<p>Sélectionnez le fichier (Borehole.xml) pour importer les données.</p>


@if (session('success'))
    <div class="alert alert-success" role="alert">
        <strong><i class="bi bi-check-circle fs-5"></i> {{ session('success') }}</strong>
    </div>
@endif


<form method="POST" action="{{ route('import.Borehole.import') }}" enctype="multipart/form-data" >

    <!-- CSRF Token -->
    @csrf


    <div class="mb-3">
        <label for="formFile" class="form-label">Nouvelle données pour la configuration de votre site</label>
        <input class="form-control" type="file" id="formFile" name="fichier" accept=".xml">
    </div>
    <div class="alert alert-warning" role="alert">
        <strong><i class="bi bi-exclamation-triangle fs-5"></i> l'import de celle-ci est irréversible. </strong>
    </div>

    <button class="btn btn-info" type="submit" ><i class="bi bi-database-fill-up fs-5"></i> Importer le fichier</button>

</form>
</div>
@endsection