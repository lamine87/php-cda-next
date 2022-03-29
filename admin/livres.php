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
                    <a href="" class="btn btn-info">Ajouter</a>
                </div>
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Action</th>
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
                          if(mysqli_num_rows($req)==0){
                              echo '<tr><td colspan="5">Aucun livre</tr></td>';
                          }else{
                            //   Avec une boucle while on fabrique les lignes html du tabkeau
                            while($livre = mysqli_fetch_array($req)){
                                ?>
                                <tr>
                                <th> <?php echo $livre["liv_id"]; ?> </th>
                                <th> <?php echo $livre["liv_visuel"]; ?> </th>
                                <th> <?php echo $livre["liv_titre"]; ?> </th>
                                <th> <?php echo $livre["liv_auteur"]; ?> </th>
                                <th> <?php echo $livre["liv_description"]; ?> </th>
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