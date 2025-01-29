<?php 
use Carbon\Carbon;
?>

@extends("exention.header")

@section("content")


<div class="container mt-5">
    <a href="#" class="btn btn-success">Crée une note</a>
</div>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Date de création</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notes as $note)
                    <tr>
                        <td>{{$note->title}}</td>
                        <td>{{$note->content}}</td>
                        <td>{{Carbon::parse($note->created_at)->diffForHumans()}}</td>
                        <td>
                            <a href="#" class="btn btn-primary">Modifier</a>
                            <a href="#" class="btn btn-danger">Supprimer</a>
                            <a href="#" class="btn btn-success">Archiver</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection