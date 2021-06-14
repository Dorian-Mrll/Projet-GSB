<?php

    if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
        $login = $_SESSION['login'];
        $mdp = $_SESSION['mdp'];
        $id = $_SESSION['id'];
        $nom = $_SESSION['nom'];
        $prenom = $_SESSION['prenom'];

        include_once("./vue/layout/header.php");

        if (isset($login) && isset($mdp)) {
          require_once ('./vue/nav_after.php');
          require_once ('./include/section_consultation.php');
        }
        else {
          require_once ("./vue/nav_before.php");
        }
    }
    else{
      header('Location: index.php');
    }

?>
