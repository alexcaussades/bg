
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
        <script>
            navigator.geolocation.getCurrentPosition(function(pos) {
                console.log(pos)
                var crd = pos.coords;
                var iframe = document.querySelector("iframe");
                iframe.src = `https://api.maptiler.com/maps/satellite/?key=kkpLQuTHyXEAqwhsuGBi#16.35/${crd.latitude}/${crd.longitude}`;

                
        });
        </script>
        <div class="container">
            <p id="latitude"></p>
            <p id="longitude"></p>
        </div>
        <iframe width="100%" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>

    </div>
</ul>
</div>


@endsection

