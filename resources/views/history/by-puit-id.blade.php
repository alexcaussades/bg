<?php 
use Carbon\Carbon;
?>
@extends("exention.header")
@extends("exention.navbar")
@section("content")

<div class="container mt-5">

@if ($info["familles"] == null || $info["ligne"] == null || $info["type"] == null || $info["dimension"] == null) 
    <div class="alert alert-warning" role="alert">
        <strong>Mettre à jour les informations du <a href="{{ route("puits.edit", [$puit[0]->id ]) }}">point de contrôle</a> </strong>
    </div>
@endif


<h5><i class="bi bi-geo"></i> : {{ $info["familles"] }} {{ $data[0]->puits_id }} {{ $info["ligne"] }} </h5>

<div class="alert alert-info">
    <p>Moyenne des messures sur {{ count($data) }}.</p>
    <p>CH<sub>4</sub>: {{ $moyene["ch4"] }} | CO<sub>2</sub>: {{ $moyene["co2"] }} | O<sub>2</sub>: {{ $moyene["o2"] }} | H<sub>2</sub>S: {{ $moyene["h2s"] }} | DEP: {{ $moyene["depression"] }} | M3h: {{ $moyene["m3"] }} </p>   
</div>
<!-- Button trigger modal -->
<a href="{{ route("note.create.id", ["id" => $puit[0]->id]) }}"><button type="button" class="btn btn-sm btn-info"><i class="bi bi-journal-plus"></i> Crée une note</button></a>

<h5 class="mt-2">Historique <i class="bi bi-arrow-down-square-fill"></i></h5>
<table class="table table-striped table-inverse table-responsive">
    <thead class="thead-inverse">
        <tr>
            <th>Date</th>
            <th>CH<sub>4</sub></th>
            <th>CO<sub>2</sub></th>
            <th>O<sub>2</sub></th>
            <th>CO</th>
            <th>H<sub>2</sub></th>
            <th>H<sub>2</sub>S</th>
            <th>BALANCE</th>
            <th>Dépression</th>
            <th>Température</th>
            <th>m3H</th>
            <th>Ratio</th>
        </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($data); $i++)
                <tr>
                    <td>{{ $data[$i]->date }}</td>
                    <td>{{ $data[$i]->ch4 }} <i class="bi bi-percent"></i></td>
                    <td>{{ $data[$i]->co2 }} <i class="bi bi-percent"></i></td>
                    <td>{{ $data[$i]->o2 }} <i class="bi bi-percent"></i></td>
                    <td>{{ $data[$i]->co }}</td>
                    <td>{{ $data[$i]->h2 }}</td>
                    <td>{{ $data[$i]->h2s }}</td>
                    <td>{{ $data[$i]->balance }} <i class="bi bi-percent"></i></td>
                    <td>
                        @if($data[$i]->dépression)
                            {{ $data[$i]->dépression }} <i class="bi bi-wind"></i>
                        @endif
                    </td>
                    <td>
                        @if($data[$i]->temperature)
                            {{ $data[$i]->temperature }} <i class="bi bi-thermometer"></i>
                        @endif
                    </td>
                    <td>
                        @if ($data[$i]["m3h"] > 0)
                        {{ $data[$i]["m3h"] }} <i class="bi bi-hurricane"></i>
                        @endif
                    </td>
                    <td>
                        {{ $data[$i]["ratio"] }}
                    </td>
                </tr>
            @endfor
        </tbody>
</table>


</div>

@endsection

