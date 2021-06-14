<?php

require_once ('modele/fonctions.php');
require_once ('controlleur/fonctions.php');
session_start();  // démarrage d'une session


// on vérifie que les variables de session identifiant l'utilisateur existent
if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
			$login_sesion = $_SESSION['login'];
			$id = $_SESSION['id'];
			$nom = $_SESSION['nom'];
			$prenom = $_SESSION['prenom'];
}



if(!isset($_GET["aller"])){
	$authOK = authentification();
	if (!empty($authOK)) {
      require_once("vue/accueil.php");
  }
  else {
     require_once("vue/connexion.php");
    }
}



else{

switch (isset($_GET["aller"])){

	case $_GET["aller"]=='Accueil' :
		require("vue/accueil.php");
		break;



	case $_GET["aller"]=='Consultation' :
		require ("vue/consultation.php");
		if(isset($_POST['moisConsult'])) {
			afficherformConsult($id);
		}
		break;


	case $_GET["aller"]=='FraisForfait' :
		require ("vue/fraisForfait.php");
		if (isset($_POST['libelleFraisForfait']) && isset($_POST['quantite'])) {
			$quantite = escape($_POST['quantite']);
			$libelleFraisForfait = escape($_POST['libelleFraisForfait']);
			fraisForfait($id, $libelleFraisForfait, $quantite);
		}
		break;



 	case $_GET["aller"]=='HorsForfait' :
		require ("vue/horsForfait.php");
		if (isset($_POST['date']) && isset($_POST['libelle']) && isset($_POST['prix'])) {
		  $libelle = escape($_POST['libelle']);
			$date = escape($_POST['date']);
		  $prix = escape($_POST['prix']);
			horsForfait($id, $libelle, $date, $prix);
		}
		break;



		case $_GET["aller"]=='Deconnection' :
			deco();
		break;

}
}




?>
