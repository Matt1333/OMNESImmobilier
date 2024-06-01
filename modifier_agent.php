<?php
// Si l'ID de l'agent est passé en paramètre
if (isset($_GET['id'])) {
    // Récupération de l'ID de l'agent depuis l'URL
    $agent_id = $_GET['id'];

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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

        // Handling file uploads
        $photo_path = '';
        $cv_path = '';
        $upload_dir = 'uploads/';

        // Check if new photo is uploaded
        if (!empty($_FILES['photo']['name'])) {
            $photo_path = $upload_dir . basename($_FILES['photo']['name']);
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
                echo "Photo téléchargée avec succès.<br>";
            } else {
                echo "Erreur lors du téléchargement de la photo.<br>";
            }
        } else {
            // Retain old photo path if no new photo is uploaded
            $photo_path = $_POST['current_photo'];
        }

        // Check if new CV is uploaded
        if (!empty($_FILES['cv']['name'])) {
            $cv_path = $upload_dir . basename($_FILES['cv']['name']);
            if (move_uploaded_file($_FILES['cv']['tmp_name'], $cv_path)) {
                echo "CV téléchargé avec succès.<br>";
            } else {
                echo "Erreur lors du téléchargement du CV.<br>";
            }
        } else {
            // Retain old CV path if no new CV is uploaded
            $cv_path = $_POST['current_cv'];
        }

        // Mise à jour des données de l'agent dans la base de données
        $sql_update = "UPDATE Agent SET Nom='$nom', Prénom='$prenom', Telephone='$telephone', Mail='$mail', Specialite='$specialite', JourDispo='$jour_dispo', Photo='$photo_path', CV='$cv_path' WHERE ID='$agent_id'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Agent modifié avec succès. <br>";
        } else {
            echo "Erreur lors de la modification de l'agent : " . $conn->error;
        }

        // Mise à jour des créneaux de disponibilité
        $jour_semaine = $_POST['jour_semaine'];
        $heure_debut = $_POST['heure_debut'];
        $heure_fin = $_POST['heure_fin'];

        // Supprimer les anciens créneaux de disponibilité
        $sql_delete_creneaux = "DELETE FROM creneaux_disponibles WHERE agent_id='$agent_id'";
        $conn->query($sql_delete_creneaux);

        // Insérer les nouveaux créneaux de disponibilité
        for ($i = 0; $i < count($jour_semaine); $i++) {
            $sql_insert_creneau = "INSERT INTO creneaux_disponibles (agent_id, jour_semaine, heure_debut, heure_fin) VALUES ('$agent_id', '$jour_semaine[$i]', '$heure_debut[$i]', '$heure_fin[$i]')";
            if ($conn->query($sql_insert_creneau) === TRUE) {
                echo "Créneau de disponibilité mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour du créneau de disponibilité : " . $conn->error;
            }
        }

        echo "<a href='index.php'>Retour à la liste des agents</a>";
        exit(); // Arrêter le script après avoir affiché le lien de retour
    }

    // Récupération des données de l'agent à partir de son ID
    $sql_select = "SELECT * FROM Agent WHERE ID='$agent_id'";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Aucun agent trouvé avec cet ID.";
    }

    // Récupération des créneaux de disponibilité de l'agent
    $sql_select_creneaux = "SELECT * FROM creneaux_disponibles WHERE agent_id='$agent_id'";
    $result_creneaux = $conn->query($sql_select_creneaux);
    $creneaux = [];
    if ($result_creneaux->num_rows > 0) {
        while ($row_creneaux = $result_creneaux->fetch_assoc()) {
            $creneaux[] = $row_creneaux;
        }
    }

    $conn->close();
} else {
    echo "Aucun ID d'agent spécifié.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Agent</title>
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
    <h2>Modifier Agent</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$agent_id"); ?>" enctype="multipart/form-data">
        <label for="id">ID :</label><br>
        <input type="text" id="id" name="id" value="<?php echo $row['ID']; ?>"><br>
        <label for="nom">Nom :</label><br>
        <input type="text" id="nom" name="nom" value="<?php echo $row['Nom']; ?>"><br>
        <label for="prenom">Prénom :</label><br>
        <input type="text" id="prenom" name="prenom" value="<?php echo $row['Prénom']; ?>"><br>
        <label for="telephone">Téléphone :</label><br>
        <input type="text" id="telephone" name="telephone" value="<?php echo $row['Telephone']; ?>"><br>
        <label for="mail">Mail :</label><br>
        <input type="text" id="mail" name="mail" value="<?php echo $row['Mail']; ?>"><br>
        <label for="specialite">Spécialité :</label><br>
        <select id="specialite" name="specialite">
            <option value="Appartement à louer" <?php if ($row['specialite'] == 'Appartement à louer') echo 'selected'; ?>>Appartement à louer</option>
            <option value="Immobilier résidentiel" <?php if ($row['specialite'] == 'Immobilier résidentiel') echo 'selected'; ?>>Immobilier résidentiel</option>
            <option value="Immobilier commercial" <?php if ($row['specialite'] == 'Immobilier commercial') echo 'selected'; ?>>Immobilier commercial</option>
            <option value="Terrain" <?php if ($row['specialite'] == 'Terrain') echo 'selected'; ?>>Terrain</option>
        </select><br>
        <label for="jour_dispo">Jours de disponibilité :</label><br>
        <input type="text" id="jour_dispo" name="jour_dispo" value="<?php echo $row['JourDispo']; ?>"><br>
        <label for="photo">Photo :</label><br>
        <input type="file" id="photo" name="photo" accept="image/*"><br>
        <input type="hidden" name="current_photo" value="<?php echo $row['Photo']; ?>"><br>
        <label for="cv">CV :</label><br>
        <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx"><br>
        <input type="hidden" name="current_cv" value="<?php echo $row['CV']; ?>"><br><br>
        
        <h3>Disponibilité actuelle :</h3>
        <div id="availability-container">
            <?php foreach ($creneaux as $creneau): ?>
                <div class="availability-slot">
                    <label for="jour_semaine[]">Jour de la semaine :</label><br>
                    <select id="jour_semaine[]" name="jour_semaine[]">
                        <option value="Lundi" <?php if ($creneau['jour_semaine'] == 'Lundi') echo 'selected'; ?>>Lundi</option>
                        <option value="Mardi" <?php if ($creneau['jour_semaine'] == 'Mardi') echo 'selected'; ?>>Mardi</option>
                        <option value="Mercredi" <?php if ($creneau['jour_semaine'] == 'Mercredi') echo 'selected'; ?>>Mercredi</option>
                        <option value="Jeudi" <?php if ($creneau['jour_semaine'] == 'Jeudi') echo 'selected'; ?>>Jeudi</option>
                        <option value="Vendredi" <?php if ($creneau['jour_semaine'] == 'Vendredi') echo 'selected'; ?>>Vendredi</option>
                        <option value="Samedi" <?php if ($creneau['jour_semaine'] == 'Samedi') echo 'selected'; ?>>Samedi</option>
                        <option value="Dimanche" <?php if ($creneau['jour_semaine'] == 'Dimanche') echo 'selected'; ?>>Dimanche</option>
                    </select><br>
                    <label for="heure_debut[]">Heure de début :</label><br>
                    <input type="time" id="heure_debut[]" name="heure_debut[]" value="<?php echo $creneau['heure_debut']; ?>"><br>
                    <label for="heure_fin[]">Heure de fin :</label><br>
                    <input type="time" id="heure_fin[]" name="heure_fin[]" value="<?php echo $creneau['heure_fin']; ?>"><br><br>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="button" onclick="addAvailability()">Ajouter une autre disponibilité</button><br><br>

        <input type="submit" value="Modifier">
    </form>
    <a href="index.php">Retour à la liste des agents</a>
</body>
</html>

