<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $city = $_POST['city'];
    $description = $_POST['description'];
    $adress = $_POST['adress'];
    $video = $_POST['video'];

    // Upload de l'image
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insertion du nouveau bien
    $sql = "INSERT INTO properties (type, name, number, city, description, adress, image, video) 
            VALUES ('$type', '$name', $number, '$city', '$description', '$adress', '$target_file', '$video')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouveau bien ajouté avec succès.";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<a href="index.php">Retour à la liste</a>
