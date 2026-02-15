<?php
use carbon\carbon;
?>
@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Calcule de la Formule ")
@section("content")

@if (isset($result))
    <div class="container">
        <div class="fs-5"> Calcule du débit : {{ $type }} {{ $dimension }} </div>
        <table class="table table-striped  table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th scope="row">Débit actuel</th>
                    <th>Vistesse</th>
                    <th scope="row">Débit cible</th>
                    <th>Vistesse</th>
                </tr>
                </thead>
                <tbody>
                    <tr scope="row">
                        <td scope="row">Q : {{ $old_debit }}</td>
                        <td>{{ $ancien }} Nm³/s</td>
                        <td>----</td>
                        <td>----</td>
                    </tr>
                     <tr scope="row">
                        <td scope="row">----</td>
                        <td>----</td>
                        <td>Q : {{ $newDebit }}</td>
                        <td>{{ $result }} Nm³/s</td>
                    </tr>
                </tbody>
        </table>
        <a href="{{ route("reglage.ajuter")}}"><button type="button" class="btn btn-warning">Ajuster le débit</button></a>
        <a href="{{ route("reglage.formule", ["id" => $id+1]) }}"><button type="button" class="btn btn-primary">Puits Suivant</button></a>
        <a href="{{ route("note.reglage.create.id", ["id" => $note, "id2" => $id ]) }}"><button type="button" class="btn btn-success">Note</button></a>
    </div>
    
@endif


<div class="container mt-2">
    <div class="fs-5"> Réglages du: {{ $puit[0]->Name }} ({{ $puit[0]->type }} D.{{ $puit[0]->dimension }}) </div>
    <a href="{{ route("reglage.edit", ['id' => $id]) }}"><button class="btn btn-sm btn-secondary mt-2"> <i class="bi bi-pencil-square"></i> Modification {{ $puit[0]->Name }} </button></a>
    @if ($last != null)
      <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
          <i class="bi bi-eye"></i> La dernière valeur du puit enregistré 
      </button>
            
    @endif

    @if($note_info[0]->status == "active")
        <div class="alert alert-primary mt-2" role="alert">
            <i class="bi bi-info-circle"></i> {{ $note_info[0]->content }}
            @if($note_info[0]->preco_suez == 1)
            <div><i class="bi bi-check-square-fill text-success"></i> Préconisation Suez</div>
            @endif
            @if($note_info[0]->preco_suez == 0)
            <div><i class="bi bi-check-square-fill text-danger"></i> Préconisation Suez</div>
            @endif
        </div>
    @endif

    <form action="{{ route("reglage") }}" method="post" class="mt-2">
        @csrf
        <div class="mb-3">
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingInput" name="taux" value="{{ session("taux") ? session("taux") : "" }}" placeholder="Taux de conversion">
                <label for="floatingInput">Cible de réglages à effectuer</label>
            </div>
            <div class="form-floating mb-3 mt-2">
                <input type="number" class="form-control" id="floatingInput" step="0.01" name="ch4" placeholder="Valeur de CH4">
                <label for="floatingInput">Valeur de CH4 </label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingInput" step="0.01" name="ms" placeholder="Valeur de vitesse">
                <label for="floatingInput">Valeur de vitesse</label>
            </div>
        </div>

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="name" value="{{ $puit[0]->Name }}">
        <input type="hidden" name="type" value="{{ $puit[0]->type }}">
        <input type="hidden" name="dimension" value="{{ $puit[0]->dimension }}">

        <button type="submit" class="btn btn-primary"><i class="bi bi-calculator"></i> Calule</button>
        <a href="{{ route("note.reglage.create.id", ["id" => $note, "id2" => $id ]) }}"><button type="button" class="btn btn-success"><i class="bi bi-journal-text"></i> Note</button></a>      

    </form>


</div>

<!-- Modal -->
@if ($last != null)
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Date de la messure: {{ $last[0]->date }} </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-striped  table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th scope="row">CH4</th>
                        <th>CO2</th>
                        <th>O2</th>
                        <th>H2s</th>
                        <th>Dépression</th>
                        <th>Débit</th>
                        <th>Ratio</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr scope="row">
                            <td scope="row">{{ $last[0]->ch4 }}</td>
                            <td>{{ $last[0]->co2 }}</td>
                            <td>{{ $last[0]->o2 }}</td>
                            <td>{{ $last[0]->h2s }}</td>
                            <td>{{ $last[0]->dépression }}</td>
                            <td>{{ $last[0]->m3h }}</td>
                            <td>{{ $last[0]->ratio }}</td>
                        </tr>
                    </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endif

@endsection