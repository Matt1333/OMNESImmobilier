<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
    // Récupérer les valeurs du formulaire
    $num_rooms = $_POST['num_rooms'];
    $price = $_POST['price'];
    $num_floors = $_POST['num_floors'];
    $square_meters = $_POST['square_meters'];
    $additional_info = $_POST['additional_info'];
    
    // Récupérer l'ID depuis l'URL
    $id = intval($_GET['id']);
    
    // Traitement des images
    $image_carousel = '';
    if(isset($_FILES['image_carousel'])){
        $uploadDir = 'uploads/'; // Répertoire où les images seront stockées
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        $files = $_FILES['image_carousel'];
        foreach($files['tmp_name'] as $key => $tmp_name){
            $fileName = basename($files['name'][$key]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if(in_array($fileType, $allowedTypes)){
                $targetPath = $uploadDir . $fileName;
                move_uploaded_file($tmp_name, $targetPath);
                $image_carousel .= $targetPath . ',';
            }
        }
        $image_carousel = rtrim($image_carousel, ','); // Supprimer la virgule finale
    }

    // Requête SQL pour mettre à jour les informations dans la table 'description'
    $sql = "UPDATE description SET num_rooms='$num_rooms', price='$price', num_floors='$num_floors', image_carousel='$image_carousel', square_meters='$square_meters', additional_info='$additional_info' WHERE property_id=$id";
    
    // Exécuter la requête
    if ($conn->query($sql) === TRUE) {
        // Redirection vers detail.php après la modification
        header("Location: detail.php?id=$id");
        exit();
    } else {
        echo "Erreur lors de la modification: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier des informations</title>
</head>
<body>
    <h1>Modifier des informations</h1>
    <?php
    // Récupération de l'ID depuis l'URL
    $id = intval($_GET['id']);

    // Récupération des détails du bien immobilier
    $sql = "SELECT p.*, d.* FROM properties p LEFT JOIN description d ON p.id = d.property_id WHERE p.id = $id";
    $result = $conn->query($sql);

    // Vérification des erreurs de requête
    if ($result === false) {
        die("Erreur dans la requête SQL : " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
    <!-- Formulaire pour modifier les informations -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" enctype="multipart/form-data">
        <label for="num_rooms">Nombre de chambres:</label>
        <input type="text" name="num_rooms" value="<?php echo $row['num_rooms']; ?>"><br>
        <label for="price">Prix:</label>
        <input type="text" name="price" value="<?php echo $row['price']; ?>"><br>
        <label for="num_floors">Nombre d'étages:</label>
        <input type="text" name="num_floors" value="<?php echo $row['num_floors']; ?>"><br>
        <label for="image_carousel">Images :</label>
        <input type="file" name="image_carousel[]" multiple accept="image/*"><br>
        <label for="square_meters">Nombre de mètres carrés:</label>
        <input type="text" name="square_meters" value="<?php echo $row['square_meters']; ?>"><br>
        <label for="additional_info">Informations Complémentaires:</label>
        <textarea name="additional_info"><?php echo $row['additional_info']; ?></textarea><br>
        <input type="submit" name="modifier" value="Modifier">
    </form>
    <?php
    } else {
        echo "<p>Aucun détail trouvé pour ce bien immobilier.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
