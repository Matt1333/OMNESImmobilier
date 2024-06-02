<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $agent_id = intval($_POST['agent_id']);
    $client_id = 1; // Remplacer par l'ID du client connecté

    // Vérifier si une discussion existe déjà
    $sql_check = "SELECT * FROM messages WHERE agent_id = ? AND client_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('ii', $agent_id, $client_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows == 0) {
        // Insérer un message de bienvenue pour démarrer la discussion
        $welcome_message = "Bienvenue dans votre nouvelle discussion.";
        $sql_insert = "INSERT INTO messages (message, agent_id, client_id, sender, timestamp) VALUES (?, ?, ?, 'system', NOW())";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param('sii', $welcome_message, $agent_id, $client_id);
        $stmt_insert->execute();
    }

    $stmt_check->close();
    $conn->close();

    // Rediriger vers la page de communication
    header("Location: communiquerC.php?agent_id=" . $agent_id);
    exit();
}
?>
