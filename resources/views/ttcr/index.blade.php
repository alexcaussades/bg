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
            <a href="{{ route('ttcr.create') }}" class="btn btn-primary mt-2 btn-sm">Nouveau Relevé</a>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Date & Heure: </th>
                        <th>Compteur: </th>
                        <th>Evolution: </th>
                        <th>Hauteur de Bâche:</th>
                        <th>Volume Restant:</th>
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