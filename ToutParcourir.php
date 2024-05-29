<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propriétés Immobilières - Omnes Immobilier</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<header>
        <img src="logo.png" alt="Logo Omnes Immobilier">
    </header>
    <nav>
        <button onclick="location.href='accueil.html'">Accueil</button>
        <button onclick="location.href='ToutParcourir.php'">Tout Parcourir</button>
        <button onclick="location.href='Recherche.html'">Recherche</button>
        <button onclick="location.href='Rendezvous.html'">Rendez-vous</button>
        <button onclick="location.href='Votrecompte.html'">Votre compte</button>
    </nav>
<body>
    <h1>Propriétés Immobilières - Omnes Immobilier</h1>
    <table>
        <tr>
            <th>Type</th>
            <th>Nom</th>
            <th>Numéro</th>
            <th>Ville</th>
            <th>Description</th>
            <th>Adresse</th>
            <th>Image</th>
            <th>Vidéo</th>
        </tr>
        <?php
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "omnesimmobilier";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Récupération des données de la table properties
        $sql = "SELECT * FROM properties";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Affichage des données dans le tableau
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["number"] . "</td>";
                echo "<td>" . $row["city"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td><img src='" . $row["image"] . "' height='80' width='100'></td>";
                echo "<td><a href='" . $row["video"] . "'>Voir la vidéo</a></td>";
                echo "</tr>";
            }
        } else {
            echo "0 résultats";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
