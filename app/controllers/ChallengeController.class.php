<?php

class ChallengeController {

    public function index() {
        $search = $_GET['search'] ?? null;
        $category = $_GET['category'] ?? null;
        $sort = $_GET['sort'] ?? 'newest';
        $challenges = Challenge::findAll($search, $category, $sort);
        require __DIR__ . '/../views/challenge/list.php';
    }

    public function create() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: /challengehub/login'); // adjust if needed
                exit;
            }

            $data = [
                'titre'       => trim($_POST['titre'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'categorie'   => trim($_POST['categorie'] ?? ''),
                'date_limite' => trim($_POST['date_limite'] ?? ''),
            ];

            $errors = $this->validate($data);

            $image_path = null;
            $uploadResult = null;
            if (!empty($_FILES['image']['name']) && empty($errors)) {
                $uploadResult = $this->uploadImage();
                // Check if it's a path (starts with /uploads) or an error message
                if (strpos($uploadResult, '/uploads/') === 0) {
                    $image_path = $uploadResult;
                } else {
                    $errors[] = $uploadResult;
                }
            }

            if (empty($errors)) {
                $data['image_path'] = $image_path;
                $success = Challenge::create($data, (int)$_SESSION['user_id']);
                if ($success) {
                    header('Location: index.php?url=challenges&msg=create_success');
                    exit;
                }
                $errors[] = "Erreur lors de l'enregistrement.";
            }
        }

        require __DIR__ . '/../views/challenges/create.php';
    }

    public function edit(int $id) {
        $challenge = Challenge::findById($id);
        if (!$challenge) {
            http_response_code(404);
            echo "<h1>404 - Défi non trouvé</h1>";
            echo "<p><a href=\"/challengehub/challenges\">Retour à la liste</a></p>";
            exit;
        }

        if ($challenge->getUserId() !== (int)($_SESSION['user_id'] ?? 0)) {
            http_response_code(403);
            echo "<h1>403 - Accès non autorisé</h1>";
            echo "<p><a href=\"/challengehub/challenges\">Retour à la liste</a></p>";
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre'       => trim($_POST['titre'] ?? $challenge->getTitre()),
                'description' => trim($_POST['description'] ?? $challenge->getDescription()),
                'categorie'   => trim($_POST['categorie'] ?? $challenge->getCategorie()),
                'date_limite' => trim($_POST['date_limite'] ?? $challenge->getDateLimite()),
            ];

            $errors = $this->validate($data);

            $image_path = $challenge->getImagePath();
            $uploadResult = null;
            if (!empty($_FILES['image']['name'])) {
                $uploadResult = $this->uploadImage();
                if (strpos($uploadResult, '/uploads/') === 0) {
                    $image_path = $uploadResult;
                } else {
                    $errors[] = $uploadResult;
                }
            }

            if (empty($errors)) {
                $data['image_path'] = $image_path;
                $success = Challenge::update($id, $data, (int)$_SESSION['user_id']);
                if ($success) {
                    header('Location: index.php?url=challenges&msg=edit_success');
                    exit;
                }
                $errors[] = "Erreur lors de la modification.";
            }
        }

        require __DIR__ . '/../views/challenges/edit.php';
    }

    public function delete(int $id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "<h1>405 - Méthode non autorisée</h1>";
            exit;
        }

        $challenge = Challenge::findById($id);
        $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
        if (!$challenge || ($challenge->getUserId() !== (int)($_SESSION['user_id'] ?? 0) && !$isAdmin)) {
            http_response_code(403);
            echo "<h1>403 - Accès non autorisé</h1>";
            exit;
        }

        Challenge::delete($id, (int)$_SESSION['user_id']);
        header('Location: index.php?url=challenges&msg=delete_success');
        exit;
    }

    public function view(int $id) {
        $challenge = Challenge::findById($id);
        if (!$challenge) {
            http_response_code(404);
            echo "<h1>404 - Défi non trouvé</h1>";
            echo "<p><a href=\"/challengehub/challenges\">Retour à la liste</a></p>";
            exit;
        }

        // Récupérer les participations
        $submissionModel = new Submission();
        $submissions = $submissionModel->getByChallenge($id);

        require __DIR__ . '/../views/challenges/view.php';
    }

    private function validate(array $data): array {
        $errors = [];

        if (empty($data['titre']) || strlen($data['titre']) < 3) {
            $errors[] = "Le titre doit contenir au moins 3 caractères.";
        }
        if (empty($data['description']) || strlen($data['description']) < 10) {
            $errors[] = "La description doit contenir au moins 10 caractères.";
        }
        if (empty($data['categorie'])) {
            $errors[] = "La catégorie est obligatoire.";
        }
        if (empty($data['date_limite']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['date_limite'])) {
            $errors[] = "Date limite invalide (format AAAA-MM-JJ).";
        }

        return $errors;
    }

    private function uploadImage(): string {
        $targetDir = __DIR__ . "/../../public/uploads/challenges/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $fileName = uniqid() . '-' . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        $relativePath = "/uploads/challenges/" . $fileName;

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return "Format non autorisé (jpg, jpeg, png, gif seulement).";
        }

        if ($_FILES["image"]["size"] > 5000000) {
            return "Fichier trop volumineux (max 5 Mo).";
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            return $relativePath;
        }

        return "Échec du téléversement de l'image.";
    }
}