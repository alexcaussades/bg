<?php 
use Carbon\Carbon;
?>
@extends("exention.header")
@extends("exention.navbar")
@section("content")



<div class="container mt-5">

    <h3>Historique des mesures par puits</h3>
    
    
    <div class="mt-4" role="group">
        <a href="{{ url("/history/history-puit/puit?name=ALVBG100") }}" class="btn btn-sm btn-primary">BG 1000</a>
        <a href="{{ url("/history/history-puit/puit?name=ALVBG500") }}" class="btn btn-sm btn-outline-primary">BG 500</a>
        <a href="{{ url("/history/history-puit/puit?name=ALV0COL1") }}" class="btn btn-sm btn-secondary">ALV0COL 1</a>
        <a href="{{ url("/history/history-puit/puit?name=ALV0COL2") }}" class="btn btn-sm btn-outline-secondary">ALV0COL 2</a>
        
    </div>

    <form action="{{ route('history.puit.id', ["puit"])}}" method="get">
        <div class="mb-3 mt-2">
            <label for="puit" class="form-label">Sélectionnez un puits</label>
            <select class="form-select" name="name">
                @for ($i = 0; $i < count($session); $i++)
                    <option value="{{ $session[$i]->Name }}">{{ $session[$i]->Name }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Rechercher</button>
    </form>


</div>

@endsection