<?php
require_once("modele/fonctions.php");
require_once("controlleur/fonctions.php");
?>

<header>
    <div class="container" id="entete">
      <div class="element"> <img id="logo" src="./img/logo.jpg" alt="logo"></a> </div>
      <div class="element"> <h1><strong>Galaxy Swiss Bourdin</h1> <br><h3>Application gérant les frais.</h3> </strong></div>
      <div class="element">
          <iframe name="date du jour" id="date-du-jour" style="width:105px;height:75px;" src="https://www.mathieuweb.fr/calendrier/date-jour-blanc.html" scrolling="no" frameborder="0" allowtransparency="true"></iframe>

      </div>
    </div>
</header>

<nav class="navbar navbar-expand navbar-dark bg-*">
  <div class="container">
    <a class="navbar-brand" href="#">Visiteur</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="index.php?aller=Accueil"><i class="fas fa-home fa-lg"></i> Accueil</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?aller=Consultation"><i class="fab fa-wpforms fa-lg"></i> Consultation frais</a></li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-archive fa-lg"></i> Ajout frais</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="index.php?aller=FraisForfait">Frais forfaitaire</a>
          <a class="dropdown-item" href="index.php?aller=HorsForfait">Hors forfait</a>
        </div>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="nav-item"><a class="nav-link" href="#"><?php echo $prenom . " " . $nom ?> <i class="far fa-user fa-lg"></i></a></li>
      <li class="nav-item"> <a class="nav-link" href="index.php?aller=Deconnection">Se déconnecter <i class="fas fa-sign-out-alt fa-lg"></i></a></li>
  </ul>
  </div>
</nav>

<body>
