<?php

class AdminController {

    private $userModel;

    public function __construct() {
        $this->checkAdmin();
        $this->userModel = new User();
    }

    private function checkAdmin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=login");
            exit;
        }

        $userModel = new User();
        if (!$userModel->isAdmin($_SESSION['user_id'])) {
            http_response_code(403);
            die("Accès interdit - Droits administrateur requis");
        }
    }

    public function dashboard() {
        $stats = [
            'users' => count($this->userModel->findAll() ?? []), // Need findAll in models if not present
            'challenges' => count(Challenge::findAll() ?? []),
            'submissions' => count((new Submission())->getAll() ?? []),
        ];
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    // --- User Management ---
    public function users() {
        $users = $this->userModel->findAll();
        require __DIR__ . '/../views/admin/users/list.php';
    }

    public function editUser($id) {
        $user = $this->userModel->findById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->update($id, [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'sexe' => $_POST['sexe'],
                'date_naissance' => $_POST['date_naissance'],
                'adresse' => $_POST['adresse'],
                'role' => $_POST['role']
            ]);
            header("Location: index.php?url=admin/users");
            exit;
        }
        require __DIR__ . '/../views/admin/users/edit.php';
    }

    public function deleteUser($id) {
        $this->userModel->delete($id);
        header("Location: index.php?url=admin/users");
        exit;
    }

    // --- Challenge Management ---
    public function challenges() {
        $challenges = Challenge::findAll();
        require __DIR__ . '/../views/admin/challenges/list.php';
    }

    public function deleteChallenge($id) {
        Challenge::delete($id, null); // Allow admin delete without owner check if modified
        header("Location: index.php?url=admin/challenges");
        exit;
    }

    // --- Submission Management ---
    public function submissions() {
        $submissionModel = new Submission();
        $submissions = $submissionModel->getAll();
        require __DIR__ . '/../views/admin/submissions/list.php';
    }

    public function deleteSubmission($id) {
        $submissionModel = new Submission();
        $submissionModel->delete($id);
        header("Location: index.php?url=admin/submissions");
        exit;
    }

    // --- Comment Management ---
    public function comments() {
        $commentModel = new Comment();
        $comments = $commentModel->getAll();
        require __DIR__ . '/../views/admin/comments/list.php';
    }

    public function deleteComment($id) {
        $commentModel = new Comment();
        $commentModel->delete($id);
        header("Location: index.php?url=admin/comments");
        exit;
    }

    // --- Vote Management ---
    public function votes() {
        $voteModel = new Vote(Database::getInstance()->getConnection());
        $votes = $voteModel->getAll();
        require __DIR__ . '/../views/admin/votes/list.php';
    }

    public function deleteVote($id) {
        $voteModel = new Vote(Database::getInstance()->getConnection());
        $voteModel->delete($id);
        header("Location: index.php?url=admin/votes");
        exit;
    }
}
