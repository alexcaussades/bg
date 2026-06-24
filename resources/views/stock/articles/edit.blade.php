@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Modifier un article")
@section("content")



<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modifier un article</h1>
            <form action="{{ route('stock.articles.update', $article->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="code">Code de l'article</label>
                    <input type="text" class="form-control" id="reference" name="reference" value="{{ $article->reference }}" required>
                </div>
                <div class="form-group">
                    <label for="title">Nom de l'article</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}" required>
                </div>
                <div class="form-group">
                    <label for="category">Catégorie</label>
                    <select class="form-control" id="category" name="category" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $article->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="stock_actual">Stock actuel</label>
                    <input type="number" class="form-control" id="stock_actual" name="stock_actual" value="{{ $article->stock_actual }}" required>
                </div>
                <div class="form-group">
                    <label for="stock_minimum">Stock minimum</label>
                    <input type="number" class="form-control" id="stock_minimum" name="stock_minimum" value="{{ $article->stock_minimum }}" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Modifier</button>
                <button type="button" class="btn btn-danger mt-2" onclick="window.location.href='{{ route('stock.articles.index') }}'">Retour</button>
                <button type="button" class="btn btn-success mt-2" onclick="window.location.href='{{ route('stock.articles.category') }}'">Ajouter une catégorie</button>
            </form>
        </div>
    </div>
@endsection