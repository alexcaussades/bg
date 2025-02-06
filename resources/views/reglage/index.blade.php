@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container mt-2">
    <div class="fs-3"> Réglages aux débit (Formule M/s) </div>
    <form action="{{ route('reglage.formule')}}" method="get">
        <div class="mb-3">
            <label for="puit" class="form-label">Sélectionnez un puits</label>
            <select class="form-select" name="id">
                @for ($i = 0; $i < count($route); $i++)
                    <option value="{{ $route[$i]->id }}">{{ $route[$i]->Name }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Rechercher</button>
    </form>
</div>
@endsection