@extends("exention.header")
@extends("exention.navbar")
@section("content")

<div class="container mt-5">

    <form action="{{ route("reglage.edit", ["id" => $id]) }}" method="post">
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
                    <option selected value="110">110</option>
                    <option value="160">160</option>
                </optgroup>
                <optgroup label="Grand diamètre">
                    <option value="200">200</option>
                    <option value="250">250</option>
                    <option value="315">315</option>
                </optgroup>
            </select>
        </div>
        <div class="form-group">
            <label for="">Famille du point de controlles</label>
            <select class="form-control" name="familles" id="">
                <option selected value="Puit Biogaz">Puit Biogaz</option>
                <option value="Puit Lixivitas">Puit Lixivitas</option>
                <option value="Prise échantillion">Prise échantillion</option>
                <option value="Tranché Drainante">Tranché Drainante</option>
                <option value="Ligne Principal">Ligne Principal</option>
                <option value="Collisseau">Collisseau</option>
                <option value="Purge">Purge</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Lignes</label>
            <select class="form-control" name="ligne" id="">
                <option value="Collecteur ALVR">Collecteur ALVR</option>
                <option value="Collecteur ALVL">Collecteur ALVL</option>
                <option value="ALVL0210">ALVL0210</option>
                <option value="ALVL0211">ALVL0211</option>
                <option value="ALVL0212">ALVL0212</option>
                <option value="ALVL0213">ALVL0213</option>
                <option value="ALVL0214">ALVL0214</option>
                <option value="ALVL0215">ALVL0215</option>
                <option value="ALVL0216">ALVL0216</option>
                <option value="ALVL0217">ALVL0217</option>
                <option value="ALVL0218">ALVL0218</option>
                <option value="ALVL0219">ALVL0219</option>
                <option value="ALVL0220">ALVL0220</option>
                <option value="ALVR0110">ALVR0110</option>
                <option value="ALVR0111">ALVR0111</option>
                <option value="ALVR0112">ALVR0112</option>
                <option value="ALVR0113">ALVR0113</option>
                <option value="ALVR0114">ALVR0114</option>
                <option value="ALVR0115">ALVR0115</option>
                <option value="ALVR0116">ALVR0116</option>
                <option value="ALVR0117">ALVR0117</option>
                <option value="ALVR0118">ALVR0118</option>
                <option value="ALVR0119">ALVR0119</option>
            </select>
        </div>
        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="name" value="{{ $puit[0]->Name }}">
        <button class="btn btn-primary mt-2" type="submit"><i class="bi bi-save"></i> Sauvegarder</button>
    </form>

@endsection


