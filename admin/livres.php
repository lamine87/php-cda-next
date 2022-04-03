<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    if (file_exists('./inc/_head.php')) include './inc/_head.php';
    ?>
    <title>Document</title>
</head>

<body>
    <!--  -->
    <div class="wrapper">
        <?php
        if (file_exists('./inc/_left-menu.php')) include './inc/_left-menu.php';
        ?>
        <div class="main">
            <?php
            if (file_exists('./inc/_top-menu.php')) include './inc/_top-menu.php';
            ?>
            <main class="content">
                <div class="d-flex justify-content-between align-item-center">
                    <h1>Les Livres</h1>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                                <form action="../core/livreManager.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="add">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="titre">Titre</label>
                                            <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" class="form-control" cols="30" rows="10" placeholder="Description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="auteur">Auteur</label>
                                            <input type="auteur" name="auteur" id="auteur" class="form-control" placeholder="Auteur">
                                        </div>
                                        <div class="form-group">
                                            <label for="visuel">Visuel</label>
                                            <input type="file" name="visuel" id="visuel" class="form-control" placeholder="Visuel">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover responsive">
                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Image</td>
                            <td>Titre</td>
                            <td>Description</td>
                            <td>Auteur</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 1 connexion  -->
                        <?php
                        require_once("../core/connexion.php");
                        // 2 Ecriture de la requete
                        $sql = "SELECT * FROM livre";
                        // 3 Execution de la requete
                        $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
                        // 4 Traitement des donnees
                        if (mysqli_num_rows($req) == 0) {
                            echo '<tr><td colspan="5">Aucun livre</tr></td>';
                        } else {
                            //   Avec une boucle while on fabrique les lignes html du tabkeau
                            while ($livre = mysqli_fetch_array($req)) {
                        ?>
                                <tr>
                                    <td> <?php echo $livre["liv_id"]; ?> </td>
                                    <td><img src="../images/<?php echo $livre["liv_visuel"]; ?>" alt="" class="img-list"></td>
                                    <td> <?php echo $livre["liv_titre"]; ?> </td>
                                    <td> <?php echo $livre["liv_description"]; ?> </td>
                                    <td> <?php echo $livre["liv_auteur"]; ?> </td>
                                    <td class="d-inline-block">
                                        <a href="../core/livreManager.php?action=delete&id=<?php echo $livre["liv_id"] ?>" class="btn btn-danger">
                                            <i class="align-middle" data-feather="trash"></i>
                                        </a>
                                        <a href="../core/livreManager.php?action=update&id=<?php echo $livre["liv_id"] ?>" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary ms-3">
                                            <i class="align-middle " data-feather="edit-2"></i>
                                        </a>
                                 
                                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="../core/livreManager.php" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="action" value="edit">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="titre">Titre</label>
                                                                <input type="text" name="titre" id="titre" class="form-control" value="<?php echo $livre["liv_titre"]; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">Description</label>
                                                                <textarea name="description" id="description" class="form-control" cols="30" rows="10"><?php echo $livre["liv_description"]; ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="auteur">Auteur</label>
                                                                <input type="auteur" name="auteur" id="auteur" class="form-control" value="<?php echo $livre["liv_auteur"]; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="visuel">Visuel</label>
                                                                <input type="file" name="visuel" id="visuel" class="form-control">
                                                                <img src="../images/<?php echo $livre["liv_visuel"]; ?>" alt="" width="50px">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                                        </div>
                                                    </form>
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
            if (file_exists('./inc/_footer.php')) include './inc/_footer.php';
            ?>
        </div>
    </div>
    <!--  -->
    <?php
    if (file_exists('./inc/_js.php')) include './inc/_js.php';
    ?>
</body>

</html>