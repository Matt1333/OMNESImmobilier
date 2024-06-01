<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Biens Immobiliers - Omnes Immobilier</title>
    <link rel="stylesheet" href="stylesTout_parcourir.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            color: black; /* Texte en noir */
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <nav>
        <button onclick="location.href='accueilA.html'">Accueil</button>
        <button onclick="location.href='indexA.php'">Tout Parcourir</button>
        <button onclick="location.href='RechercheA.html'">Recherche</button>
        <button onclick="location.href='RendezvousPA.php'">Rendez-vous</button>
        <button onclick="location.href='VotrecompteA.php'">Votre compte</button>
    </nav>
    <h1>Liste des Biens Immobiliers</h1>
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
            <th>État</th> <!-- Nouvelle colonne ajoutée -->
        </tr>
        
        <!-- PHP pour afficher les biens immobiliers -->
        <?php
        // Connexion à la base de données
        $conn = new mysqli('localhost', 'root', '', 'maison');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Récupération des biens classés par type
        $sql = "SELECT * FROM properties ORDER BY type"; // Tri par type
        $result = $conn->query($sql);

        // Vérification des erreurs de requête
        if ($result === false) {
            die("Erreur dans la requête SQL : " . $conn->error);
        }

        if ($result->num_rows > 0) {
            $current_type = ""; // Garder une trace du type actuel
            while ($row = $result->fetch_assoc()) {
                // Si le type change, afficher un titre pour le nouveau type
                if ($row['type'] != $current_type) {
                    echo "<tr><th colspan='10'>{$row['type']}</th></tr>";
                    $current_type = $row['type'];
                }

                // Afficher les détails du bien immobilier
                echo "<tr>
                        <td><a href='detailA.php?id={$row['id']}'>{$row['id']}</a></td>
                        <td>{$row['type']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['number']}</td>
                        <td>{$row['city']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['adress']}</td>
                        <td><img src='{$row['image']}' alt='Image' width='100'></td>
                        <td>{$row['video']}</td>
                        <td>{$row['Etat']}</td> <!-- Affichage de l'état -->
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>Aucun bien trouvé</td></tr>";
        }
        ?>
    </table>
</body>
</html>
