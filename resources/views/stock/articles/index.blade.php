@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Articles")
@section("content")


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Articles</h1>
            <form action="{{ route('stock.articles.index') }}" method="GET" class="form-inline mb-3">
                <div class="form-group mr-2">
                    <input type="text" class="form-control" name="search" placeholder="Rechercher un article..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
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
                                <a href="#" class="btn btn-sm btn-primary">Modifier</a>
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
