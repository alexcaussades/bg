<?php 
use Carbon\Carbon;
?>

@extends("exention.header")
@extends("exention.navbar")
@section("content")

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('consignation.show') }}" class="btn btn-primary">Retour</a>
        </div>
    </div>
</div>

<div class="container mt-2">
    <div class="row">
        <div class="col-8">
        <div class="card text-dark bg-light  mb-3">
            @if ($consignation->photo != null)
                @if (ENV('APP_ENV') == 'local')
                    <img class="card-img-top" src="{{ $img }}" alt="">
                @endif
                @production
                <img class="card-img-top" src="{{ asset('storage/app/public/images/'.$consignation->photo) }}" alt="">
                @endproduction
            @endif
            <div class="card-body">
            <h4 class="card-title">Équipements: {{ $consignation->Équipements }}</h4>
            <p class="card-text">
                <div class="col">Type: {{ $consignation->type }}
                <div class="col mt-2">info: {{ $consignation->info }}
            @if ($consignation->photo != null)
                <div class="col mt-4"><a href="{{ $donwload }}"><button type="submit" class="btn btn-outline-success">Télécharger la photo</button></a>
            @endif
                </div>
                </p>
            </div>
            <div class="card-footer mt-2">
                <small class="text-muted mt-2">Date: {{ Carbon::parse($consignation->created_at)->tz("europe/paris")->format("d/m/Y H:i:s") }}</small>
            </div>
        </div>
        </div>
</div>

@endsection