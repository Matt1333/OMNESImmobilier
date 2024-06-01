<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer'])) {
    // Récupérer l'ID depuis l'URL
    $property_id = intval($_GET['id']);

    // Requête SQL pour supprimer les informations de la table 'description'
    $sql = "DELETE FROM description WHERE property_id=$property_id";

    // Exécuter la requête
    if ($conn->query($sql) === TRUE) {
        // Redirection vers detail.php après la suppression
        header("Location: detail.php?id=$property_id");
        exit();
    } else {
        echo "Erreur lors de la suppression: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer des informations</title>
</head>
<body>
    <h1>Supprimer des informations</h1>
    <!-- Formulaire pour supprimer les informations -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $_GET['id']; ?>">
        <p>Êtes-vous sûr de vouloir supprimer ces informations?</p>
        <input type="submit" name="supprimer" value="Supprimer">
    </form>
</body>
</html>
