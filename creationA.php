<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['telephone']) && isset($_POST['cv']) && isset($_POST['photo']) && isset($_POST['jour_dispo']) && isset($_POST['digicode']) && isset($_POST['adresse']) && isset($_POST['specialite']) && isset($_POST['mdp'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $telephone = $_POST['telephone'];
        $cv = $_POST['cv'];
        $photo = $_POST['photo'];
        $jour_dispo = $_POST['jour_dispo'];
        $digicode = $_POST['digicode'];
        $adresse = $_POST['adresse'];
        $specialite = $_POST['specialite'];
        $mdp = $_POST['mdp'];

        $sql = "INSERT INTO agent (Nom, Prenom, Telephone, Mail, CV, Photo, JourDispo, Digicode, Adresse, Specialite, MDP) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssssss', $nom, $prenom, $telephone, $mail, $cv, $photo, $jour_dispo, $digicode, $adresse, $specialite, $mdp);
        $stmt->execute();

        header("Location: connexionA.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Compte Agent - Omnes Immobilier</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <div class="container">
        <h1>Création de Compte Agent</h1>
        <form action="creationA.php" method="POST">
            <label for="nom">Nom:</label><br>
            <input type="text" id="nom" name="nom" required><br>
            <label for="prenom">Prénom:</label><br>
            <input type="text" id="prenom" name="prenom" required><br>
            <label for="mail">Email:</label><br>
            <input type="email" id="mail" name="mail" required><br>
            <label for="telephone">Téléphone:</label><br>
            <input type="tel" id="telephone" name="telephone" required><br>
            <label for="cv">CV:</label><br>
            <input type="text" id="cv" name="cv" required><br>
            <label for="photo">Photo:</label><br>
            <input type="text" id="photo" name="photo" required><br>
            <label for="jour_dispo">Jour de Disponibilité:</label><br>
            <input type="text" id="jour_dispo" name="jour_dispo" required><br>
            <label for="digicode">Digicode:</label><br>
            <input type="text" id="digicode" name="digicode" required><br>
            <label for="adresse">Adresse:</label><br>
            <input type="text" id="adresse" name="adresse" required><br>
            <label for="specialite">Spécialité:</label><br>
            <input type="text" id="specialite" name="specialite" required><br>
            <label for="mdp">Mot de passe:</label><br>
            <input type="password" id="mdp" name="mdp" required><br><br>
            <input type="submit" value="Créer le compte">
        </form>
    </div>
</body>
</html>
