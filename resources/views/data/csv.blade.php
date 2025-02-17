@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container mt-5">
<h3>Vous avez des nouvelles mesures ? </h3>

<p>Sélectionnez un fichier Excel (.csv) pour importer les données.</p>


@if (session('success'))
    <div class="alert alert-success" role="alert">
        <strong><i class="bi bi-check-circle fs-5"></i> {{ session('success') }}</strong>
    </div>
@endif


<form method="POST" action="{{ route('import_data.import') }}" enctype="multipart/form-data" >

    <!-- CSRF Token -->
    @csrf


    <div class="mb-3">
        <label for="formFile" class="form-label">Nouvelle données du Trigaz ! </label>
        <input class="form-control" type="file" id="formFile" name="fichier" accept=".csv , .xlsx">
    </div>
    <div class="alert alert-warning" role="alert">
        <strong><i class="bi bi-exclamation-triangle fs-5"></i> l'import de celle-ci sont irréversible</strong>
    </div>

    <button class="btn btn-info" type="submit" ><i class="bi bi-database-fill-up fs-5"></i> Importer le fichier</button>

</form>
</div>
@endsection