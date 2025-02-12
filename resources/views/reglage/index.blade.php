@extends("exention.header")
@extends("exention.navbar")
@section("content")

<script>
 // Remove the last id from the cookie on js
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('remove_list').addEventListener('click', function() {
            document.cookie = "last_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            // console.log('cookie removed');
            //recharger la page
            location.reload();
        });
    });

</script>


@if (Cookie::get('last_id') != null)
<div class="container mt-2">
<button type="submit" class="btn btn-sm btn-secondary" id="remove_list">Retourner à la liste complète ci-dessous</button>
</div>
    
@endif

<div class="container mt-2">
    <div class="fs-3"> Réglages aux débit (Formule M/s) </div>
    <form action="{{ route('reglage.formule')}}" method="get">
        <div class="mb-3">
            <label for="puit" class="form-label">Sélectionnez un puits</label>
            <select class="form-select" name="id">
                @if (isset($id))
                    @for ($i = $id; $i < count($route); $i++)
                        <option value="{{ $route[$i]->id }}">{{ $route[$i]->Name }}</option>
                    @endfor
                @else
                    @for ($i = 0; $i < count($route); $i++)
                        <option value="{{ $route[$i]->id }}">{{ $route[$i]->Name }}</option>
                    @endfor
                @endif
                
            </select>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Rechercher</button>
    </form>
</div>
@endsection
