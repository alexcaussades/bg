@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Ajouter une catégorie")
@section("content")



<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Ajouter une catégorie</h1>
            <form action="{{ route('stock.articles.category.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Nom de la catégorie</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Ajouter</button>
                <button type="button" class="btn btn-danger mt-2" onclick="window.location.href='{{ route('stock.articles.index') }}'">Retour</button>
            </form>
        </div>
    </div>
@endsection