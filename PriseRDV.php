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
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <nav>
        <button onclick="location.href='accueil.html'">Accueil</button>
        <button onclick="location.href='index.php'">Tout Parcourir</button>
        <button onclick="location.href='Recherche.html'">Recherche</button>
        <button onclick="location.href='RendezvousP.php'">Rendez-vous</button>
        <button onclick="location.href='Votrecompte.html'">Votre compte</button>
    </nav>

    <?php
    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['creneau_id']) && isset($_POST['agent_id'])) {
        $creneau_id = $_POST['creneau_id'];
        $agent_id = $_POST['agent_id'];

        // Récupération des informations du créneau
        $sql_creneau = "SELECT * FROM creneaux_disponibles WHERE id = ?";
        $stmt = $conn->prepare($sql_creneau);
        $stmt->bind_param('i', $creneau_id);
        $stmt->execute();
        $creneau = $stmt->get_result()->fetch_assoc();

        // Enregistrement du rendez-vous
        $sql_rdv = "INSERT INTO rendez_vous (agent_id, date, heure_debut, heure_fin) VALUES (?, CURDATE(), ?, ?)";
        $stmt = $conn->prepare($sql_rdv);
        $stmt->bind_param('iss', $agent_id, $creneau['heure_debut'], $creneau['heure_fin']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<p>Rendez-vous pris avec succès.</p>";
        } else {
            echo "<p>Erreur lors de la prise de rendez-vous.</p>";
        }

        $stmt->close();
    } else if (isset($_GET['agent_id'])) {
        $agent_id = $_GET['agent_id'];

        // Récupération des créneaux horaires disponibles pour l'agent
        $sql_creneaux = "SELECT * FROM creneaux_disponibles WHERE agent_id = ? AND NOT EXISTS (SELECT 1 FROM rendez_vous WHERE creneaux_disponibles.agent_id = rendez_vous.agent_id AND creneaux_disponibles.heure_debut = rendez_vous.heure_debut AND rendez_vous.date = CURDATE())";
        $stmt = $conn->prepare($sql_creneaux);
        $stmt->bind_param('i', $agent_id);
        $stmt->execute();
        $result_creneaux = $stmt->get_result();
    ?>
        <h1>Prendre un Rendez-vous</h1>

        <?php
        if ($result_creneaux->num_rows > 0) {
            echo "<form action='priseRDV.php' method='POST'>";
            echo "<input type='hidden' name='agent_id' value='{$agent_id}'>";
            echo "<label for='creneau'>Sélectionnez un créneau horaire:</label>";
            echo "<select name='creneau_id' id='creneau'>";
            while ($creneau = $result_creneaux->fetch_assoc()) {
                echo "<option value='{$creneau['id']}'>{$creneau['jour_semaine']} de {$creneau['heure_debut']} à {$creneau['heure_fin']}</option>";
            }
            echo "</select>";
            echo "<input type='submit' value='Prendre Rendez-vous'>";
            echo "</form>";
        } else {
            echo "<p>Aucun créneau disponible pour cet agent.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Agent non spécifié.</p>";
    }

    $conn->close();
    ?>
</body>
</html>

