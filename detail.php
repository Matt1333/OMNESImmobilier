<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Bien Immobilier</title>
   
    <link rel="stylesheet" href="stylesTout_parcourir.css">
    <link rel="stylesheet" href="styles_detail.css">
</head>
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <nav>
        <button onclick="location.href='accueil.html'">Accueil</button>
        <button onclick="location.href='index.php'">Tout Parcourir</button>
        <button onclick="location.href='Recherche.html'">Recherche</button>
        <button onclick="location.href='Rendezvous.html'">Rendez-vous</button>
        <button onclick="location.href='Votrecompte.html'">Votre compte</button>
    </nav>
    <h1>Détails du Bien Immobilier</h1>
    <?php
    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
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
        echo "<h2>{$row['name']}</h2>
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

        // Lien vers la page de modification
        echo "<a href='modifier_detail.php?id=$id'>Modifier</a><br>";

        // Lien vers la page de suppression
        echo "<a href='supprimer_detail.php?id=$id'>Supprimer</a><br>";

        // Lien vers la page d'ajout
        echo "<a href='ajouter_detail.php?id=$id'>Ajouter</a>";
    } else {
        echo "<p>Aucun détail trouvé pour ce bien immobilier.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
