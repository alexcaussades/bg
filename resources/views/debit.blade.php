@extends("exention.header")
@extends("exention.navbar")
@section("content")

<div class="container mt-5">
    <div class="fs-2">Mesurer un Flux  </div>
    <form action="#" method="get">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Type de tuyaux</label>
                    <select class="form-control" name="type" id="type">
                        <optgroup label="Courant">
                            <option selected value="SDR17">SDR17</option>
                            <option value="SDR26">SDR26</option>
                        </optgroup>
                        <optgroup label="Autre">
                            <option value="SDR11">SDR11</option>
                            <option value="SDR21">SDR21</option>
                            <option value="SDR33">SDR33</option>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group">
                  <label for="">Dimension</label>
                  <select class="form-control" name="dimension" id="dimension">
                    <optgroup label="Petit diamètre (disponible SDR11/17/33)">
                    <option value="32">32</option>
                    <option value="40">40</option>
                    <option value="63">63</option>
                    </optgroup>
                    <optgroup label="Diamètre standard">
                    <option value="90">90</option>
                    <option value="110">110</option>
                    <option selected value="160">160</option>
                    </optgroup>
                    <optgroup label="Grand diamètre">
                    <option value="200">200</option>
                    <option value="250">250</option>
                    <option value="315">315</option>
                    </optgroup>
                  </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ms">M/S </label>
                    <input type="number" step="0.01" class="form-control" id="ms" name="ms" placeholder="m/s sur la lecture de la sonde">  
                </div>
            </div>
        </div>
        <button class="btn btn-primary mt-2" type="submit"><i class="bi bi-calculator"></i> Calcule le débit</button>
    </form>
    <hr>
    <div class="row">
    @if (isset($result))
        <div class="col">
            <div class="alert alert-success" role="alert">
                <div class="fs-3"><i class="bi bi-info-circle-fill text-primary"></i> Résultat</div>
                <div class="fs-4">Débit m3/H : {{ $result }}</div>
            </div>
        </div>
    @endif
    </div>
@endsection
