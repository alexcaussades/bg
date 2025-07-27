<?php 
use Carbon\Carbon;
?>
@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Historique des mesures libres")
@section("content")

<div class="container mt-2">
    <div class="fs-2">Historique des mesures</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Type de tuyaux</th>
                <th scope="col">Dimension</th>
                <th scope="col">M/S</th>
                <th scope="col">Débit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($session as $item)
            <tr>
                <td>{{ carbon::parse($item->created_at)->timezone("europe/paris")->format("d-m-Y H:i") }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->dimension }}</td>
                <td>{{ $item->ms }}</td>
                <td>{{ $item->debit }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

@endsection