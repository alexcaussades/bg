
<?php 
use Carbon\Carbon;
?>

@extends("exention.header")
@extends("exention.navbar")
@section("content")
<div class="container mt-5">
<h3>
<ul>
    <div class="col-md-8">
        <form action="{{ route('test2') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="photo" accept="image/*">
            <button type="submit">Importer</button>
        </form>
    </div>
</ul>
</div>


@endsection

