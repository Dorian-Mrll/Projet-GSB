<?php

    if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
        $login = $_SESSION['login'];
        $mdp = $_SESSION['mdp'];
        $id = $_SESSION['id'];
        $nom = $_SESSION['nom'];
        $prenom = $_SESSION['prenom'];

        include_once("./vue/layout/header.php");

        if (isset($login) && isset($mdp)) {
          require('./vue/nav_after.php');
          require("./include/section_accueil.php");
        }
        else {
          require_once ("./vue/nav_before.php");
        }

        include_once("./vue/layout/footer.php");
    }
    else{
      header('Location: index.php');
    }

?>
