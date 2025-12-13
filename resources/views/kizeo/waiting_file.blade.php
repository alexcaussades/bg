@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Importer un rapport Kizeo")
@section("content")


<div class="container mt-5">
<h3>Importer des rapport Kizeo</h3>

<p>Sélectionnez des fichiers Excel (.xlsx) pour importer les données.</p>


@if (session('success'))
    <div class="alert alert-success" role="alert">
        <strong><i class="bi bi-check-circle fs-5"></i> {{ session('success') }}</strong>
    </div>
@endif


<form method="POST" action="{{ route('kizeo.import_kizeo') }}" enctype="multipart/form-data">

    <!-- CSRF Token -->
    @csrf

    <div class="mb-3">
        <label for="date" class="form-label">Date du jour des rapports</label>
        <input type="date" name="date" id="date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Choisir le fichier Excel pour les <strong> Bassins </strong> (.xlsx) à importer</label>
        <input class="form-control" type="file" id="formFile" name="bassin_file" accept=".csv , .xlsx">
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Choisir le fichier Excel pour les <strong> BG500 - Vapo</strong> (.xlsx) à importer</label>
        <input class="form-control" type="file" id="formFile" name="bg500_vapo_file" accept=".csv , .xlsx">
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Choisir le fichier Excel pour les <strong> BG1000 </strong> (.xlsx) à importer</label>
        <input class="form-control" type="file" id="formFile" name="bg1000_file" accept=".csv , .xlsx" disabled>
        
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Choisir le fichier Excel pour les <strong> Biogaz </strong> (.xlsx) à importer</label>
        <input class="form-control" type="file" id="formFile" name="biogaz_file" accept=".csv , .xlsx">
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Choisir le fichier Excel pour les <strong> TTCR </strong> (.xlsx) à importer</label>
        <input class="form-control" type="file" id="formFile" name="ttcr_file" accept=".csv , .xlsx">
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">Choisir le fichier Excel pour les <strong> Puits lixivats </strong> (.xlsx) à importer</label>
        <input class="form-control" type="file" id="formFile" name="puits_lix" accept=".csv , .xlsx">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="option" value="1" id="checkDefault">
            <label class="form-check-label" for="checkDefault">
                Mesure Mensuel
            </label>
        </div>
    </div>
    {{-- <div class="alert alert-warning" role="alert">
        <strong><i class="bi bi-exclamation-triangle fs-5"></i> l'import de celle-ci sont irréversible</strong>
    </div> --}}

    <button class="btn btn-info" type="submit" ><i class="bi bi-database-fill-up fs-5"></i> Importer le fichier</button>

</form>
</div>
@endsection