<?php 
use Carbon\Carbon;
?>
@extends("exention.header")
@extends("exention.navbar")
@section("content")

<div class="container mt-5">

<h5><i class="bi bi-geo"></i> : {{ $info["familles"] }} {{ $data[0]->puits_id }} {{ $info["ligne"] }} </h5>

<div class="alert alert-info">
    <p>Moyenne des messures sur {{ count($data) }}.</p>
    <p>CH4: {{ $moyene["ch4"] }} | CO2: {{ $moyene["co2"] }} | O2: {{ $moyene["o2"] }} | H2S: {{ $moyene["h2s"] }} | DEP: {{ $moyene["depression"] }} | M3: {{ $moyene["m3"] }} </p>   
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="bi bi-cursor"></i> Gélocalisation
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Gélocalisation</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <script>
                navigator.geolocation.getCurrentPosition(function(pos) {
                    console.log(pos)
                    var crd = pos.coords;
                    document.getElementById("latitude").innerHTML = `Latitude: ${crd.latitude}`;
                    document.getElementById("longitude").innerHTML = `Longitude: ${crd.longitude}`;
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

<h5 class="mt-2">Historique <i class="bi bi-arrow-down-square-fill"></i></h5>
<table class="table table-striped table-inverse table-responsive">
    <thead class="thead-inverse">
        <tr>
            <th>Date</th>
            <th>CH4</th>
            <th>CO2</th>
            <th>O2</th>
            <th>BALANCE</th>
            <th>Dépression</th>
            <th>Température</th>
            <th>m3H</th>
        </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($data); $i++)
                <tr>
                    <td>{{ $data[$i]->date }}</td>
                    <td>{{ $data[$i]->ch4 }} <i class="bi bi-percent"></i></td>
                    <td>{{ $data[$i]->co2 }} <i class="bi bi-percent"></i></td>
                    <td>{{ $data[$i]->o2 }} <i class="bi bi-percent"></i></td>
                    <td>{{ $data[$i]->balance }} <i class="bi bi-percent"></i></td>
                    <td>
                        @if($data[$i]->dépression)
                            {{ $data[$i]->dépression }} <i class="bi bi-wind"></i>
                        @endif
                    </td>
                    <td>
                        @if($data[$i]->temperature)
                            {{ $data[$i]->temperature }} <i class="bi bi-thermometer"></i>
                        @endif
                    </td>
                    <td>
                        @if ($data[$i]["m3/h"] > 0)
                        {{ $data[$i]["m3/h"] }} <i class="bi bi-hurricane"></i>
                        @endif
                    </td>
                </tr>
            @endfor
        </tbody>
</table>


</div>

@endsection

