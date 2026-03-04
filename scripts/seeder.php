<?php
require_once __DIR__ . '/../app/core/Autoload.php';

echo "--- ChallengeHub Seeder ---\n";
// Ce script va  insérer des données aleatoirement pour test pour les utilisateurs, défis, participations, commentaires et votes. 
try {
    $db = Database::getInstance()->getConnection();


    echo "Nettoyage de la base de données...\n";
    $db->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $db->exec("TRUNCATE TABLE votes;");
    $db->exec("TRUNCATE TABLE comments;");
    $db->exec("TRUNCATE TABLE submissions;");
    $db->exec("TRUNCATE TABLE challenges;");
    $db->exec("TRUNCATE TABLE users;");
    $db->exec("SET FOREIGN_KEY_CHECKS = 1;");


    echo "Création des utilisateurs...\n";
    $users = [
        ['Jean', 'Dupont', 'jean@example.com', 'M', '1990-05-15', 'Paris', password_hash('password123', PASSWORD_DEFAULT)],
        ['Marie', 'Curie', 'marie@example.com', 'F', '1992-08-22', 'Lyon', password_hash('password123', PASSWORD_DEFAULT)],
        ['Paul', 'Martin', 'paul@example.com', 'M', '1988-12-01', 'Marseille', password_hash('password123', PASSWORD_DEFAULT)],
        ['Alice', 'Durand', 'alice@example.com', 'F', '1995-03-10', 'Bordeaux', password_hash('password123', PASSWORD_DEFAULT)],
    ];

    $stmt = $db->prepare("INSERT INTO users (nom, prenom, email, sexe, date_naissance, adresse, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($users as $user) {
        $stmt->execute($user);
    }
    $userCount = count($users);
    echo "$userCount utilisateurs créés.\n";

 
    echo "Création des défis...\n";
    $challenges = [
        [1, 'Défi Photo : Nature Urbaine', 'Capturez la nature au cœur de la ville.', 'Photo', '2026-04-30', null],
        [2, 'Concours de Dessin : Cyberpunk', 'Imaginez le monde en 2077.', 'Dessin', '2026-05-15', null],
        [1, 'Défi Musique : Jazz Lo-Fi', 'Composez un morceau relaxant de 2 minutes.', 'Musique', '2026-06-01', null],
        [3, 'Street Art Challenge', 'Recréez une œuvre célèbre sur un mur imaginaire.', 'Art', '2026-05-20', null],
    ];

    $stmt = $db->prepare("INSERT INTO challenges (user_id, titre, description, categorie, date_limite, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($challenges as $ch) {
        $stmt->execute($ch);
    }
    echo "4 défis créés.\n";

 
    echo "Création des participations...\n";
    $submissions = [
        [1, 2, 'Un arbre qui pousse à travers le béton.', null],
        [1, 3, 'Le parc abandonné sous la pluie.', null],
        [2, 1, 'Architecture néon et voitures volantes.', null],
        [2, 4, 'Un portrait de robot mélancolique.', null],
        [3, 2, 'Beat de jazz avec des samples de pluie.', null],
        [4, 1, 'Monalisa version graffiti.', null],
    ];

    $stmt = $db->prepare("INSERT INTO submissions (id_ch, id_user, description, image) VALUES (?, ?, ?, ?)");
    foreach ($submissions as $sub) {
        $stmt->execute($sub);
    }
    echo "6 participations créées.\n";


    echo "Création des commentaires...\n";
    $comments = [
        [1, 1, 'Superbe composition !'],
        [1, 3, 'J\'adore les contrastes de couleurs.'],
        [3, 1, 'Très futuriste, bravo.'],
        [6, 2, 'Un style vraiment unique.'],
    ];

    $stmt = $db->prepare("INSERT INTO comments (id_sub, id_user, content) VALUES (?, ?, ?)");
    foreach ($comments as $com) {
        $stmt->execute($com);
    }
    echo "4 commentaires créés.\n";


    echo "Création des votes...\n";
    $votes = [
        [1, 1], [1, 2], [1, 3], // 3 votes pour sub 1
        [2, 1], [2, 4],         // 2 votes pour sub 2
        [3, 3], [3, 2],         // 2 votes pour sub 3
        [4, 1],                 // 1 vote pour sub 4
        [5, 4], [5, 1],         // 2 votes pour sub 5
        [6, 3],                 // 1 vote pour sub 6
    ];

    $stmt = $db->prepare("INSERT INTO votes (submission_id, user_id) VALUES (?, ?)");
    foreach ($votes as $vote) {
        $stmt->execute($vote);
    }
    echo count($votes) . " votes créés.\n";

    echo "--- Seeding terminé avec succès ! ---\n";

} catch (Exception $e) {
    die("ERREUR lors du seeding : " . $e->getMessage() . "\n");
}
