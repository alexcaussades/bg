<?php 
use Carbon\Carbon;
?>
@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>TTCR</h1>
            <p class="text-small">Taillis à très courte rotation</p>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Date & Heure: </th>
                        <th>Compteur: (M3)</th>
                        <th>Evolution: (M3) </th>
                        <th>Hauteur de Bâche: (cm)</th>
                        <th>Volume Restant: (M3)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ttcr as $ttcr)
                    <tr>
                        <td>{{ carbon::parse($ttcr->created_at)->timezone("europe/paris")->format("d-m-Y H:i") }}</td>
                        <td>{{ $ttcr->compteur }}</td>
                        <td>{{ $ttcr->evolution }}</td>
                        <td>{{ $ttcr->hauteur }}</td>
                        <td>{{ $ttcr->volume }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection