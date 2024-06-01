CREATE TABLE creneaux_disponibles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT,
    jour_semaine ENUM('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'),
    heure_debut TIME,
    heure_fin TIME,
    CONSTRAINT fk_agent FOREIGN KEY (agent_id) REFERENCES Agent(ID)
);