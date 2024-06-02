<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['mdp'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $nom = $conn->real_escape_string($_POST['nom']);
        $mdp = $conn->real_escape_string($_POST['mdp']);

        $sql = "SELECT * FROM agent WHERE ID = ? AND Nom = ? AND MDP = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $id, $nom, $mdp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['agent'] = $result->fetch_assoc();
            $_SESSION['agent_id'] = $id; // Ajouter l'ID de l'agent dans la session
            header("Location: accueilA.html");
            exit();
        } else {
            $error = "ID, nom ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Agent - Omnes Immobilier</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <div class="container">
        <h1>Connexion Agent</h1>
        <form action="connexionA.php" method="POST">
            <label for="id">ID:</label><br>
            <input type="text" id="id" name="id" required><br>
            <label for="nom">Nom:</label><br>
            <input type="text" id="nom" name="nom" required><br>
            <label for="mdp">Mot de passe:</label><br>
            <input type="password" id="mdp" name="mdp" required><br><br>
            <input type="submit" value="Se connecter">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?= $error ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
