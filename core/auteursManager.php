<?php 

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
        addAuteur($_POST, $_FILES);
        break;
    case 'update':
        updateAuteur($_FILES);
        break;
    case 'delete':
        deleteAuteur($_GET['id']);
        break;
    case 'getAuteurInfo':
        getAuteurInfo($_POST['id']);
        break;
    default:

}

function getAuteurInfo($id) {
    require_once('../core/connexion.php');
    $sql = 'SELECT * FROM auteurs WHERE aut_id = '.$id;
    $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    $auteur = mysqli_fetch_assoc($req);
    echo json_encode($auteur);
}

function updateAuteur ($files) {
    require_once('../core/connexion.php');
    $sql = 'SELECT aut_photo FROM auteurs WHERE aut_id = '.$_POST['action1'];
    $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    $image = mysqli_fetch_array($req);

    // Suppression de l'image
    unlink('../images/'.$image);
    
    //Préparation des données (conversion des caractères sensibles en html ex: < en &lt;‡)
    $nom = htmlentities(htmlspecialchars($_POST['nom']));
    $prenom = htmlentities(htmlspecialchars($_POST['prenom']));
    $sexe = htmlentities(htmlspecialchars($_POST['sexe']));

    // prise en compte du fichier photo
    $photo = $files['photo']['name']; // le nom du fichier sur la machine de l'utilisateur
    $ext = pathinfo($photo, PATHINFO_EXTENSION); // extraction de l'extension du fichier uploadé
    $photoName = "image_".uniqid().".".$ext; // mise en place d'un nom unique de fichier
    move_uploaded_file($files['photo']['tmp_name'], '../images/'.$photoName); // déplacement et renommage du fichier

    // Ecriture de la requête
    $sqli = 'UPDATE auteurs 
             SET aut_nom = "'.$nom.'", aut_pre = "'.$prenom.'", aut_gender = "'.$sexe.'", aut_photo = "'.$photoName.'" 
             WHERE  aut_id = '.$_POST['action1'];
    // Execution de la requete
    mysqli_query($connexion, $sqli) or die(mysqli_error($connexion));
    // Redirection
    header('Location:'.$_SERVER['HTTP_REFERER']);
}

function deleteAuteur($id) {
    require_once('../core/connexion.php');
    $sql = 'SELECT aut_photo FROM auteurs WHERE aut_id = '.$id;
    $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    $image = mysqli_fetch_array($req);

    // Suppression de l'image
    unlink('../images/'.$image['aut_photo']);
    //
    $sql = 'DELETE FROM auteurs WHERE aut_id = '.$id;
    $req = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    header('Location:'.$_SERVER['HTTP_REFERER']);
}

function addAuteur($post, $files) {
    require_once('../core/connexion.php');
    //Préparation des données (conversion des caractères sensibles en html ex: < en &lt;‡)
    $nom = htmlentities(htmlspecialchars($post['nom']));
    $prenom = htmlentities(htmlspecialchars($post['prenom']));
    $sexe = htmlentities(htmlspecialchars($post['sexe']));

    // prise en compte du fichier photo
    $photo = $files['photo']['name']; // le nom du fichier sur la machine de l'utilisateur
    $ext = pathinfo($photo, PATHINFO_EXTENSION); // extraction de l'extension du fichier uploadé
    $photoName = "image_".uniqid().".".$ext; // mise en place d'un nom unique de fichier
    move_uploaded_file($files['photo']['tmp_name'], '../images/'.$photoName); // déplacement et renommage du fichier
    
    // Ecriture de la requête
    $sql = 'INSERT INTO auteurs (aut_nom, aut_pre, aut_gender, aut_photo) VALUES ("'.$nom.'","'.$prenom.'","'.$sexe.'", "'.$photoName.'" )';
    // Execution de la requete
    mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
    // Redirection
    header('Location:'.$_SERVER['HTTP_REFERER']);
}
