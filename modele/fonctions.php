<?php

/**
 * Nettoie une valeur insérée dans une page HTML
 * Doit être utilisée à chaque insertion de données dynamique dans une page HTML
 * Permet d'éviter les problèmes d'exécution de code indésirable (XSS)
 * @param string $valeur Valeur à nettoyer
 * @return string Valeur nettoyée
 */
function escape($valeur){
    // Convertit les caractères spéciaux en entités HTML
    return htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8', false);
}

/**
 * Gère la connexion à la base de données
 * @return PDO Objet de connexion à la BD
 */
function getBdd() {
    try{
    $host = "localhost";
    $dbname = "db_GSB";
    $login = "root";
    $password = "";
    return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
        $login, $password,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e){
      die('Erreur : '. $e->getMessage());
    }

}




function connexion($login, $mdp){
  $bdd = getBdd();
  // cette requête permet de récupérer l'utilisateur depuis la BD
  $requete = "SELECT * FROM Visiteur WHERE login=:login AND mdp=:mdp";
  $resultat = $bdd->prepare($requete);
  $resultat->execute(array(':login'=> $login, ':mdp' => $mdp));

  return $resultat;

}



function insertion_fraisForfait($id, $mois, $libelleFraisForfait, $quantite){

  $bdd= getBdd();


  $requete2 = $bdd->prepare("SELECT montant FROM fraisforfait WHERE fraisforfait.id = '$libelleFraisForfait'");

  // execution
  $requete2->execute();
  $row = $requete2->fetch(PDO::FETCH_BOTH); // ici, fetch() car UNE SEULE LIGNE récupérée (id est UNIQUE)

  echo 'montant : '.$row['montant'];

  $total = $row['montant'] * $quantite;
  echo 'montant2 : '.$total;



  $requete = "INSERT INTO `fichefrais`(idVisiteur, mois, nbJustificatifs, montantValide, dateModif, idEtat) VALUES (:idVisiteur, :mois, :nbJustificatifs, :montantValide, :dateModif, :idEtat) ON DUPLICATE KEY UPDATE montantValide = montantValide + :montantValide";

  $query = $bdd -> prepare($requete);
  $query -> execute(array(
    ':idVisiteur' => $id,
    ':mois' => $mois,
    ':nbJustificatifs' => 0,
    ':montantValide' => $total,
    ':dateModif' => date("Y-m-d"),
    ':idEtat' => 'CR'
  ));

  //var_dump($total);


  //Insert des frais forfaitaires dans la base
  $requete = "INSERT INTO `LigneFraisForfait`(idVisiteur, mois, idFraisForfait, quantite) VALUES (:idVisiteur, :mois, :idFraisForfait, :quantite) ON DUPLICATE KEY UPDATE quantite = quantite + :quantite";
  $query = $bdd -> prepare($requete);
  $query -> execute(array(
    ':idVisiteur' => $id,
    ':mois' => $mois,
    ':idFraisForfait' => $libelleFraisForfait,
    ':quantite' => $quantite
  ));

  $fraisForfait = 'Vos frais forfaitaires ont bien été pris en compte';
}




function insertion_horsForfait($id, $mois, $libelle, $date, $prix){

  $bdd = getBdd();



  $requete = "INSERT INTO `fichefrais`(idVisiteur, mois, nbJustificatifs, montantValide, dateModif, idEtat) VALUES (:idVisiteur, :mois, :nbJustificatifs, :montantValide, :dateModif, :idEtat) ON DUPLICATE KEY UPDATE montantValide = montantValide + :montantValide";
  $query = $bdd -> prepare($requete);
  $query -> execute(array(
    ':idVisiteur' => $id,
    ':mois' => $mois,
    ':nbJustificatifs' => 0,
    ':montantValide' => $prix,
    ':dateModif' => date("Y-m-d"),
    ':idEtat' => 'CL'
  ));



  $requete = "INSERT INTO `LigneFraisHorsForfait`(id, idVisiteur, mois, libelle, dateHF, montant) VALUES (NULL, :idVisiteur, :mois, :libelle, :dateHF, :montant)";
  //INSERT INTO `lignefraishorsforfait` (`id`, `idVisiteur`, `mois`, `libelle`, `dateHF`, `montant`) VALUES (NULL, 'a131', 'December', 'Fin du monde', '2019-12-09', '81')
  $query = $bdd -> prepare($requete);
  $query -> execute(array(
    ':idVisiteur' => $id,
    ':mois' => $mois,
    ':libelle' => $libelle,
    ':dateHF' => $date,
    ':montant' => $prix

  ));

}






















function afficherformConsult($id){
   // Requête pour afficher les frais forfaitaires et les frais hors forfait



      $moisConsultation = $_POST['moisConsult'];

      $bdd= getBdd();

      $queryFraisForfait = $bdd -> prepare('SELECT libelle, quantite, montant, idFraisForfait FROM LigneFraisForfait, FraisForfait WHERE LigneFraisForfait.idFraisForfait = FraisForfait.id AND mois = :mois AND idVisiteur = :id');
      $queryFraisForfait -> execute(array(':mois' => $moisConsultation, ':id' => $id));

      $queryFraisHorsForfait = $bdd -> prepare('SELECT dateHF, libelle, montant, id FROM LigneFraisHorsForfait WHERE mois = :mois AND idVisiteur = :id');
      $queryFraisHorsForfait -> execute(array(':mois' => $moisConsultation, ':id' => $id));



      $NbDonneesFraisForfait = $queryFraisForfait -> rowcount(); //Vérifie s'il y a des lignes dans la table LigneFraisForfait
      $rowAllFraisForfait = $queryFraisForfait -> fetchall(); //Récupère toutes les données de la table

      $NbDonneesFraisHorsForfait = $queryFraisHorsForfait -> rowcount(); //Vérifie s'il y a des lignes dans la table LigneFraisHorsForfait
      $rowAllFraisHorsForfait = $queryFraisHorsForfait -> fetchall(); //Récupère toutes les données de la table

      // affichage
      if ($NbDonneesFraisForfait != 0) //Affichage de l'entête s'il y a des lignes dans la table LigneFraisForfait
      {
      ?>
        <p>Frais forfaitaires du mois de : <?php if (isset($moisConsultation)) { echo $moisConsultation;} ?></p>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Libellé</th>
              <th scope="col">Quantité</th>
              <th scope="col">Prix total</th>
              <th scope="col">Opérations</th>
            </tr>
      <?php
      	// pour chaque ligne (chaque enregistrement)
      	foreach ( $rowAllFraisForfait as $rowFraisForfait )
      	{
      		// DONNEES de la table LigneFraisForfait
      ?>
          <form action="index.php?aller=Consultation" method="post">
        		<tr>

        			<td>
                <?php echo $rowFraisForfait['libelle']; ?>
                <input type="hidden" name="ModifIdFraisForfait" value="<?php echo $rowFraisForfait['idFraisForfait']; ?>">
              </td>

              <td> <input type="number" min="0" name="ModifQuantite" value="<?php echo $rowFraisForfait['quantite']; ?>"></td>
              <td> <input type="number" min="0" name="ModifQuantite" value="<?php echo $rowFraisForfait['quantite'] * $rowFraisForfait['montant']; ?>" disabled="disabled"> €</td>
              <td>
                <div class="text-center">
                  <button type="submit" class="btn btn-all"><i class="fas fa-edit"></i> Modifier</button>
                </div>
              </td>
        		</tr>
          </form>
      <?php
      	} // fin foreach
      ?>
          </thead>
        </table>
      <?php
      } else { ?>
      	<p>Pas de frais forfaitaires pour le mois en cours !</p>
      <?php
      }

      // affichage
      if ($NbDonneesFraisHorsForfait != 0) //Affichage de l'entête s'il y a des données dans la table LigneFraisHorsForfait
      {
      ?>
        <p>Frais hors forfait du mois de <?php if (isset($moisConsultation)) { echo $moisConsultation;} ?> : </p>
      	<table class="table table-bordered">
        	<thead>
        		<tr>
              <th scope="col">Date</th>
              <th scope="col">Description</th>
              <th scope="col">Prix</th>
              <th scope="col">Opérations</th>
        		</tr>
      <?php
      	// pour chaque ligne (chaque enregistrement)
      	foreach ( $rowAllFraisHorsForfait as $rowFraisHorsForfait )
      	{
          $id = $rowFraisHorsForfait['id'];
      		// DONNEES A AFFICHER de la table LigneFraisHorsForfait
      ?>
        <form action="index.php?aller=Consultation" method="post">
      		<tr>
      			<td> <input type="date" name="ModifDate" value="<?php echo $rowFraisHorsForfait['dateHF']; ?>"> </td>
      			<td> <input type="text" name="ModifDescription" value="<?php echo $rowFraisHorsForfait['libelle']; ?>"> </td>
            <td>
              <input type="number" min="0" name="ModifMontant" value="<?php echo $rowFraisHorsForfait['montant']; ?>">
              <input type="hidden" name="ModifIdFraisHorsForfait" value="<?php echo $rowFraisHorsForfait['id']; ?>">
            </td>
            <td>
              <div class="text-center">
                <button type="submit" class="btn btn-all"><i class="fas fa-edit"></i> Modifier</button>
                <?php echo '<a href="?id='. $id .'&supp=ok&aller=Consultation"><button type="button" class="btn btn-all"><i class="fas fa-trash-alt"></i> Supprimer</button></a>'; ?>
              </div>
            </td>
      		</tr>
        </form>
      <?php
      	} // fin foreach
      ?>
            </thead>
          </table>
      <?php
      }
      else { ?>
      	<p>Pas de frais hors forfait pour le mois en cours !</p>
      <?php
      }
      ?>
      </div>
      </section>

      <?php
      include_once("./vue/layout/footer.php");
}



?>
