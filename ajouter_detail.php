<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter'])) {
    // Récupérer les valeurs du formulaire
    $property_id = intval($_GET['id']); // Récupérer l'ID de la propriété
    $num_rooms = $_POST['num_rooms'];
    $price = $_POST['price'];
    $num_floors = $_POST['num_floors'];
    $square_meters = $_POST['square_meters'];
    $additional_info = $_POST['additional_info'];

    // Traitement des images
    $image_carousel = '';
    if(isset($_FILES['image_carousel'])){
        $uploadDir = 'uploads/'; // Répertoire où les images seront stockées
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        $files = array_filter($_FILES['image_carousel']['name']);
        foreach($files as $key => $value){
            $fileTmpName = $_FILES['image_carousel']['tmp_name'][$key];
            $fileName = basename($_FILES['image_carousel']['name'][$key]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if(in_array($fileType, $allowedTypes)){
                $targetPath = $uploadDir . $fileName;
                move_uploaded_file($fileTmpName, $targetPath);
                $image_carousel .= $targetPath . ',';
            }
        }
        $image_carousel = rtrim($image_carousel, ','); // Supprimer la virgule finale
    }

    // Requête SQL pour insérer les nouvelles données dans la table 'description'
    $sql = "INSERT INTO description (property_id, num_rooms, price, num_floors, image_carousel, square_meters, additional_info) VALUES ('$property_id', '$num_rooms', '$price', '$num_floors', '$image_carousel', '$square_meters', '$additional_info')";

    // Exécuter la requête
    if ($conn->query($sql) === TRUE) {
        // Redirection vers detail.php après l'ajout
        header("Location: detail.php?id=$property_id");
        exit();
    } else {
        echo "Erreur lors de l'ajout: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des informations</title>
</head>
<body>
    <h1>Ajouter des informations</h1>
    <!-- Formulaire pour ajouter de nouvelles informations -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $_GET['id']; ?>" enctype="multipart/form-data">
        <label for="num_rooms">Nombre de chambres:</label>
        <input type="text" name="num_rooms"><br>
        <label for="price">Prix:</label>
        <input type="text" name="price"><br>
        <label for="num_floors">Nombre d'étages:</label>
        <input type="text" name="num_floors"><br>
        <label for="image_carousel">Images (séparées par des virgules):</label>
        <input type="file" name="image_carousel[]" multiple accept="image/*"><br>
        <label for="square_meters">Nombre de mètres carrés:</label>
        <input type="text" name="square_meters"><br>
        <label for="additional_info">Informations Complémentaires:</label>
        <textarea name="additional_info"></textarea><br>
        <input type="submit" name="ajouter" value="Ajouter">
    </form>
</body>
</html>
