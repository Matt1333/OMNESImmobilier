<?php
// Vérifie si un ID est passé en paramètre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $agent_id = (int) $_GET['id']; // Convertit l'ID en entier

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'maison');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Commence une transaction
    $conn->begin_transaction();

    try {
        // Supprime les enregistrements associés dans creneaux_disponibles
        $stmt_creneaux = $conn->prepare("DELETE FROM creneaux_disponibles WHERE agent_id = ?");
        $stmt_creneaux->bind_param("i", $agent_id);
        if (!$stmt_creneaux->execute()) {
            throw new Exception("Erreur lors de la suppression des créneaux disponibles : " . $stmt_creneaux->error);
        }

        // Suppression de l'agent de la base de données
        $stmt_agent = $conn->prepare("DELETE FROM Agent WHERE ID = ?");
        $stmt_agent->bind_param("i", $agent_id);
        if (!$stmt_agent->execute()) {
            throw new Exception("Erreur lors de la suppression de l'agent : " . $stmt_agent->error);
        }

        // Valide la transaction
        $conn->commit();
        echo "Agent supprimé avec succès.";
    } catch (Exception $e) {
        // Annule la transaction en cas d'erreur
        $conn->rollback();
        echo $e->getMessage();
    }

    $stmt_creneaux->close();
    $stmt_agent->close();
    $conn->close();
} else {
    echo "Aucun ID d'agent spécifié ou l'ID est invalide.";
}
?>

<!-- Formulaire pour revenir à la page d'accueil -->
<form action="index.php">
    <input type="submit" value="Retour à la page d'accueil">
</form>

