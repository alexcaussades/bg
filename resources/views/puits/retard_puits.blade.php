
<?php 
use Carbon\Carbon;
?>

@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container mt-5">
<h3>Listes à faires : </h3>
<ul>
    @foreach($retard as $puits)
        <li>{{ $puits->Name }}</li>
    @endforeach
</ul>
</div>


@endsection