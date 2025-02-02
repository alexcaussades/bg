
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
        document.addEventListener("DOMContentLoaded", function() {
            navigator.geolocation.getCurrentPosition(function(pos) {
                var crd = pos.coords;
                var iframe = document.querySelector("iframe");
                iframe.src = `https://api.maptiler.com/maps/satellite/?key=kkpLQuTHyXEAqwhsuGBi#12.8/${crd.latitude}/${crd.longitude}`;
            }, function(err) {
                console.warn(`ERREUR (${err.code}): ${err.message}`);
            }, {
                timeout: 5000,
                maximumAge: 0,
            });
        });
        </script>

        <iframe width="100%" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>

    </div>
</ul>
</div>


@endsection

