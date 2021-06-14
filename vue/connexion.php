<?php
include_once("vue/layout/header.php")
?>


<body id="t">

  <!-- DEBUT SECTION -->
  <section id="connexion">
    <div>
      <h2>Connexion</h2>
      <form action="index.php" method="post">
        <div class="form-group">
          <label for="login">Identifiant :</label>
          <input type="text" class="form-control" id="login" name="login" placeholder="Saisir votre identifiant" required>
        </div>
        <div class="form-group">
          <label for="mdp">Mot de passe :</label>
          <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Saisir votre mot de passe" required>
        </div>
        <button type="submit" class="btn btn-connexion"><strong>Se connecter <i class="far fa-arrow-alt-circle-right fa-sm"></i></strong></button>
      </form>
      <?php
        if (isset($erreur)) {
          echo $erreur;
        }
      ?>
    </div>
  </section>

<!-- FIN FOOTER -->
<?php
include_once("vue/layout/footer.php")
?>
