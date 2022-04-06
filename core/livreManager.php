<?php 
// Démarrage de la session
session_start();

$action = "";
// On vérifie si on reçoit une variable en GET ou en POST
if(isset($_POST['action'])){
    $action = $_POST['action'];
} elseif(isset($_GET['action'])){
    $action = $_GET['action'];
}
// On gère la variable "action" reçue avec un switch
switch($action){
    case 'add':
        addBook($_POST, $_FILES);
        break;
    case 'modify':
        updateBook($_POST, $_FILES);
        break;
    case 'delete':
        deleteBook($_GET['id']);
        break;
    default:

}

/**
 * Fonction qui permet de mettre à jour notre bouquin dans notre BDD
 */
function updateBook($post, $files){
    require_once('connexion.php');
    // On vérifie si un fichier image est associé au formulaire
    $image = $post['old_visuel'];
    if(!empty($files['visuel']['tmp_name'])){
        //on supprime le visuel existant
        unlink('../images/'.$post['old_visuel']);
        // on prend en charge la nouvelle image
        $image = manageImage($files);
    }
    //Préparation des données (conversion des caractères sensibles en html ex: < en &lt;‡)
    $titre = htmlentities(htmlspecialchars($post['titre']));
    $description = htmlentities(htmlspecialchars($post['description']));
    $auteur = htmlentities(htmlspecialchars($post['auteur']));
    // Requête de mise à jour
    $sql = 'UPDATE livres 
            SET liv_titre = "'.$titre.'", liv_description = "'.$description.'", liv_auteur = "'.$auteur.'", liv_visuel = "'.$image.'"
            WHERE liv_id ='.$post['id'];

    echo $sql;
    
    mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    // Mise en place d'un message de confirmation
    $_SESSION['message']['success'] = 'Information du livre bien mises à jour';
    // Redirection
    header('Location:../admin/livres.php');
}

/** 
 * Fonction qui prend en charge le renommage et le déplacement d'un fichier joint au formulaire
 */
function manageImage($files) {
    $image = $files['visuel']['name']; // le nom du fichier sur la machine de l'utilisateur
    $ext = pathinfo($image, PATHINFO_EXTENSION); // extraction de l'extension du fichier uploadé
    $imageName = "image_".uniqid().".".$ext; // mise en place d'un nom unique de fichier
    move_uploaded_file($files['visuel']['tmp_name'], '../images/'.$imageName); // déplacement et renommage du fichier
    return $imageName;
}


/**
 * Fonction qui prend en charge la mise en BDD des données d'un livre et le transfert du fichier joint 
 *  du repertoire tmp du serveur vers le dossier du site
 */

function addBook($post, $files){
    require_once('../core/connexion.php');
    //Préparation des données (conversion des caractères sensibles en html ex: < en &lt;‡)
    $titre = htmlentities(htmlspecialchars($post['titre']));
    $description = htmlentities(htmlspecialchars($post['description']));
    $auteur = htmlentities(htmlspecialchars($post['auteur']));
    //
    $imageName = manageImage($files);
    // Ecritude de la requête
    $sql = 'INSERT INTO livre (liv_titre, liv_description, liv_auteur, liv_visuel) VALUES("'.$titre.'","'.$description.'","'.$auteur.'", "'.$imageName.'" )';
    // Execution de la requete
    mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    // Redirection
    header('Location:'.$_SERVER['HTTP_REFERER']);
}

/**
 * Fonction qui supprimer un livre et son image en BDD
 */
function deleteBook($id){
    require_once('../core/connexion.php');
    $sql = 'SELECT liv_visuel FROM livre WHERE liv_id = '.$id;
    $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    $image = mysqli_fetch_array($req);

    // Suppression de l'image
    unlink('../images/'.$image['liv_visuel']);
    //
    
    $sql = 'DELETE FROM livre WHERE liv_id = '.$id;
    $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    header('Location:'.$_SERVER['HTTP_REFERER']);
}



?>
