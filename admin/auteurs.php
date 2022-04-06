<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    if(file_exists('./inc/_head.php')) include './inc/_head.php';
    ?>
    <title>Dashboard</title>
</head>
<body>
<div class="wrapper">
    <?php 
    if(file_exists('./inc/_left-menu.php')) include './inc/_left-menu.php';
    ?>

		<div class="main">
        <?php 
        if(file_exists('./inc/_top-menu.php')) include './inc/_top-menu.php';
        ?>

			<main class="content">
                <div class="d-flex justify-content-between">
                    <h1>Les auteurs</h1>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Ajouter
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                         <!-- le enctype="multipart/form-data" sert a prendre en compte l'input de type file -->
                        <form action="../core/auteursManager.php" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="action" value="add">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" name="nom" id="nom" class="form-controle">
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prenom</label>
                                <input type="text" name="prenom" id="prenom" class="form-controle">
                            </div>
                            <div class="form-group">
                            <h4>Sexe</h4>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexe" id="masculin" value="masculin">
                                    <label class="form-check-label" for="masculin">
                                        Masculin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexe" id="feminin"  value="feminin" checked>
                                    <label class="form-check-label" for="feminin">
                                        Féminin
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <input type="file" name="photo" id="photo" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
                <table class="table mt-3">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Sexe</th>
                        <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        // 1 Connexion
                        require_once('../core/connexion.php');
                        // 2 Ecriture de la requête
                        $sql = "SELECT * FROM auteurs";
                        // 3 Execution de la requête
                        $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
                        // 4 Traitement de données
                        if (mysqli_num_rows($req) == 0) {
                            echo '<tr> 
                                    <td colspan="5">Aucun auteur</td>
                                </tr>';
                        } else {
                            // Avec une boucle while on fabrique les lignes html du tableau
                            while($auteur = mysqli_fetch_array($req)) {
                                ?>
                        <tr>
                        <th scope="row"><?php echo $auteur['aut_id']; ?></th>
                        <td><img src="../images/<?php echo $auteur['aut_photo']; ?>" alt="<?php echo $auteur['aut_photo']; ?>"></td>
                        <td><?php echo $auteur['aut_nom']; ?></td>
                        <td><?php echo $auteur['aut_pre']; ?></td>
                        <td><?php echo $auteur['aut_gender']; ?></td>
                        <td class="text-end">
                                   
                                        <a href="../core/auteursManager.php?action=delete&id=<?php echo $auteur['aut_id']; ?>" class="btn btn-danger"><i class="align-middle" data-feather="trash"></i></a>
                                        <a href="../core/auteursManager.php?action=update&id=<?php echo $auteur['aut_id']; ?>" class="btn btn-primary ms-3 btn-update" data-auteurid="<?php echo $auteur['aut_id']; ?>" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="align-middle" data-feather="edit-2"></i></a>
                                        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                         <!-- le enctype="multipart/form-data" sert a prendre en compte l'input de type file -->
                        <form action="../core/auteursManager.php" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="action1" value="<?php echo $auteur['aut_id']; ?>">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" name="nom" id="nom" class="form-controle" >
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prenom</label>
                                <input type="text" name="prenom" id="prenom" class="form-controle">
                            </div>
                            <div class="form-group">
                            <h4>Sexe</h4>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexe" id="masculin" value="masculin">
                                    <label class="form-check-label" for="masculin">
                                        Masculin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexe" id="feminin"  value="feminin" checked>
                                    <label class="form-check-label" for="feminin">
                                        Féminin
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <input type="file" name="photo" id="photo" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    </div>
                                </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    </table>	
			</main>

		<?php 
            if(file_exists('./inc/_footer.php')) include './inc/_footer.php';
        ?>
		</div>
	</div>


    <?php 
    if(file_exists('./inc/_js.php')) include './inc/_js.php';
    ?>
    <script> $('.btn-update').on('click', function(event) {
        var id = $(this).attr('.data-auteurid')
        $.ajax({
            url: '../core/auteursManager.php',
            type: 'POST',
            data: 'id ='+id+'&action=getAuteurInfo'
        })
        .done(function(response){
            console.log(response);
        })
        .fail(function(error){
            console.log(error);
        });
    })
    </script>
</body>
</html>
