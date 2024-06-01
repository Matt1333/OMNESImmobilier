<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communication avec l'Agent - Omnes Immobilier</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        #chatbox {
            width: 100%;
            height: 300px;
            border: 1px solid black;
            padding: 10px;
            overflow-y: scroll;
        }
        .message {
            padding: 5px;
            border-bottom: 1px solid #ddd;
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
        <button onclick="location.href='Rendezvous.html'">Rendez-vous</button>
        <button onclick="location.href='Votrecompte.html'">Votre compte</button>
    </nav>
    <h1>Communication avec l'Agent</h1>

    <div id="chatbox">
        <?php
        // Connexion à la base de données
        $conn = new mysqli('localhost', 'root', '', 'maison');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Récupérer les messages
        if (isset($_GET['agent_id'])) {
            $agent_id = intval($_GET['agent_id']);
        } else {
            die("Aucun agent spécifié.");
        }
        
        $client_id = 1; // Remplacer par l'ID du client connecté

        $sql_messages = "SELECT messages.message, messages.timestamp, Agent.Nom AS agent_nom, Agent.Prénom AS agent_prenom, Client.Nom AS client_nom, Client.Prenom AS client_prenom 
                         FROM messages 
                         JOIN Agent ON messages.agent_id = Agent.ID 
                         JOIN Client ON messages.client_id = Client.ID 
                         WHERE messages.agent_id = ? AND messages.client_id = ? 
                         ORDER BY messages.timestamp ASC";
        $stmt = $conn->prepare($sql_messages);
        $stmt->bind_param('ii', $agent_id, $client_id);
        $stmt->execute();
        $result_messages = $stmt->get_result();

        if ($result_messages->num_rows > 0) {
            while ($msg = $result_messages->fetch_assoc()) {
                echo "<div class='message'><strong>{$msg['agent_prenom']} {$msg['agent_nom']}:</strong> {$msg['message']} <em>{$msg['timestamp']}</em></div>";
                echo "<div class='message'><strong>{$msg['client_prenom']} {$msg['client_nom']}:</strong> {$msg['message']} <em>{$msg['timestamp']}</em></div>";
            }
        } else {
            echo "<p>Aucun message.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>

    <form action="send_message.php" method="POST">
        <textarea name="message" rows="4" cols="50" required></textarea>
        <input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>">
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
        <input type="submit" value="Envoyer">
    </form>

    <footer>
        <p>Contactez-nous :</p>
        <p>Email : <a href="mailto:omnesImmobilier92@edu.ece.fr">omnesImmobilier92@edu.ece.fr</a></p>
        <p>Téléphone : 01 23 45 67 89</p>
        <p>Adresse : 10 rue Sextius Michel, 75015 Paris, France</p>
        <p><a href="https://www.google.com/maps/place/10+Rue+Sextius+Michel,+75015+Paris,+France" target="_blank">Voir sur Google Maps</a></p>
    </footer>
</body>
</html>
