<?php
  
    // On gère la variable "action" reçu avec un switch

switch ($_POST["action"]){
    case 'add':
        addBook($_POST, $_FILES);
        break;
        default:
}
 

function addBook($post, $files) {
    require_once("connexion.php");
    
    $titre = htmlentities(htmlspecialchars($post["titre"]));
    $description = htmlentities(htmlspecialchars($post["description"]));
    $auteur = htmlentities(htmlspecialchars($post["auteur"]));

    $images = $files["visuel"]["name"]; // Le nom du fichier sur la machine utilisateur
    $ext = pathinfo($images, PATHINFO_EXTENSION); // extraction de l'extention du fichier uploadé
    $imageName = "image_".uniqid().".".$ext;  // Mise en place d'un nom unique de fichier
    move_uploaded_file($files["visuel"]["tmp_name"],"../images/".$imageName); // Deplacement et renommage du fichier

    $sql = 'INSERT INTO livre (liv_titre, liv_description, liv_auteur, liv_visuel) VALUES ("'.$titre.'","'.$description.'","'.$auteur.'","'.$imageName.'")';
    mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    header("Location:".$_SERVER["HTTP_REFERER"]);
}
?>