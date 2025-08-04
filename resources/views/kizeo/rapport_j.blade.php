@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Rapport Journalier")
@section("content")


<div class="container mt-3">
<div class="container ">
    <a href="{{ route('kizeo.index') }}" class="btn btn-primary float-end pm-2">Retour aux formulaires</a>
</div>
<h3>Rapport Journalier via les données Kizeo du {{ $date }}</h3>


<hr>
<h4 class="mt-2">Bassin</h4>

<p>Réalisé par : {{ $data["bassin"][0]->Created_by ?? "NC" }}</p>


<div class="table table-responsive mt-2">
    <table class="table table-striped table-inverse">
        <thead class="thead-inverse">
            <tr>
                <th>Bassin 1</th>
                <th>Bassin 2</th>
                <th>Bassin 3</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $data["bassin"][0]->Bassin_1 ?? "NC"}}</td>
                <td>{{ $data["bassin"][0]->Bassin_2 ?? "NC"}}</td>
                <td>{{ $data["bassin"][0]->Bassin_3 ?? "NC"}} %</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-striped table-responsive mt-2">
        <thead>
            <tr>
                <th>Commentaire</th>
                <th>Commentaire</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                
                <td scope="row">{{ $data["bassin"][0]->Commentaire_bassin_1 ?? "RAS"}}</td>
                <td>{{ $data["bassin"][0]->Commentaire_bassin_2 ?? "RAS"}}</td>
                <td>{{ $data["bassin"][0]->Commentaire_bassin_3 ?? "RAS"}}</td>
            </tr>
        </tbody>
    </table>
</div>
<hr>
<h4 class="mt-2">Caisson Vapo & Torch & Biogaz</h4>
Réalisé par : {{ $data["torch"][0]->Created_by ?? "Autre" }}<br>

<table class="table table-striped table-responsive mt-2">
    <thead>
        <tr>
            <th>CH4 %</th>
            <th>CO2 %</th>
            <th>O2 %</th>
            <th>Dépression mb</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td scope="row">{{ $data["biogaz"][0]->CHquatre ?? "NC"}}</td>
            <td>{{ $data["biogaz"][0]->COdeux ?? "NC"}}</td>
            <td>{{ $data["biogaz"][0]->Odeux ?? "NC"}}</td>
            <td>{{ $data["biogaz"][0]->Depression ?? "NC"}}</td>
        </tr>
    </tbody>
</table>

<div class="table-responsive mt-2">
    <table class="table table-striped table-inverse">
        <thead class="thead-inverse">
            <tr>
                <th>Heure Torchère</th>
                <th>Heure Vapo</th>
                <th>Température Flame</th>
                <th>Totaliseur Vapo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $data["torch"][0]->ft_heure_Torch ?? "NC" }}</td>
                <td>{{ $data["torch"][0]->ft_heure_Vapo ?? "NC" }}</td>
                <td>{{ $data["torch"][0]->Temperature_Torch ?? "NC" }} °C</td>
                <td>{{ $data["torch"][0]->Totalisateur_Vapo ?? "NC" }} L</td>
            </tr>            
        </tbody>
    </table>

    <table class="table table-striped table-responsive mt-2">
        <thead>
            <tr>
                <th>Commentaire Caisson Vapo & Torche</th>  
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $data["torch"][0]->Commentaire_caisson_vapo ?? "RAS"}}</td>
            </tr>
        </tbody>
    </table>

<table class="table table-striped table-inverse table-responsive mt-2">
    <thead class="thead-inverse">
        <tr>
            <th>Volume Continue en VB</th>
            <th>QMES M3/h</th>
            <th>Qb%CH4 Nm3/h</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $data["torch"][0]->Volume_contine_VB ?? "NC" }}</td>
                <td>{{ $data["torch"][0]->Qmes ?? "NC" }}</td>
                <td>{{ $data["torch"][0]->QbCH ?? "NC" }}</td>
            </tr>
        </tbody>
</table>

<table class="table table-striped table-responsive mt-2">
    <thead class="thead-inverse">
        <tr>
                <th>Commentaire Fuji</th>           
        </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $data["torch"][0]->commentaire_fuji ?? "RAS" }}</td>
            </tr>
        </tbody>
</table>
<hr>
<h4 class="mt-2">TTCR</h4>
Réalisé par : {{ $data["ttcr"][0]->Created_by }}<br>
<table class="table table-striped table-responsive mt-2">
    <thead class="thead-inverse">
        <tr>
                <th>Consigne TTCR</th>           
        </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $data["ttcr"][0]->Consigne_TTCR ?? "Pas de nouvelle consigne" }}</td>
            </tr>
        </tbody>
</table>

<table class="table table-striped table-responsive mt-2">
    <thead>
        <tr>
            <th>Totalisseur TTCR mc3</th>
            <th>Niveau de remplissage de la bâche cm</th>
            <th>Volume restant dans la bâche mc3</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td scope="row">{{ $data["ttcr"][0]->totalisseur_mc ?? "NC" }}</td>
            <td>{{ $data["ttcr"][0]->niveau_remplissage ?? "NC" }}</td>
            <td>{{ $ttcr }}</td>
        </tr>
    </tbody>
</table>

@endsection