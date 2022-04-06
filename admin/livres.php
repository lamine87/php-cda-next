<?php 
session_start();
?>
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
                <?php 
                if(isset($_SESSION['message'])){
                    if(isset($_SESSION['message']['success'])){
                        echo '<div class="alert alert-success">'.$_SESSION['message']['success'].'</div>';
                    }
                    // Suppression du message
                    unset($_SESSION['message']['success']);
                }
                ?>
                <div class="d-flex justify-content-between align-items-center">
                    <h1> Les livres </h1>
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
                        <form action="../core/livreManager.php" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="action" value="add">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="titre">Titre</label>
                                <input type="text" name="titre" id="titre" class="form-controle">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="auteur">Auteur</label>
                                <input type="text" name="auteur" id="auteur" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="visuel">Visuel</label>
                                <input type="file" name="visuel" id="visuel" class="form-control">
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
				<table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // 1 Connexion
                        require_once('../core/connexion.php');
                        // 2 Ecriture de la requête
                        $sql = "SELECT * FROM livre";
                        // 3 Execution de la requête
                        $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
                        // 4 Traitement de données
                        if (mysqli_num_rows($req) == 0) {
                            echo '<tr> 
                                    <td colspan="5">Aucun livre</td>
                                </tr>';
                        } else {
                            // Avec une boucle while on fabrique les lignes html du tableau
                            while($livre = mysqli_fetch_array($req)) {
                                ?>
                            <tr>
                                <td><?php echo $livre['liv_id']; ?></td>
                                <td><img src="../images/<?php echo $livre['liv_visuel']; ?>" alt="<?php echo $livre['liv_visuel']; ?> " class="img-list"></td>
                                <td><?php echo $livre['liv_titre']; ?></td>
                                <td><?php echo $livre['liv_auteur']; ?></td>
                                <td class="text-end">
                                   
                                        <a href="../core/livreManager.php?action=delete&id=<?php echo $livre['liv_id']; ?>" class="btn btn-danger"><i class="align-middle" data-feather="trash"></i></a>
                                        <a href="./update-livre.php?id=<?php echo $livre['liv_id']; ?>" class="btn btn-primary ms-3"><i class="align-middle" data-feather="edit-2"></i></a>
                                
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
</body>
</html>