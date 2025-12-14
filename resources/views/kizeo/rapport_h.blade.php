@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Rapport Hebdomadaire")
@section("content")

<?php
use Carbon\Carbon;
?>

<div class="container mt-3">

<h3 class="mt-2">Rapport Hebdomadaire Biogaz, Torch et Vapo</h3>

<table class="table table-dark table-responsive mt-5">
    <thead class="thead-inverse">
        <tr>
            <th>Date</th>
            <th>CH4%</th>
            <th>CO2%</th>
            <th>O2%</th>
            <th>H Vapo</th>
            <th>H Torch</th>
            <th>Volume VB (m3)</th>
            <th>Totaliseur Vapo (m3)</th>
            <th>Qb (m3/h)</th>
            <th>Temp flammes (°C)</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">
                    @if ($data['torch'] == null)
                        @foreach($data['ttcr'] as $ttcr)
                            {{ Carbon::createFromFormat('d/m/Y H:i', $ttcr->Date_de_mesure)->format('d/m/Y') ?? "NC" }}<br>
                        @endforeach
                    @else
                        @foreach($data['torch'] as $torch)
                        <br>
                        @endforeach
                    @endif  
                </td>
                <td>
                    @foreach($data['biogaz'] as $biogaz)
                        {{ $biogaz->CHquatre ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['biogaz'] as $biogaz)
                        {{ $biogaz->COdeux ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['biogaz'] as $biogaz)
                        {{ $biogaz->Odeux ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['torch'] as $torch)
                        {{ $torch->ft_heure_Vapo ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['torch'] as $torch)
                        {{ $torch->ft_heure_Torch ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['torch'] as $torch)
                        {{ $torch->Volume_contine_VB ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['torch'] as $torch)
                        {{ $torch->Totalisateur_Vapo ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['torch'] as $torch)
                        {{ $torch->QbCH ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['torch'] as $torch)
                        {{ $torch->Temperature_Torch ?? "NC" }} °C<br>
                    @endforeach
                </td>
            </tr>
        </tbody>
</table>

<hr class="mt-2">

<h4>Rapport Hebdomadaire TTCR et Bassins</h4>

<table class="table table-striped table-dark table-inverse table-responsive mt-2">
    <thead class="thead-inverse">
        <tr>
            <th>Date</th>
            <th>B1 (Niveau)</th>
            <th>B2 (Niveau)</th>
            <th>B3 (%)</th>
            <th>Totaliseur TTCR (m3)</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">
                    @if ($data['ttcr'] == null)
                        @foreach($data['bassin'] as $bassin)
                            {{ Carbon::createFromFormat('d/m/Y H:i', $bassin->Date_de_mesure)->format('d/m/Y') ?? "NC" }}<br>
                        @endforeach
                    @else
                        @foreach($data['ttcr'] as $ttcr)
                            <br>
                        @endforeach
                    @endif
                </td>
                <td>
                    @foreach($data['bassin'] as $bassin)
                        {{ $bassin->Bassin_1 ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['bassin'] as $bassin)
                        {{ $bassin->Bassin_2 ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['bassin'] as $bassin)
                        {{ $bassin->Bassin_3 ?? "NC" }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach($data['ttcr'] as $ttcr)
                        {{ $ttcr->totalisseur_mc ?? "NC" }}<br>
                    @endforeach
                </td>
            </tr>
        </tbody>
</table>

@endsection