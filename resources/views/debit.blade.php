@extends("exention.header")

@section("content")

<div class="container">
    <a href="{{ route('home') }}"><button class="btn btn-dark"> Home </button></a>
</div>

<div class="container mt-5">
    <div class="fs-2"> Débit m3/H </div>
    <form action="#" method="get">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Débit m/s</label>
                    <select class="form-control" name="type" id="">
                        <option selected value="SDR176">SDR17,6</option>
                        <option value="SDR26">SDR26</option>
                        <option value="SDR33">SDR33</option>
                        <option value="SDR1">SDR1</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="">Dimension</label>
                  <select class="form-control" name="dimension" id="">
                    <option value="90">90</option>
                    <option value="110">110</option>
                    <option value="160">160</option>
                    <option value="200">200</option>
                    <option value="250">250</option>
                    <option value="315">315</option>
                  </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ms">M/S </label>
                    <input type="text" class="form-control" id="ms" name="ms" placeholder="m/s sur la lecture de la sonde">  
                </div>
            </div>
        </div>
        <button class="btn btn-primary mt-2" type="submit">check</button>
    </form>
    
    @if (isset($result))
    <hr>
        <div class="mt-2">
            <div class="fs-2">Résultat</div>
            <div class="fs-4">Débit m3/H : {{ $result }}</div>
        </div>
        
    @else
        
    @endif


@endsection