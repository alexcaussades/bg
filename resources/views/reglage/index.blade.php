@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container mt-5">
    <div class="fs-3"> Définir le taux. </div>

    <form action="{{ route("reglage") }}" method="post">
        @csrf
        <div class="mb-3">
            <input type="number" class="form-control" id="taux" name="taux">
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>

</div>
@endsection