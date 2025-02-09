@extends("exention.header")
@extends("exention.navbar")
@section("content")



<div class="container mt-5">
    <div class="card text-dark">
      <div class="card-body">
        <h4 class="card-title">Bienvenue sur votre espace ! </h4>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email"> <i class="bi bi-person-circle"></i> Identifiant </label>
                <input type="email" class="form-control mt-2" id="email" name="email" required value="{{ old('email') }}" autofocus placeholder="Entrez votre identifiant">
            </div>
            <div class="form-group mt-2">
                <label for="password"><i class="bi bi-lock-fill"></i> Mot de passe</label>
                <input type="password" class="form-control mt-2" id="password" name="password" required placeholder="Entrez votre mot de passe">
            </div>
            <div>
                <a href="#">Problèmes de connexion ?</a>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Login</button>
        </form>
        </div>
    </div> 
    <a href="#" class="btn btn-outline-primary mt-2 disabled align-items-md-end">Pas de compte ? Inscrivez-vous </a>
</div>

@endsection