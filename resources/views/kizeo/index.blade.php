@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Recherche de Rapport")
@section("content")


<div class="container mt-5">

<a href="{{ route('kizeo.import') }}" class="btn btn-success float-end">Importer un rapport</a>

<h4 class="mt-2">Recherche de rapports Kizeo Journalier</h4>
    <p>Pour rechercher des rapports Kizeo, veuillez sélectionner une date.</p>

        <form method="GET" action="{{ route('kizeo.rapport_journalier') }}" class="form-inline">

            <!-- CSRF Token -->
            @csrf
            <div class="mb-3">
                <label for="Date" class="form-label">Date</label>
                <input type="date" class="form-control form-control-sm" id="Date" name="date" required>
                <input type="submit" value="Valider" class="btn btn-secondary btn-sm mt-3">
            </div>

        </form>

<hr class="mt-2">

<div class="container mt-2">
    <h4>Rapports Kizeo Hebdomadaire</h4>
    <p class="mt-2">Veuillez sélectionner une date de début et une date de fin pour générer le rapport hebdomadaire.</p>

    <form method="GET" action="{{ route('kizeo.rapport_hebdomadaire') }}" class="form-inline">
        <!-- CSRF Token -->
        @csrf
        <div class="mb-3">
            <label for="Date" class="form-label">Date pour le début du rapport</label>
            <input type="date" class="form-control form-control-sm" id="Date" name="date_in" required>
            <label for="Date" class="form-label mt-2">Date pour la fin du rapport</label>
            <input type="date" class="form-control form-control-sm" id="Date" name="date_out" required>
        </div>
        <input type="submit" value="Valider" class="btn btn-secondary btn-sm mt-3">
    </form>
</div>
@endsection