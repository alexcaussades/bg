<?php 
use Carbon\Carbon;
?>

@extends("exention.header")

@section("content")

<div class="container">
    <table class="table table-striped table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Dimension</th>
                <th>Last Check</th>
                <th>Edit</th>
                <th>Note</th>
            </tr>
            </thead>
            <tbody>
             
                @for($i = 0; $i < count($puits); $i++)
                    <tr>
                        <td>{{ $puits[$i]->Name }}</td>
                        <td>{{ $puits[$i]->type}}</td>
                        <td>{{ $puits[$i]->dimension}}</td>
                        <td></td>
                        <td><a href="{{ route("puits.edit", $puits[$i]->id) }}" class="btn btn-primary">Edit</a></td>
                        <td><a href="{{ route("note.create.id", $puits[$i]->id) }}" class="btn btn-success">Note</a></td>
                    </tr>
                

                @endfor
            </tbody>
    </table>
</div>

@endsection