@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container mt-3">

<h3>Rapport Journalier via les données Kizeo du {{ $date }}</h3>


<hr>
<h4 class="mt-2">Bassin</h4>

Réalisé par : {{ $data["bassin"][0]->Created_by }}<br>
<div class="table-responsive">
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
                <td scope="row">{{ $data["bassin"][0]->Bassin_1 }}</td>
                <td>{{ $data["bassin"][0]->Bassin_2 }}</td>
                <td>{{ $data["bassin"][0]->Bassin_3 }} %</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Commentaire</th>
                <th>Commentaire</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                
                <td scope="row">{{ $data["bassin"][0]->Commentaire_bassin_1 }}</td>
                <td>{{ $data["bassin"][0]->Commentaire_bassin_2 }}</td>
                <td>{{ $data["bassin"][0]->Commentaire_bassin_3 }}</td>
            </tr>
        </tbody>
    </table>
</div>
<hr>
<h4 class="mt-2">Caisson Vapo & Torch</h4>
Réalisé par : {{ $data["torch"][0]->Created_by }}<br>
<div class="table-responsive">
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
                <td scope="row">{{ $data["torch"][0]->ft_heure_Torch }}</td>
                <td>{{ $data["torch"][0]->ft_heure_Vapo }}</td>
                <td>{{ $data["torch"][0]->Temperature_Torch }} °C</td>
                <td>{{ $data["torch"][0]->Totalisateur_Vapo }} L</td>
            </tr>            
        </tbody>
    </table>

    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Commentaire Caisson Vapo & Torche</th>  
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $data["torch"][0]->Commentaire_caisson_vapo }}</td>
            </tr>
        </tbody>
    </table>

<table class="table table-striped table-inverse table-responsive">
    <thead class="thead-inverse">
        <tr>
            <th>Volume Continue en VB</th>
            <th>QMES M3/h</th>
            <th>Qb%CH4 Nm3/h</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $data["torch"][0]->Volume_contine_VB }}</td>
                <td>{{ $data["torch"][0]->Qmes }}</td>
                <td>{{ $data["torch"][0]->QbCH }}</td>
            </tr>
        </tbody>
</table>

<table class="table table-responsive">
    <thead class="thead-inverse">
        <tr>
                <th>Commentaire Fuji</th>           
        </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $data["torch"][0]->commentaire_fuji }}</td>
            </tr>
        </tbody>
</table>

<h4 class="mt-2">TTCR</h4>
Réalisé par : {{ $data["ttcr"][0]->Created_by }}<br>



@endsection