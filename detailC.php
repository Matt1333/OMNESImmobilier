<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Bien Immobilier</title>
   
    <link rel="stylesheet" href="stylesTout_parcourir.css">
    <link rel="stylesheet" href="styles_detail.css">
    <style>
        .felicitations {
            font-size: 24px;
            background-color: yellow;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <nav>
        <button onclick="location.href='accueilC.html'">Accueil</button>
        <button onclick="location.href='indexC.php'">Tout Parcourir</button>
        <button onclick="location.href='RechercheC.html'">Recherche</button>
        <button onclick="location.href='RendezvousPC.php'">Rendez-vous</button>
        <button onclick="location.href='VotrecompteC.php'">Votre compte</button>
    </nav>
    <?php
    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Vérification si le formulaire a été soumis
        $id = intval($_GET['id']);
        // Mise à jour de l'état du bien immobilier
        $sql_update = "UPDATE properties SET Etat = 'vendu' WHERE id = $id";
        
        if ($conn->query($sql_update) === TRUE) {
            echo "<p class='felicitations'>Félicitations pour votre acquisition, Omnes Immobilier vous en remercie.</p>";
        } else {
            echo "<p style='color: red;'>Erreur lors de la mise à jour de l'état du bien immobilier.</p>";
        }
    }

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
        echo "<h1>{$row['name']}</h1>
              <p><strong>Type:</strong> {$row['type']}</p>
              <p><strong>Numéro:</strong> {$row['number']}</p>
              <p><strong>Ville:</strong> {$row['city']}</p>
              <p><strong>Description:</strong> {$row['description']}</p>
              <p><strong>Adresse:</strong> {$row['adress']}</p>
              <img src='{$row['image']}' alt='Image' width='300'>
              <p><strong>Nombre de chambres:</strong> {$row['num_rooms']}</p>
              <p><strong>Prix:</strong> {$row['price']}</p>
              <p><strong>Nombre d'étages:</strong> {$row['num_floors']}</p>
              <p><strong>Images:</strong></p>";
        
        // Affichage du carrousel d'images
        $images = explode(',', $row['image_carousel']);
        echo "<div class='carousel'>";
        foreach ($images as $image) {
            echo "<img src='$image' alt='Carousel Image' width='300'>";
        }
        echo "</div>";

        echo "<p><strong>Nombre de mètres carrés:</strong> {$row['square_meters']}</p>
              <p><strong>Informations Complémentaires:</strong> {$row['additional_info']}</p>";

        // Afficher le bouton "Acheter" uniquement si le bien n'est pas vendu
        if ($row['Etat'] != 'vendu') {
            echo "<form action='' method='post'>
                      <input type='submit' name='acheter' value='Acheter'>
                  </form>";
        } else {
            echo "<p>Ce bien est déjà vendu.</p>";
        }
    } else {
        echo "<p>Aucun détail trouvé pour ce bien immobilier.</p>";
    }

    $conn->close();
    ?>
</body>
</html>

