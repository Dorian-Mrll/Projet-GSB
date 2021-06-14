<section>
  <div class="container" id="section">
    <h2>Ajout frais hors forfait</h2>
    <form action="index.php?aller=HorsForfait" method="post" id="formHorsForf">
      <div class="form-group">
        <label for="date">Date : </label>
        <input type="date" class="form-control" id="date" name="date" placeholder="Entrez une date" required>
      </div>
      <div class="form-group">
        <label for="libelle">Description : </label>
        <input type="text" class="form-control" id="libelle" name="libelle" placeholder="Entrez une brève description" required>
      </div>
      <div class="form-group">
        <label for="prix">Prix : </label>
        <input type="number" min="0" class="form-control" id="prix" name="prix" step="0.01" placeholder="Entrez un prix" required>
      </div>
      <button type="submit" class="btn btn-all"> Valider <i class="fas fa-check-circle"></i></button>
      <button type="reset" class="btn btn-all">Annuler <i class="fas fa-ban"></i></button>

    </form>
  </div>
</section>
