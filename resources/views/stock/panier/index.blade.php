@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Panier")
@section("content")


<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">Sortie du Stock</h2>
            
            <form id="stockForm" method="POST" action="{{ route('stock.panier.verify') }}">
                @csrf
                <div id="linesContainer">
                    <div class="line-item mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Article</label>
                                <select class="form-control" name="items[0][id]" data-item-id required>
                                    <option value="">Sélectionner un article</option>
                                    @foreach($panier as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="col-md-4">
                                <label>Quantité</label>
                                <input type="number" class="form-control" name="items[0][quantity]" placeholder="Quantité" min="1" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" id="addLineBtn">Ajouter une ligne</button>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Confirmer la sortie</button>
                </div>
            </form>
            
            <script>
                let lineCount = 1;
                document.getElementById('addLineBtn').addEventListener('click', function() {
                    const container = document.getElementById('linesContainer');
                    const newLine = document.createElement('div');
                    newLine.className = 'line-item mb-3';
                    newLine.innerHTML = `
                        <div class="row">
                            <div class="col-md-4">
                                <label>Article</label>
                                <select class="form-control" name="items[${lineCount}][id]" required>
                                    <option value="">Sélectionner un article</option>
                                    @foreach($panier as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Quantité</label>
                                <input type="number" class="form-control" name="items[${lineCount}][quantity]" placeholder="Quantité" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm mt-4" onclick="this.parentElement.parentElement.parentElement.remove()">Supprimer</button>
                            </div>
                        </div>
                    `;
                    container.appendChild(newLine);
                    lineCount++;
                });
            </script>
        </div>
    </div>
</div>



@endsection