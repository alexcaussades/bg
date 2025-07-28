<?php 
use Carbon\Carbon;
?>

@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - MAJ Puits")
@section("content")

<div class="container">
    <table class="table table-striped table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Name</th>
                <th>Lignes</th>
                <th>Type</th>
                <th>Dimension</th>
                <th>Last Check</th>
                <th>Option</th>
                <th>Désactive</th>
            </tr>
            </thead>
            <tbody>
             
                @for($i = 0; $i < count($puits); $i++)
                    <tr>
                        <td>{{ $puits[$i]->Name }}</td>
                        <td>{{ $puits[$i]->lignes }}</td>
                        <td>{{ $puits[$i]->type}}</td>
                        <td>{{ $puits[$i]->dimension}}</td>
                        <td></td>
                        <td>
                            <a href="{{ route("puits.edit", $puits[$i]->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route("note.create.id", $puits[$i]->id) }}" class="btn btn-sm btn-success">Note</a>
                            
                        </td>
                        <td><a href="{{ route("puits.desactive", $puits[$i]->id) }}" class="btn btn-sm btn-danger">Désactive</a></td>
                    </tr>
                

                @endfor
            </tbody>
    </table>
</div>

@endsection