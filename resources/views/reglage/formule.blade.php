@extends("exention.header")
@extends("exention.navbar")
@section("content")

@if (isset($result))
    <div class="container">
        <div class="fs-6"> Résultat de la formule sur un : {{ $type }} {{ $dimension }} </div>
        <table class="table table-striped  table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th scope="row">Ancien débit</th>
                    <th scope="row">Nouveau débit</th>
                </tr>
                </thead>
                <tbody>
                    <tr scope="row">
                        <td scope="row">{{ $old_debit }} / {{ $ancien }}</td>
                        <td>{{ $newDebit }} / {{ $result }}</td>
                    </tr>
                </tbody>
        </table>
        <a href="{{ route("reglage.formule", ["id" => $id+1]) }}"><button type="button" class="btn btn-primary">Puits Suivant</button></a>
    </div>
    
@endif


<div class="container mt-2">
    <div class="fs-3"> Réglages aux débit {{ $puit[0]->Name }} (Formule M/s) </div>

    <form action="{{ route("reglage") }}" method="post">
        @csrf
        <div class="mb-3">
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingInput" name="taux" value="{{ session("taux") ? session("taux") : "" }}" placeholder="Taux de conversion">
                <label for="floatingInput">Taux de réglages à effectuer</label>
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

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="name" value="{{ $puit[0]->Name }}">
        <input type="hidden" name="type" value="{{ $puit[0]->type }}">
        <input type="hidden" name="dimension" value="{{ $puit[0]->dimension }}">

        <button type="submit" class="btn btn-primary">Valider</button>
    </form>


</div>
@endsection