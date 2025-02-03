<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réglage Biogaz</title>
    <meta name="description" content="Réglage Biogaz pour votre installation">
    <meta name="author" content="Alexandre Caussades">

    @env('local')
      <link href="{{ asset("./css/bootstrap.min.css") }}" rel="stylesheet">
      <script src="{{ asset("./js/popper.min.js") }}"></script>
      <script src="{{ asset("./js/bootstrap.min.js") }}"></script>
    @endenv
    @env('production')
      <link href="{{ asset("public/css/bootstrap.min.css") }}" rel="stylesheet">
      <script src="{{ asset("public/js/popper.min.js") }}"></script>
      <script src="{{ asset("public/js/bootstrap.min.js") }}"></script>
    @endenv
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  </head>
 
    <div class="container mt-2">
      <h1><i class="bi bi-terminal-fill"></i> Réglage Biogaz</h1>
      <p>Bienvenue sur votre pages de réglage pour le biogaz</p>
    </div>
  </div>
  <body>
    
    @yield('content')
    
  </body>

  
  


</html>


