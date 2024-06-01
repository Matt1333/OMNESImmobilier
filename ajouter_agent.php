<?php
// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $mail = $_POST['mail'];
    $specialite = $_POST['specialite'];
    $jour_dispo = $_POST['jour_dispo'];

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handling file uploads
    $photo_path = '';
    $cv_path = '';
    $upload_dir = 'uploads/';

    // Upload photo
    if (!empty($_FILES['photo']['name'])) {
        $photo_path = $upload_dir . basename($_FILES['photo']['name']);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
            echo "Photo téléchargée avec succès.<br>";
        } else {
            echo "Erreur lors du téléchargement de la photo.<br>";
        }
    }

    // Upload CV
    if (!empty($_FILES['cv']['name'])) {
        $cv_path = $upload_dir . basename($_FILES['cv']['name']);
        if (move_uploaded_file($_FILES['cv']['tmp_name'], $cv_path)) {
            echo "CV téléchargé avec succès.<br>";
        } else {
            echo "Erreur lors du téléchargement du CV.<br>";
        }
    }

    // Insertion des données de l'agent dans la table Agent
    $sql_insert_agent = "INSERT INTO Agent (ID, Nom, Prénom, Telephone, Mail, Specialite, JourDispo, Photo, CV) VALUES ('$id', '$nom', '$prenom', '$telephone', '$mail', '$specialite', '$jour_dispo', '$photo_path', '$cv_path')";
    if ($conn->query($sql_insert_agent) === TRUE) {
        echo "Agent ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'agent : " . $conn->error;
    }

    // Récupération de l'ID de l'agent nouvellement ajouté
    $agent_id = $conn->insert_id;

    // Insertion des créneaux de disponibilité dans la table creneaux_disponibles
    $jour_semaine = $_POST['jour_semaine'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];

    // Insérer chaque créneau de disponibilité
    for ($i = 0; $i < count($jour_semaine); $i++) {
        $sql_insert_creneau = "INSERT INTO creneaux_disponibles (agent_id, jour_semaine, heure_debut, heure_fin) VALUES ('$agent_id', '$jour_semaine[$i]', '$heure_debut[$i]', '$heure_fin[$i]')";
        if ($conn->query($sql_insert_creneau) === TRUE) {
            echo "Créneau de disponibilité ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du créneau de disponibilité : " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Agent</title>
    <script>
        function addAvailability() {
            const container = document.getElementById("availability-container");
            const availabilityHtml = `
                <div class="availability-slot">
                    <label for="jour_semaine[]">Jour de la semaine :</label><br>
                    <select id="jour_semaine[]" name="jour_semaine[]">
                        <option value="Lundi">Lundi</option>
                        <option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option>
                        <option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option>
                        <option value="Samedi">Samedi</option>
                        <option value="Dimanche">Dimanche</option>
                    </select><br>
                    <label for="heure_debut[]">Heure de début :</label><br>
                    <input type="time" id="heure_debut[]" name="heure_debut[]"><br>
                    <label for="heure_fin[]">Heure de fin :</label><br>
                    <input type="time" id="heure_fin[]" name="heure_fin[]"><br><br>
                </div>`;
            container.insertAdjacentHTML('beforeend', availabilityHtml);
        }
    </script>
</head>
<body>
    <h2>Ajouter Agent</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label for="id">ID :</label><br>
        <input type="text" id="id" name="id"><br>
        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom"><br>
        <label for="prenom">Prénom :</label><br>
        <input type="text" id="prenom" name="prenom"><br>
        <label for="telephone">Téléphone :</label><br>
        <input type="text" id="telephone" name="telephone"><br>
        <label for="mail">Mail :</label><br>
        <input type="text" id="mail" name="mail"><br>
        <label for="specialite">Spécialité :</label><br>
        <select id="specialite" name="specialite">
            <option value="Appartement à louer">Appartement à louer</option>
            <option value="Immobilier résidentiel">Immobilier résidentiel</option>
            <option value="Immobilier commercial">Immobilier commercial</option>
            <option value="Terrain">Terrain</option>
        </select><br>
        <label for="jour_dispo">Jours de disponibilité :</label><br>
        <input type="text" id="jour_dispo" name="jour_dispo"><br>
        
        <div id="availability-container">
            <div class="availability-slot">
                <label for="jour_semaine[]">Jour de la semaine :</label><br>
                <select id="jour_semaine[]" name="jour_semaine[]">
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                    <option value="Dimanche">Dimanche</option>
                </select><br>
                <label for="heure_debut[]">Heure de début :</label><br>
                <input type="time" id="heure_debut[]" name="heure_debut[]"><br>
                <label for="heure_fin[]">Heure de fin :</label><br>
                <input type="time" id="heure_fin[]" name="heure_fin[]"><br><br>
            </div>
        </div>
        <button type="button" onclick="addAvailability()">Ajouter une autre disponibilité</button><br><br>

        <label for="photo">Photo :</label><br>
        <input type="file" id="photo" name="photo" accept="image/*"><br>
        <label for="cv">CV :</label><br>
        <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx"><br><br>
        
        <input type="submit" value="Ajouter">
    </form>
    
    <!-- Bouton pour revenir à index.php -->
    <form action="index.php">
        <input type="submit" value="Retour à la page d'accueil">
    </form>
</body>
</html>
