<!DOCTYPE html>
<html lang="en">
<head>
<?php 
    if(file_exists('./inc/_head.php')) include './inc/_head.php';
    ?>
    <title>Mise à jour d'un livre</title>
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
              
                    <h1> Modification livre </h1>
                    <?php 
                        require_once('../core/connexion.php');
                        $sql = 'SELECT * FROM livre WHERE liv_id = '.$_GET['id'] ;
                        $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
                        // On vérifie que l'on a bien une ligne d edonnées récupérée lors de l'execution de la requête
                        // sinon on envoit vers une page d'erreur
                        if(mysqli_num_rows($req) == 0) header('Location:erreur.php');
                        // On agence les données du livre sous forme de tableau associatif
                        $livre = mysqli_fetch_assoc($req);
                    ?>
                    <form action="../core/livreManager.php" method="post" enctype="multipart/form-data"> 
                        <input type="hidden" name="action" value="modify">
                        <input type="hidden" name="id" value="<?php echo $livre['liv_id']?>">
                        <input type="hidden" name="old_visuel" value="<?php echo $livre['liv_visuel']?>">
                            <div class="form-group">
                                <label for="titre">Titre</label>
                                <input type="text" name="titre" id="titre" class="form-controle" value="<?php echo $livre['liv_titre']?>">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?php echo $livre['liv_description']?>"</textarea>
                            </div>
                            <div class="form-group">
                                <label for="auteur">Auteur</label>
                                <input type="text" name="auteur" id="auteur" class="form-control" value="<?php echo $livre['liv_auteur']?>">
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-md-2">
                                    <!--Affichage de l'image-->
                                    <img src="../images/<?php echo $livre['liv_visuel']?>" alt="" class="img-fluid">

                                </div>
                                <div class="col-12 col-md-10">
                                <div class="form-group">
                                <label for="visuel">Visuel</label>
                                <input type="file" name="visuel" id="visuel" class="form-control">
                            </div>
                                </div>
                            </div> 

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                        </form>
        </main>
    </div>
</div>
</body>
</html>