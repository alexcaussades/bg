@extends("exention.header")

@section("content")

<div class="container mt-5">

    <form action="{{ route("puits.update", ["id" => $puit[0]->id]) }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $puit[0]->Name }}">
        </div>
        <div class="form-group">
            <label for="">Type de tuyaux</label>
            <select class="form-control" name="type" id="">
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
            <select class="form-control" name="dimension" id="">
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
        
        <button class="btn btn-primary mt-2" type="submit"><i class="bi bi-save"></i> Sauvegarder</button>
    </form>

@endsection