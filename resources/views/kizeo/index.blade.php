@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container mt-5">
<h3>Rapport Kizeo</h3>


@if (session('success'))
    <div class="alert alert-success" role="alert">
        <strong><i class="bi bi-check-circle fs-5"></i> {{ session('success') }}</strong>
    </div>
@endif


<h4 class="mt-5">Recherche de rapports Kizeo Journalier</h4>
    <p>Pour rechercher des rapports Kizeo, veuillez sélectionner une date.</p>

        <form method="GET" action="{{ route('kizeo.rapport_journalier') }}" class="form-inline">

            <!-- CSRF Token -->
            @csrf
            <div class="mb-3">
                <label for="Date" class="form-label">Date</label>
                <input type="date" class="form-control" id="Date" name="date" required>
                <input type="submit" value="Valider" class="btn btn-primary mt-3">
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
            <input type="date" class="form-control" id="Date" name="date_in" required>
            <label for="Date" class="form-label mt-2">Date pour la fin du rapport</label>
            <input type="date" class="form-control" id="Date" name="date_out" required>
        </div>
        <div class="mb-3">
            <select class="form-select" name="rapport" aria-label="Default select example">
                <option selected value="biogaz_caisson">Biogaz & Caisson Vapo & Torch</option>
                <option value="bassin_ttcr">Bassin & TTCR</option>
            </select>
        </div>
        <input type="submit" value="Valider" class="btn btn-primary mt-3">
    </form>
</div>
@endsection