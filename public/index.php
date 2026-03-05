<?php
session_start();

// CSRF Protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Autoloading
require_once __DIR__ . '/../app/core/Autoload.php';

$url = $_GET['url'] ?? 'challenges'; // Par défaut, on affiche les défis

// Initialisation des contrôleurs
$userCtrl = new UserController();
$challengeCtrl = new ChallengeController();
$submissionCtrl = new SubmissionController();

// Database initialization
$db = Database::getInstance()->getConnection();
$voteCtrl = new VoteController($db);

switch ($url) {
    // --- Utilisateurs ---
    case 'register': require __DIR__ . '/../app/views/users/register.php'; break;
    case 'registerAction': $userCtrl->register(); break;
    case 'login': require __DIR__ . '/../app/views/users/login.php'; break;
    case 'loginAction': $userCtrl->login(); break;
    case 'logout': require __DIR__ . '/logout.php'; break;
    case 'profile': $userCtrl->profile(); break;
    case 'edit-profile': $userCtrl->edit(); break;
    case 'update-profile': $userCtrl->update(); break;
    case 'delete-user': $userCtrl->delete(); break;

    // --- Administration ---
    case 'admin/dashboard': (new AdminController())->dashboard(); break;
    case 'admin/users': (new AdminController())->users(); break;
    case 'admin/user/edit': (new AdminController())->editUser($_GET['id'] ?? 0); break;
    case 'admin/user/delete': (new AdminController())->deleteUser($_GET['id'] ?? 0); break;
    case 'admin/challenges': (new AdminController())->challenges(); break;
    case 'admin/challenge/delete': (new AdminController())->deleteChallenge($_GET['id'] ?? 0); break;
    case 'admin/submissions': (new AdminController())->submissions(); break;
    case 'admin/submission/delete': (new AdminController())->deleteSubmission($_GET['id'] ?? 0); break;
    case 'admin/comments': (new AdminController())->comments(); break;
    case 'admin/comment/delete': (new AdminController())->deleteComment($_GET['id'] ?? 0); break;
    case 'admin/votes': (new AdminController())->votes(); break;
    case 'admin/vote/delete': (new AdminController())->deleteVote($_GET['id'] ?? 0); break;

    // --- Défis (Challenges) ---
    case 'challenges': $challengeCtrl->index(); break;
    case 'challenge/view': $challengeCtrl->view((int)($_GET['id'] ?? 0)); break;
    case 'challenge/create': $challengeCtrl->create(); break;
    case 'challenge/edit': $challengeCtrl->edit((int)($_GET['id'] ?? 0)); break;
    case 'challenge/delete': $challengeCtrl->delete((int)($_GET['id'] ?? 0)); break;

    // --- Participations (Submissions) ---
    case 'ranking': $submissionCtrl->ranking(); break;
    case 'submissions': $submissionCtrl->index(); break;
    case 'submission/view': $submissionCtrl->show(); break;
    case 'submission/create': $submissionCtrl->create(); break;
    case 'submission/store': $submissionCtrl->store(); break;
    case 'submission/edit': $submissionCtrl->edit(); break;
    case 'submission/update': $submissionCtrl->update(); break;
    case 'submission/delete': $submissionCtrl->deleteSubmission(); break;
    
    // --- Commentaires ---
    case 'submission/comment': $submissionCtrl->addComment(); break;
    case 'submission/deleteComment': $submissionCtrl->deleteComment(); break;

    // --- Votes ---
    case 'vote': $voteCtrl->vote(); break;

    // --- API v1 ---
    case 'api/challenges': (new ChallengeApiController())->list(); break;
    case 'api/challenge': (new ChallengeApiController())->view(); break;
    case 'api/submission/stats': (new SubmissionApiController())->stats(); break;
    case 'api/submissions/ranking': (new SubmissionApiController())->ranking(); break;

    default:
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
        break;
}
