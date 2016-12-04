<div class="col-md-6">
    <div class="content-box">
        <div class="panel-heading">
            <div class="panel-title"><h2></h2></div>
            </br></br>
            <legend>Choisir une action</legend>
        </div>
            <form method="post" action="index.php?uc=admin&action=selectionnerCRUD">

                <p>
                    <label for="pays">Faites votre choix</label><br />
                    <select name="choixCRUD" id="CRUD">
                        <option value="create">Créer</option>
                        <option value="read">Voir</option>
                        <option value="update">Mettre à jour</option>
                        <option value="delete">Supprimer</option>
                    </select>
                </p>

                <div class="form-horizontal">
                    <input class="btn btn-primary" id="ok" type="submit" value="Valider" size="20"/>
                </div>

            </form>
         </div>
</div>