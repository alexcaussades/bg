@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Articles")
@section("content")


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Articles</h1>
            <button class="btn btn-primary mb-3" onclick="window.location.href='{{ route('stock.articles.create') }}'">Ajouter un article</button>
            {{-- <button class="btn btn-secondary mb-3" onclick="window.location.href='#'">Exporter les articles</button>
            <button class="btn btn-secondary mb-3" onclick="window.location.href='#'">Importer les articles</button> --}}
            <form action="{{ route('stock.articles.search') }}" method="GET" class="mb-3 mt-2">
                <div class="input-group">
                    <input type="text" name="query" class="form-control" placeholder="Rechercher un article par référence ou nom" value="{{ request('query') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Nom</th>
                        <th>Stock Site</th>
                        <th>Stock Minimum</th>
                        <th>Dernière mise à jour</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->reference }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->stock_actual }}</td>
                            <td>{{ $article->stock_minimum }}</td>
                            <td>{{ $article->updated_at ? \Carbon\Carbon::parse($article->updated_at)->timezone("Europe/Paris")->format('d/m/Y') : '' }}</td>
                            <td>
                                <a href="{{ route('stock.articles.edit', $article->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                                <form action="#" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</button>
                                </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
