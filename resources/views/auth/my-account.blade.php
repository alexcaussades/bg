@extends("exention.header")
@extends("exention.navbar")
@section('title', "RegBio - Mon Compte")
@section("content")

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="fs-2"><i class="bi bi-person-fill-gear"></i> Mom Compte</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mt-5">
                <div class="card-header">
                    <div class="fs-4">Mes informations</div>
                </div>
                <div class="card-body">
                    <p class="card-text">Nom: {{ auth()->user()->name }}</p>
                    <p class="card-text">Email: {{ Str::mask(auth()->user()->email, '*', 10, -8) }}</p>
                    <p class="card-text">Role: {{ auth()->user()->roles }}</p>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    <div class="fs-4">Modifier le mot de passe ?</div>
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Ancien mot de passe</label>
                            <input type="password" class="form-control" id="old_password" name="old_password">
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary" disabled>Changer</button>
                    </form>
                    @if (session('error'))
                        <div class="alert alert-danger mt-2">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
</div>
@endsection