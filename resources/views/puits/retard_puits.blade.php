
<?php 
use Carbon\Carbon;
?>

@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container mt-5">
<h3>{{ count($retard) }} à faires :</h3>
<ul>
    @foreach($retard as $puits)
        <li>{{ $puits->Name }} - {{ $puits->lignes }}</li>
    @endforeach
</ul>
</div>


@endsection