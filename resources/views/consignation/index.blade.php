@extends("exention.header")
@extends("exention.navbar")
@section("content")

<form action="#" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control mt-2">
                        <option value="Consignation">Consignation</option>
                        <option selected value="Maintenance">Maintenance</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <div class="form-group">
                    <label for="Équipements">Équipements</label>
                    <select name="Équipements" id="puits" class="form-control mt-2">
                        <option value="torchère">Torchère</option>
                        <option value="filltration">Filltration</option>
                        <option value="bioreacteur">Bioreacteur</option>
                        <option value="soudure">Soudure</option>
                        <option value="pompe">Pompe</option>
                        <option value="puits">Puits</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mt-2">
               <textarea name="info" class="form-control" id="" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group mt-2">
                <input type="file" name="photo" class="form-control-file" id="exampleFormControlFile1">
              </div>
            <div class="col-md-12 mt-2">
                <button class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</form>

@endsection