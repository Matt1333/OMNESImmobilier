<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Suppression du bien
    $sql = "DELETE FROM properties WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Bien supprimé avec succès.";
    } else {
        echo "Erreur: " . $conn->error;
    }

    $conn->close();
}
?>
<a href="index.php">Retour à la liste</a>
