@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Ajustement de la vitesse")
@section("content")

@if (isset($result))
    <div class="container">
        <div class="fs-6"> Résultat </div>
        <table class="table table-striped  table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th scope="row">Nouvelle vitesse</th>
                </tr>
                </thead>
                <tbody>
                    <tr scope="row">
                        <td>{{ $result }}</td>
                    </tr>
                </tbody>
        </table>
        <a href="{{ route("reglage.formule", ["id" => $id]) }}"><button type="button" class="btn btn-primary">Puits Suivant</button></a>
        <a href="{{ route("note.reglage.create.id", ["id" => $note, "id2" => $id ]) }}"><button type="button" class="btn btn-success">Note</button></a>
    </div>
    
@endif


<div class="container mt-2">
    <div class="fs-5"> Ajustement du: {{ $puit[0]->Name }} ({{ $puit[0]->type }} D.{{ $puit[0]->dimension }}) </div>
    <form action="{{ route("reglage.ajuter.view") }}" method="post" class="mt-2">
        @csrf
        <div class="mb-3">
            <div class="form-floating mb-3">
                <input type="number" class="form-control" step="0.01" id="floatingInput" name="debit">
                <label for="floatingInput">Debit rechercher ?</label>
            </div>
        </div>

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="name" value="{{ $puit[0]->Name }}">
        <input type="hidden" name="type" value="{{ $puit[0]->type }}">
        <input type="hidden" name="dimension" value="{{ $puit[0]->dimension }}">

        <button type="submit" class="btn btn-primary"><i class="bi bi-calculator"></i> Ajuter la vitesse</button>
    </form>


</div>

@endsection