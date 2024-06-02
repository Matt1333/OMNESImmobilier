<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nom']) && isset($_POST['mdp'])) {
        $nom = $_POST['nom'];
        $mdp = $_POST['mdp'];

        $sql = "SELECT * FROM Administrateur WHERE Nom = ? AND MDP = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $nom, $mdp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['admin'] = $result->fetch_assoc();
            header("Location: accueil.html");
            exit();
        } else {
            $error = "Nom ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur - Omnes Immobilier</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <div class="container">
        <h1>Connexion Administrateur</h1>
        <form action="connexionAdmin.php" method="POST">
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
