<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Rendez-vous - Omnes Immobilier</title>
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
    <h1>Vos Rendez-vous</h1>

    <?php
    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Annulation d'un rendez-vous
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rdv_id'])) {
        $rdv_id = $_POST['rdv_id'];

        // Suppression du rendez-vous
        $sql_delete = "DELETE FROM rendez_vous WHERE id = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param('i', $rdv_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<p>Rendez-vous annulé avec succès.</p>";
        } else {
            echo "<p>Erreur lors de l'annulation du rendez-vous.</p>";
        }

        $stmt->close();
    }

    // Récupération des rendez-vous confirmés
    $sql_rdv = "SELECT rendez_vous.id, rendez_vous.date, rendez_vous.heure_debut, rendez_vous.heure_fin, Agent.Nom, Agent.Prénom, Agent.adresse, Agent.digicode FROM rendez_vous JOIN Agent ON rendez_vous.agent_id = Agent.ID";
    $result_rdv = $conn->query($sql_rdv);

    if ($result_rdv->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Agent</th><th>Date</th><th>Heure</th><th>Adresse</th><th>Digicode</th><th>Actions</th></tr>";
        while ($rdv = $result_rdv->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$rdv['Prénom']} {$rdv['Nom']}</td>";
            echo "<td>{$rdv['date']}</td>";
            echo "<td>{$rdv['heure_debut']} - {$rdv['heure_fin']}</td>";
            echo "<td>{$rdv['adresse']}</td>";
            echo "<td>{$rdv['digicode']}</td>";
            echo "<td>
                    <form action='RendezvousP.php' method='POST'>
                        <input type='hidden' name='rdv_id' value='{$rdv['id']}'>
                        <input type='submit' value='Annuler le RDV'>
                    </form>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun rendez-vous confirmé.</p>";
    }

    $conn->close();
    ?>
    <footer>
        <p>Contactez-nous :</p>
        <p>Email : <a href="mailto:omnesImmobilier92@edu.ece.fr">omnesImmobilier92@edu.ece.fr</a></p>
        <p>Téléphone : 01 23 45 67 89</p>
        <p>Adresse : 10 rue Sextius Michel, 75015 Paris, France</p>
        <p><a href="https://www.google.com/maps/place/10+Rue+Sextius+Michel,+75015+Paris,+France" target="_blank">Voir sur Google Maps</a></p>
    </footer>
</body>
</html>
