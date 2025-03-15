@extends("exention.header")
@extends("exention.navbar")
@section("content")

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-2">
            <h1>Création du Rapport</h1>
            <form action="#" method="POST">
                @csrf
                <div class="form-group">
                    <label for="date" class="mt-2">Date</label>
                    <input type="date" class="form-control mt-2" id="date" name="date" required>
                </div>
            </div>
                <hr>
                <div class="form-group">
                    <select class="form-select" aria-label="Default select example" name="configuration" required>
                        <option value="depol" selected>Dépollution</option>
                        <option value="valo">Valorisation</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="torch" class="mt-2">Heure de fonctionnement torchère</label>
                    <input type="number" class="form-control mt-2" id="torch" name="torch" min="5" required>
                </div>
                <div class="form-group">
                    <label for="torch2" class="mt-2">Température de la flame</label>
                    <input type="number" class="form-control mt-2" id="temperature" name="temperature" min="3" value="10" required>     
                </div>
                <div class="form-group">
                    <label for="QB" class="mt-2">QB % CH4</label>
                    <input type="number" class="form-control mt-2" id="QB" name="QB" required>
                </div>
                <div class="form-group">
                    <label for="QO" class="mt-2">Totalisation volume (Vb) Continue</label>
                    <input type="number" class="form-control mt-2" id="VB" name="VB" min="7" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-5"> Envoyer </button>
        </div>
    </div>
</div>

@endsection