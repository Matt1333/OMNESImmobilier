<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['telephone']) && isset($_POST['carte_bancaire']) && isset($_POST['expiration']) && isset($_POST['code_securite']) && isset($_POST['mdp'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $telephone = $_POST['telephone'];
        $carte_bancaire = $_POST['carte_bancaire'];
        $expiration = $_POST['expiration'];
        $code_securite = $_POST['code_securite'];
        $mdp = $_POST['mdp'];

        $sql = "INSERT INTO client (Nom, Prenom, Mail, Telephone, Carte_Bancaire, Expiration, Code_Securite, MDP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssss', $nom, $prenom, $mail, $telephone, $carte_bancaire, $expiration, $code_securite, $mdp);
        $stmt->execute();

        header("Location: connexionC.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Compte Client - Omnes Immobilier</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <div class="container">
        <h1>Création de Compte Client</h1>
        <form action="creationC.php" method="POST">
            <label for="nom">Nom:</label><br>
            <input type="text" id="nom" name="nom" required><br>
            <label for="prenom">Prénom:</label><br>
            <input type="text" id="prenom" name="prenom" required><br>
            <label for="mail">Email:</label><br>
            <input type="email" id="mail" name="mail" required><br>
            <label for="telephone">Téléphone:</label><br>
            <input type="tel" id="telephone" name="telephone" required><br>
            <label for="carte_bancaire">Carte Bancaire:</label><br>
            <input type="text" id="carte_bancaire" name="carte_bancaire" required><br>
            <label for="expiration">Expiration:</label><br>
            <input type="date" id="expiration" name="expiration" required><br>
            <label for="code_securite">Code Sécurité:</label><br>
            <input type="text" id="code_securite" name="code_securite" required><br>
            <label for="mdp">Mot de passe:</label><br>
            <input type="password" id="mdp" name="mdp" required><br><br>
            <input type="submit" value="Créer le compte">
        </form>
    </div>
</body>
</html>

