<?php

class SubmissionController {

    private $submissionModel;
    private $commentModel;

    public function __construct() {
        $this->submissionModel = new Submission();
        $this->commentModel = new Comment();
    }

    // 🔹 Liste submissions
    public function index() {

        $submissions = $this->submissionModel->getAll();
    
        require_once __DIR__ . "/../views/Submissions/Index.php";
    }

    // 🔹 Form create
    public function create() {
        $challenges = Challenge::findAll();
        require_once __DIR__ . "/../views/Submissions/Create.php";
    }

    // 🔹 Store submission
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ch = (int)($_POST['challenge_id'] ?? 1);
            $id_user = (int)($_SESSION['user_id'] ?? 0);

            if ($id_user === 0) {
                header("Location: index.php?url=login");
                exit();
            }

            $description = $_POST['description'];
            $image_path = null;

            if (!empty($_FILES['image']['name'])) {
                $uploadResult = $this->uploadImage();
                if (is_string($uploadResult) && strpos($uploadResult, '/') === 0) {
                    $image_path = $uploadResult;
                } else {
                    // Erreur d'upload - on pourrait rediriger avec un message
                    header("Location: index.php?url=submission/create&challenge_id=$id_ch&error=" . urlencode($uploadResult));
                    exit();
                }
            }

            $this->submissionModel->create(
                $id_ch,
                $id_user,
                $description,
                $image_path
            );

            header("Location: index.php?url=challenge/view&id=" . $id_ch . "&msg=submitted");
            exit();
        }
    }

    // 🔹 Show submission
    public function show() {

        if (isset($_GET['id'])) {
    
            $id_sub = (int)$_GET['id'];
    
            $submission = $this->submissionModel->getById($id_sub);
            $comments = $this->commentModel->getBySubmission($id_sub);

            // Fetch vote details
            $voteModel = new Vote(Database::getInstance()->getConnection());
            $voteCount = $voteModel->countVotes($id_sub)['total'];
            $hasVoted = false;
            if (isset($_SESSION['user_id'])) {
                $hasVoted = $voteModel->checkUserVote($_SESSION['user_id'], $id_sub) > 0;
            }
    
            require_once __DIR__ . "/../views/Submissions/Show.php";
        }
    }

    // 🔹 Ajouter commentaire
    public function addComment() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(isset($_POST['submission_id']) && isset($_POST['content'])) {

                $id_sub = (int)$_POST['submission_id'];
                $id_user = (int)($_SESSION['user_id'] ?? 0);
                
                if ($id_user === 0) {
                    header("Location: index.php?url=login");
                    exit();
                }

                $content = $_POST['content'];

                $this->commentModel->create(
                    $id_sub,
                    $id_user,
                    $content
                );
            }

            header("Location: index.php?url=submission/view&id=" . $id_sub);
            exit();
        }
    }

    // 🔹 Supprimer submission
    public function deleteSubmission() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $submission = $this->submissionModel->getById($id);

            if (!$submission) {
                header("Location: index.php?url=submissions");
                exit();
            }

            $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
            if ((int)$submission->getIdUser() !== (int)($_SESSION['user_id'] ?? 0) && !$isAdmin) {
                http_response_code(403);
                echo "<h1>403 - Accès non autorisé</h1>";
                exit;
            }

            $this->submissionModel->delete($id);

            header("Location: index.php?url=submissions&msg=deleted");
            exit();
        }
    }

    // 🔹 Classement des participations
    public function ranking() {
        $ranking = $this->submissionModel->getRanking(20);
        require_once __DIR__ . "/../views/Submissions/Ranking.php";
    }

    // 🔹 Form edit
    public function edit() {
        if (isset($_GET['id'])) {
            $id_sub = (int)$_GET['id'];
            $submission = $this->submissionModel->getById($id_sub);
            
            // Vérification simple
            if (!$submission || (int)$submission->getIdUser() !== (int)($_SESSION['user_id'] ?? 0)) {
                header("Location: index.php?url=submissions");
                exit();
            }

            require_once __DIR__ . "/../views/Submissions/Edit.php";
        }
    }

    // 🔹 Update submission action
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sub'])) {
            $id_sub = (int)$_POST['id_sub'];
            $submission = $this->submissionModel->getById($id_sub);

            if (!$submission || (int)$submission->getIdUser() !== (int)($_SESSION['user_id'] ?? 0)) {
                header("Location: index.php?url=submissions");
                exit();
            }

            $description = $_POST['description'];
            $image_path = $submission->getImage();

            if (!empty($_FILES['image']['name'])) {
                $uploadResult = $this->uploadImage();
                if (is_string($uploadResult) && strpos($uploadResult, '/') === 0) {
                    $image_path = $uploadResult;
                }
            }

            $this->submissionModel->update($id_sub, $description, $image_path);

            header("Location: index.php?url=submission/view&id=" . $id_sub . "&msg=updated");
            exit();
        }
    }

    private function uploadImage(): string {
        $targetDir = __DIR__ . "/../../public/uploads/submissions/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $fileName = uniqid() . '-' . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        $relativePath = "/uploads/submissions/" . $fileName;

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

    // 🔹 Supprimer commentaire
    public function deleteComment() {
        if (isset($_GET['id']) && isset($_GET['sub'])) {
            $id = (int)$_GET['id'];
            $id_sub = (int)$_GET['sub'];
            
            $comment = $this->commentModel->getById($id);
            if (!$comment) {
                header("Location: index.php?url=submission/view&id=" . $id_sub);
                exit();
            }

            $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
            if ((int)$comment->getIdUser() !== (int)($_SESSION['user_id'] ?? 0) && !$isAdmin) {
                header("Location: index.php?url=submission/view&id=" . $id_sub . "&msg=auth_error");
                exit();
            }

            $this->commentModel->delete($id);

            header("Location: index.php?url=submission/view&id=" . $id_sub);
            exit();
        }
    }
}
