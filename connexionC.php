<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mdp'])) {
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mdp = $_POST['mdp'];

        $sql = "SELECT * FROM client WHERE ID = ? AND Nom = ? AND Prenom = ? AND MDP = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isss', $id, $nom, $prenom, $mdp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['client'] = $result->fetch_assoc();
            $_SESSION['client_id'] = $id;
            header("Location: accueilC.html");
            exit();
        } else {
            $error = "ID, nom, prénom ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Client - Omnes Immobilier</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <div class="container">
        <h1>Connexion Client</h1>
        <form action="connexionC.php" method="POST">
            <label for="id">ID:</label><br>
            <input type="number" id="id" name="id" required><br>
            <label for="nom">Nom:</label><br>
            <input type="text" id="nom" name="nom" required><br>
            <label for="prenom">Prénom:</label><br>
            <input type="text" id="prenom" name="prenom" required><br>
            <label for="mdp">Mot de passe:</label><br>
            <input type="password" id="mdp" name="mdp" required><br><br>
            <input type="submit" value="Se connecter">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?= $error ?></p>
            <?php endif; ?>
        </form>
        <p>Pas de compte ? <a href="creationC.php">Créez-en un ici</a></p>
    </div>
</body>
</html>
