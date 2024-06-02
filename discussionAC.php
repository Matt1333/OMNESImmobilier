<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['client_id'])) {
    header('Location: login.php'); // Redirection vers la page de connexion si non connecté
    exit();
}

$client_id = $_SESSION['client_id'];

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des agents avec lesquels le client a eu des discussions
$sql = "SELECT DISTINCT a.ID, a.Nom, a.Prénom 
        FROM messages m
        JOIN Agent a ON m.agent_id = a.ID
        WHERE m.client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$result = $stmt->get_result();

// Vérification des erreurs de requête
if ($result === false) {
    die("Erreur dans la requête SQL : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussions - Omnes Immobilier</title>
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
        <button onclick="location.href='accueilC.html'">Accueil</button>
        <button onclick="location.href='indexC.php'">Tout Parcourir</button>
        <button onclick="location.href='RechercheC.html'">Recherche</button>
        <button onclick="location.href='RendezvousPC.php'">Rendez-vous</button>
        <button onclick="location.href='VotrecompteC.php'">Votre compte</button>
    </nav>
    <h1>Vos Discussions</h1>
    <table>
        <tr>
            <th>ID Agent</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Discussion</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['ID']}</td>
                        <td>{$row['Nom']}</td>
                        <td>{$row['Prénom']}</td>
                        <td><a href='communiquerC.php?agent_id={$row['ID']}'>{$row['Prénom']} {$row['Nom']}</a></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Aucune discussion trouvée</td></tr>";
        }

        // Fermeture de la connexion
        $stmt->close();
        $conn->close();
        ?>
    </table>
</body>
</html>
