<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réglage Biogaz</title>
    <meta name="description" content="Réglage Biogaz pour votre installation">
    <meta name="author" content="Alexandre Caussades">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
    <div class="container mt-2">
      <h1><i class="bi bi-terminal-fill"></i> Réglage Biogaz</h1>
      <p>Bienvenue sur votre pages de réglage pour le biogaz</p>
    </div>
    <div class="container">
      <a href="{{ route('home') }}"><button class="btn btn-dark"><i class="bi bi-house-fill"></i> Home </button></a>
      <a href="{{ route("history") }}"><button class="btn btn-dark"><i class="bi bi-clipboard2-data"></i> Historique </button></a>
      <a href="{{ route("note") }}"><button class="btn btn-dark"><i class="bi bi-file-earmark-plus"></i> Note </button></a>
      <a href="{{ route("puits.show") }}"><button class="btn btn-dark"><i class="bi bi-geo-alt"></i> Puits </button></a>
      <a href="#"><button class="btn btn-dark" disabled><i class="bi bi-gear"></i> Paramètres </button></a>
  </div>
    @yield('navbar_ext')
    
    @yield('content')
  </body>



</html>