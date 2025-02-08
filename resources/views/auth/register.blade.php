@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container mt-5">
    <div class="card text-dark">
      <div class="card-body">
        <h4 class="card-title">Je m'enregistre </h4>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name"> <i class="bi bi-person-circle"></i> Nom </label>
                <input type="text" class="form-control mt-2" id="name" name="name" required value="{{ old('name') }}" autofocus placeholder="Entrez votre nom">
            </div>
            <div class="form-group mt-2">
                <label for="email"> <i class="bi bi-envelope-fill"></i> Email </label>
                <input type="email" class="form-control mt-2" id="email" name="email" required value="{{ old('email') }}" autofocus placeholder="Entrez votre email">
            </div>
            <div class="form-group mt-2">
                <label for="password"><i class="bi bi-lock-fill"></i> Mot de passe</label>
                <input type="password" class="form-control mt-2" id="password" name="password" required placeholder="Entrez votre mot de passe">
            </div>
            <div class="form-group mt-2">
                <label for="password_confirmation"><i class="bi bi-lock-fill"></i> Confirmer le mot de passe</label>
                <input type="password" class="form-control mt-2" id="password_confirmation" name="password_confirmation" required placeholder="Confirmer votre mot de passe">
            </div>
           <div class="form-check mt-2">
             <label class="form-check-label">
               <input type="checkbox" class="form-check-input" name="conditions" id="" value="checkedValue" checked>
                J'accepte les termes et conditions d'utilisation <a href="#">CGU</a>
             </label>
           </div>
            <button type="submit" class="btn btn-primary mt-2">S'inscrire</button>
        </form>
        </div>
    </div>
    <a href="{{ route('login') }}" class="btn btn-outline-primary mt-2 align-items-md-end">Déjà un compte ? Connectez-vous </a>
</div>

@endsection