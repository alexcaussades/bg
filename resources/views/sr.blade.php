@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="fs-2"><i class="bi bi-search"></i> Recherche</div>
            
            <table class="table table-striped table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>Name</th>
                        <th>Familles</th>
                        <th>Lignes</th>
                        <th>Type</th>
                        <th>Dimension</th>
                        <th>Option</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($puits as $puit)
                            <tr>
                                <td scope="row">{{ $puit->Name }}</td>
                                <td>{{ $puit->familles }}</td>
                                <td>{{ $puit->lignes }}</td>
                                <td>{{ $puit->type }}</td>
                                <td>{{ $puit->dimension }}</td>
                                <td>
                                    <a href="{{ Route('note.create', ['id' => $puit->id]) }}" class="btn btn-sm btn-dark">Ajouter Note</a>
                                    <a href="{{ Route('history.puit.id',["puit", 'name' => $puit->Name]) }}" class="btn btn-sm btn-primary">ID Carte</a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <hr>

    @foreach ( $note as $note)
        <div class="card mt-2">
            <div class="card-header">
                <div class="fs-4">{{ $note->title }}</div>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $note->content }}</p>
            </div>
        </div>
    @endforeach
</div>


@endsection