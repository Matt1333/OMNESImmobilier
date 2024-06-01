<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'maison');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des données du client
$client_id = $_SESSION['client_id'];
$sql = "SELECT * FROM client WHERE id = $client_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nom = $row['nom'];
    $prenom = $row['prenom'];
    $mail = $row['mail'];
    $telephone = $row['telephone'];
    $carte_bancaire = "**** **** **** " . substr($row['carte_bancaire'], -4); // Masquage des chiffres de la carte bancaire
    $expiration = $row['expiration'];
} else {
    $nom = $prenom = $mail = $telephone = $carte_bancaire = $expiration = "N/A";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Compte</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="uploads/logo.png" alt="Logo Omnes Immobilier">
    </header>
    <nav>
        <button onclick="location.href='accueilC.html'">Accueil</button>
        <button onclick="location.href='indexC.php'">Tout Parcourir</button>
        <button onclick="location.href='RechercheC.html'">Recherche</button>
        <button onclick="location.href='RendezvousC.html'">Rendez-vous</button>
        <button onclick="location.href='VotrecompteC.html'">Votre compte</button>
    </nav>

    <h1>Votre Compte</h1>

    <div class="container">
        <h2>Informations du client</h2>
        <table>
            <tr>
                <td>Nom</td>
                <td><?= $nom ?></td>
            </tr>
            <tr>
                <td>Prénom</td>
                <td><?= $prenom ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= $mail ?></td>
            </tr>
            <tr>
                <td>Téléphone</td>
                <td><?= $telephone ?></td>
            </tr>
            <tr>
                <td>Carte Bancaire</td>
                <td><?= $carte_bancaire ?></td>
            </tr>
            <tr>
                <td>Expiration</td>
                <td><?= $expiration ?></td>
            </tr>
        </table>
        <br>
        <button onclick="location.href='communiquer.php'">Communiquer</button>
        <button onclick="location.href='connexion.html'">Déconnexion</button>
    </div>

    <footer>
        <p>Contactez-nous :</p>
        <p>Email : <a href="mailto:omnesImmobilier92@edu.ece.fr">omnesImmobilier92@edu.ece.fr</a></p>
        <p>Téléphone : 01 23 45 67 89</p>
        <p>Adresse : 10 rue Sextius Michel, 75015 Paris, France</p>
        <p><a href="https://www.google.com/maps/place/10+Rue+Sextius+Michel,+75015+Paris,+France" target="_blank">Voir sur Google Maps</a></p>
    </footer>
</body>
</html>
