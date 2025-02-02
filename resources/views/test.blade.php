
<?php 
use Carbon\Carbon;
?>

@extends("exention.header")
@extends("exention.navbar")
@section("content")

<script>
console.log("hello")
var options = {
  //enableHighAccuracy: true,
  timeout: 5000,
  maximumAge: 0,
};

function success(pos) {
  var crd = pos.coords;

  console.log("Votre position actuelle est :");
  console.log(`Latitude : ${crd.latitude}`);
  console.log(`Longitude : ${crd.longitude}`);
  console.log(`La précision est de ${crd.accuracy} mètres.`);
}

function error(err) {
  console.warn(`ERREUR (${err.code}): ${err.message}`);
}

navigator.geolocation.getCurrentPosition(success, error, options);


</script>
<div class="container mt-5">
<h3>
<ul>
    
</ul>
</div>


@endsection

