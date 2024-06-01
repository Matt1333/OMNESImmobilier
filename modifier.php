<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupération du bien à modifier
    $sql = "SELECT * FROM properties WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Bien Immobilier</title>
</head>
<body>
    <h1>Modifier le Bien Immobilier</h1>
    <form action="modifier_action.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="type">Type:</label>
        <input type="text" name="type" id="type" value="<?php echo $row['type']; ?>" required><br><br>
        <label for="name">Nom:</label>
        <input type="text" name="name" id="name" value="<?php echo $row['name']; ?>" required><br><br>
        <label for="number">Numéro:</label>
        <input type="number" name="number" id="number" value="<?php echo $row['number']; ?>" required><br><br>
        <label for="city">Ville:</label>
        <input type="text" name="city" id="city" value="<?php echo $row['city']; ?>" required><br><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo $row['description']; ?></textarea><br><br>
        <label for="adress">Adresse:</label>
        <input type="text" name="adress" id="adress" value="<?php echo $row['adress']; ?>" required><br><br>
        <label for="image">Image:</label>
        <input type="file" name="image" id="image"><br><br>
        <label for="video">Vidéo:</label>
        <input type="text" name="video" id="video" value="<?php echo $row['video']; ?>"><br><br>
        <input type="submit" value="Modifier">
    </form>
    <a href="index.php">Retour à la liste</a>
</body>
</html>
<?php
    } else {
        echo "Bien introuvable.";
    }
    $conn->close();
} else {
    echo "ID non spécifié.";
}
?>
