<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $city = $_POST['city'];
    $description = $_POST['description'];
    $adress = $_POST['adress'];
    $video = $_POST['video'];

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Mise à jour de l'image si un nouveau fichier est uploadé
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $sql = "UPDATE properties SET type='$type', name='$name', number=$number, city='$city', description='$description', adress='$adress', image='$target_file', video='$video' WHERE id=$id";
    } else {
        $sql = "UPDATE properties SET type='$type', name='$name', number=$number, city='$city', description='$description', adress='$adress', video='$video' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Bien modifié avec succès.";
    } else {
        echo "Erreur: " . $conn->error;
    }

    $conn->close();
}
?>
<a href="index.php">Retour à la liste</a>
