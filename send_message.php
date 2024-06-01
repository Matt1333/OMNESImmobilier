<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message']) && isset($_POST['agent_id']) && isset($_POST['client_id'])) {
    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $message = $_POST['message'];
    $agent_id = $_POST['agent_id'];
    $client_id = $_POST['client_id'];

    // Enregistrer le message
    $sql_insert = "INSERT INTO messages (agent_id, client_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param('iis', $agent_id, $client_id, $message);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Message envoyé avec succès.";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }

    $stmt->close();
    $conn->close();

    // Rediriger vers la page de chat
    header("Location: communiquer.php?agent_id=$agent_id");
}
?>
