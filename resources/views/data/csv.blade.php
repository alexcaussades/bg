<h3>Importer</h3>

<p>Sélectionnez un fichier Excel (.xlsx) pour importer les données dans la table "clients".<br><strong>Les colonnes : </strong>name, email, phone, address</p>

<form method="POST" action="{{ route('import_data.import') }}" enctype="multipart/form-data" >

    <!-- CSRF Token -->
    @csrf

    <input type="file" name="fichier" >

    <button type="submit" >Importer</button>

</form>