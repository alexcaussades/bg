<?php 
use Carbon\Carbon;
?>
@extends("exention.header")

@section("content")

<div class="container mt-5">

<h3>Historique des mesures pour le puit : {{ $data[0]->puits_id }}</h3>
<table class="table table-striped table-inverse table-responsive">
    <thead class="thead-inverse">
        <tr>
            <th>Date</th>
            <th>CH4</th>
            <th>CO2</th>
            <th>O2</th>
            <th>BALANCE</th>
            <th>Dépression</th>
            <th>Température</th>
            <th>m3H</th>
        </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($data); $i++)
                <tr>
                    <td>{{ $data[$i]->date }}</td>
                    <td>{{ $data[$i]->ch4 }} <i class="bi bi-percent"></i></td>
                    <td>{{ $data[$i]->co2 }} <i class="bi bi-percent"></i></td>
                    <td>{{ $data[$i]->o2 }} <i class="bi bi-percent"></i></td>
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
                        @if ($data[$i]["m3/h"] > 0)
                        {{ $data[$i]["m3/h"] }} <i class="bi bi-hurricane"></i>
                        @endif
                    </td>
                </tr>
            @endfor
        </tbody>
</table>


</div>

@endsection