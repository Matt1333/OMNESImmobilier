<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Bien Immobilier</title>
</head>
<body>
    <h1>Ajouter un Nouveau Bien</h1>
    <form action="ajouter_action.php" method="post" enctype="multipart/form-data">
        <label for="type">Type:</label>
        <select name="type" id="type" required>
            <option value="Immobilier_residentiel">Immobilier Résidentiel</option>
            <option value="Immobilier_commercial">Immobilier Commercial</option>
            <option value="Terrain">Terrain</option>
            <option value="Appartement a louer">Appartement à Louer</option>
        </select><br><br>
        <label for="name">Nom:</label>
        <input type="text" name="name" id="name" required><br><br>
        <label for="number">Numéro:</label>
        <input type="number" name="number" id="number" required><br><br>
        <label for="city">Ville:</label>
        <input type="text" name="city" id="city" required><br><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br><br>
        <label for="adress">Adresse:</label>
        <input type="text" name="adress" id="adress" required><br><br>
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" required><br><br>
        <label for="video">Vidéo:</label>
        <input type="text" name="video" id="video"><br><br>
        <input type="submit" value="Ajouter">
    </form>
    <a href="index.php">Retour à la liste</a>
</body>
</html>
