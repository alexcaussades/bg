<?php 
use Carbon\Carbon;
?>

@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Notes des réglages")
@section("content")

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Puits</th>
                        <th>Informations</th>
                        <th class="impression">Date de création</th>
                        <th class="impression taille-small-hidden">Action</th>
                        <th class="impression taille-small-hidden">Fichier Suez</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notes as $note)
                    <tr>
                        @if ($note->preco_suez == 1)
                        <td class="text-bg-dark opacity-75">{{$note->title}}</td>
                        <td class="text-bg-dark opacity-75">{{$note->content}}</td>
                        <td class="impression text-bg-dark opacity-75">{{Carbon::parse($note->created_at)->tz("europe/paris")->format("d/m/y H:i")}}</td>
                        <td class="impression taille-small-hidden text-bg-dark opacity-75">
                            <a href="{{ route("note.archive", [$note->id]) }}" class="btn btn-sm btn-dark">Archiver</a>
                        </td>
                        <td class="impression taille-small-hidden text-bg-dark opacity-75">
                        </td>
                        @else
                        <td>{{$note->title}}</td>
                        <td>{{$note->content}}</td>                  
                        <td class="impression">{{Carbon::parse($note->created_at)->tz("europe/paris")->format("d/m/y H:i")}}</td>
                        <td class="impression taille-small-hidden">
                            <a href="{{ route("note.archive", [$note->id]) }}" class="btn btn-sm btn-dark">Archiver</a>
                        </td>
                        <td class="impression taille-small-hidden">
                            <a href="{{ route("note.preconisation", ["id" => $note->id]) }}" class="btn btn-sm btn-success">Préco</a>
                        </td>
                        @endif 
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection