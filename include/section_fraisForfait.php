<section>
  <div class="container" id="section">
    <h2>Ajout Frais Forfaitaire</h2>
    <form action="index.php?aller=FraisForfait" method="post" id="formFraisForf">
      <div class="form-group">
        <label for="libelleFraisForfait"> Choisissez votre type de frais forfaitaire : </label>
        <select class="form-control" id="libelleFraisForfait" name="libelleFraisForfait">
          <option value="ETP">Forfait étape</option>
          <option value="KM">Frais kilométriques</option>
          <option value="NUI">Nuitée(s) hôtel</option>
          <option value="REP">Repas restaurant</option>
        </select>
      </div>
      <div class="form-group">
        <label for="quantite">Quantité : </label>
        <input type="number" min="0" class="form-control" id="quantite" name="quantite" placeholder="Entrez la quantité désirée" required>
      </div>
      <button type="submit" class="btn btn-all">Valider <i class="fas fa-check-circle"></i></button>
      <button type="reset" class="btn btn-all">Annuler <i class="fas fa-ban"></i></button>
    </form>
    <?php if (isset($fraisForfait)) {
      $fraisForfait;
    } ?>
  </div>
</section>
