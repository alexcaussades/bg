@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container mt-2">
    <div class="fs-3"> Réglages aux débit (Formule M/s) </div>

    <form action="{{ route("reglage") }}" method="post">
        @csrf
        <div class="mb-3">
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingInput" name="taux" value="{{ session("taux") ? session("taux") : "" }}" placeholder="Taux de conversion">
                <label for="floatingInput">Taux de réglages à éffectuer</label>
            </div>
            <div class="form-floating mb-3 mt-2">
                <input type="number" class="form-control" id="floatingInput" step="0.01" name="ch4" placeholder="Taux de CH4">
                <label for="floatingInput">Taux de CH4</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingInput" step="0.01" name="ms" placeholder="M/s de débit">
                <label for="floatingInput">M/s de débit</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
@if ($result)
    <hr>
    <div class="mt-5">
        <div class="fs-3">Résultat</div>
        <div class="fs-5">Le Réglages est de : <span class="fw-bold">{{ $result }}</span> M/s</div>
    </div>
    
@endif

</div>
@endsection