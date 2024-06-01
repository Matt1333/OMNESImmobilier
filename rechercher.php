<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la Recherche</title>
    <link rel="stylesheet" href="stylesRecherche.css">
    <link rel="stylesheet" href="stylesTout_parcourir.css">
    <link rel="stylesheet" href="styles_detail.css">
</head>
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <nav>
        <button onclick="location.href='accueil.html'">Accueil</button>
        <button onclick="location.href='test/index.php'">Tout Parcourir</button>
        <button onclick="location.href='Recherche.html'">Recherche</button>
        <button onclick="location.href='RendezvousP.php'">Rendez-vous</button>
        <button onclick="location.href='Votrecompte.php'">Votre compte</button>
    </nav>
    <h1>Résultats de la Recherche</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Nom</th>
            <th>Numéro</th>
            <th>Ville</th>
            <th>Description</th>
            <th>Adresse</th>
            <th>Image</th>
            <th>Vidéo</th>
            <th>Actions</th>
        </tr>
        
        <?php
        // Connexion à la base de données
        $conn = new mysqli('localhost', 'root', '', 'maison');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Récupération des données de recherche
        $searchType = $_GET['searchType'];
        $searchQuery = $conn->real_escape_string($_GET['searchQuery']);

        // Définition des types de propriétés valides
        $validTypes = ['Appartement', 'Maison', 'Bureau', 'Commerce'];

        // Construction de la requête SQL en fonction du type de recherche
        if ($searchType == 'number') {
            $sql = "SELECT * FROM properties WHERE number = '$searchQuery'";
        } else if ($searchType == 'city') {
            $sql = "SELECT * FROM properties WHERE city LIKE '%$searchQuery%'";
        } else if ($searchType == 'type' && in_array($searchQuery, $validTypes)) {
            $sql = "SELECT * FROM properties WHERE type = '$searchQuery'";
        } else {
            echo "<tr><td colspan='10'>Type de recherche invalide ou type de propriété non reconnu</td></tr>";
            $conn->close();
            exit();
        }

        $result = $conn->query($sql);

        // Vérification des erreurs de requête
        if ($result === false) {
            die("Erreur dans la requête SQL : " . $conn->error);
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td><a href='detail.php?id={$row['id']}'>{$row['id']}</a></td>
                        <td>{$row['type']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['number']}</td>
                        <td>{$row['city']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['adress']}</td>
                        <td><img src='{$row['image']}' alt='Image' width='100'></td>
                        <td>{$row['video']}</td>
                        <td>
                            <a href='modifier.php?id={$row['id']}'>Modifier</a>
                            <a href='supprimer.php?id={$row['id']}'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>Aucun bien trouvé</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
