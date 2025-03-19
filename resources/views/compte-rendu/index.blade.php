@extends("exention.header")
@extends("exention.navbar")
@section("content")

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-2">
            <h1>Compte Rendu Journalier.</h1>
            <a href="{{ route('compte-rendu.create') }}" class="btn btn-success my-3">Ajouter</a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Mode</th>
                        <th>Totalisateur (VB)</th>
                        <th>CH<sub>4</sub> </th>
                        <th>CO<sub>2</sub></th>
                        <th>O<sub>2</sub></th>
                        <th>Fonc Torch</th>
                        <th>Temp Flame</th>
                        <th>QB</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crj as $compteRendu)
                    <tr>
                        <td>{{ $compteRendu->slug }}</td>
                        <td>{{ $compteRendu->mode }}</td>
                        <td>{{ $compteRendu->VB }}</td>
                        <td>{{ $compteRendu->ch4 }}</td>
                        <td>{{ $compteRendu->co2 }}</td>
                        <td>{{ $compteRendu->o2 }}</td>
                        <td>{{ $compteRendu->torch }}</td>
                        <td>{{ $compteRendu->temperature }}</td>
                        <td>{{ $compteRendu->QB }}</td> 
                        <td>
                            <a href="#" class="btn btn-primary btn-sm">Modifier</a>
                            <a href="#" class="btn btn-info btn-sm">Détails</a>
                            <form action="#" method="post" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection