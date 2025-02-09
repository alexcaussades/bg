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
                <input type="password" class="form-control mt-2" id="password" name="password" minlength="8" maxlength="28" required placeholder="Entrez votre mot de passe">
                <div id="password-info" class="form-text">Pour que votre mot de passe soit valide, il doit respecter les règles suivantes
                  <ul>
                    <li id="caratere">Contenir entre 8 et 28 caractères.</li>
                    <li id="maj">Contenir au moins une lettre majuscule.</li>
                    <li id="min">Contenir au moins une lettre minuscule.</li>
                    <li id="chiffre">Contenir au moins un chiffre.</li>
                    <li id="spe">Contenir deux un caractère spécial.</li>
                  </ul>
                </div>
            </div>
            <div class="form-group mt-2">
                <label for="password_confirmation"><i class="bi bi-lock-fill"></i> Confirmer le mot de passe</label>
                <input type="password" class="form-control mt-2" id="password_confirmation" min="8" max="28" name="password_confirmation" required placeholder="Confirmer votre mot de passe">
            </div>
           <div class="form-check mt-2">
             <label class="form-check-label">
               <input type="checkbox" class="form-check-input" name="conditions" id="" value="CGU_OK" checked>
                J'accepte les termes et conditions d'utilisation <a href="{{ route("cgu") }}">CGU</a>
             </label>
           </div>
          <div class="form-check mt-2">
            <label class="form-check-label">
              <input type="checkbox" class="form-check-input" name="conditions" id="" value="données" checked>
                J'accepte que mes données soient utilisées conformément à la <a href="{{ route("cgu") }}">politique de confidentialité</a>
            </label>
          </div>
            <button type="submit" class="btn btn-primary mt-2" >S'inscrire</button>
        </form>
        </div>
    </div>
    <a href="{{ route('login') }}" class="btn btn-outline-primary mt-2 align-items-md-end">Déjà un compte ? Connectez-vous </a>
</div>

@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {
  const password = document.getElementById('password');
  const passwordConfirmation = document.getElementById('password_confirmation');
  const passwordInfo = document.getElementById('password-info');
  const form = password.closest('form');

  function validatePassword() {
    const value = password.value;
    const regexLower = /[a-z]{1}/;
    const regexUpper = /[A-Z]{1}/;
    const regexNumber = /[0-9]{1,2}/;
    const regexSpecial = /[\W]{1}/;

    let valid = true;

    if (!regexLower.test(value)) {
      document.getElementById('min').style.color = 'red';
      valid = false;
    } else {
      document.getElementById('min').style.color = 'green';
    }

    if (!regexUpper.test(value)) {
      document.getElementById('maj').style.color = 'red';
      valid = false;
    } else {
      document.getElementById('maj').style.color = 'green';
    }

    if (!regexNumber.test(value)) {
      document.getElementById('chiffre').style.color = 'red';
      valid = false;
    } else {
      document.getElementById('chiffre').style.color = 'green';
    }

    if (!regexSpecial.test(value)) {
      document.getElementById('spe').style.color = 'red';
      valid = false;
    } else {
      document.getElementById('spe').style.color = 'green';
      console.log(document.getElementById('spe').style.color);
    }

    return valid;
  }

  function validatePasswordMatch() {
    if (password.value !== passwordConfirmation.value) {
      passwordConfirmation.setCustomValidity("Les mots de passe ne correspondent pas");
    } else {
      passwordConfirmation.setCustomValidity("");
    }
  }

  password.addEventListener('input', validatePassword);
  passwordConfirmation.addEventListener('input', validatePasswordMatch);
  form.addEventListener('submit', function (event) {
    if (!validatePassword() || password.value !== passwordConfirmation.value) {
      event.preventDefault();
    }
  });
});
</script>