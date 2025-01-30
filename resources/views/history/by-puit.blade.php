<?php 
use Carbon\Carbon;
?>
@extends("exention.header")
@extends("exention.navbar")
@section("content")



<div class="container mt-5">

    <form action="{{ route('history.puit.id', ["puit"])}}" method="get">
        <div class="mb-3">
            <label for="puit" class="form-label">Sélectionnez un puit</label>
            <select class="form-select" name="name">
                @for ($i = 0; $i < count($session); $i++)
                    <option value="{{ $session[$i]->Name }}">{{ $session[$i]->Name }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>


</div>

@endsection