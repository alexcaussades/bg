@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Panier")
@section("content")

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">Sortie du Stock</h2>
            
            @if($panier && count($panier) > 0)
           
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Produit</th>
                                <th>En Stock</th>
                                <th>Quantité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($panier as $item)
                            
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span>{{ $item->title }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ $item->stock_actual }}</span>
                                    </td>
                                    <td>
                                        <div class="input-group" style="width: 150px;">
                                            <input type="number" class="form-control form-control-sm text-center" id="qty-{{ $item->id }}" value="0" min="0" onchange="setQuantite({{ $item->id }}, this.value)"> 
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-shopping-cart"></i> Votre panier est vide
                    <a href="#" class="alert-link">Continuer vos achats</a>
                </div>
            @endif
        </div>

        <!-- Résumé du panier -->
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h5 class="card-title">Sortie du Stock</h5>
                    <form method="POST" action="{{ route('stock.panier.verify') }}" id="formSortieStock">
                        @csrf
                        <button type="submit" class="btn btn-outline-success w-100">
                            Validé la Sortie du Stock
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection