<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChallengeHub - Plateforme Collaborative de Défis</title>
    <!-- Bootstrap 5 CSS (Local) -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (Local) -->
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .navbar-glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="d-flex flex-column h-100 bg-light">
    <nav class="navbar navbar-expand-lg navbar-glass sticky-top border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <span class="text-primary">ChallengeHub</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=challenges">Défis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=submissions">Participations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=ranking">Classement</a>
                    </li>
                    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-primary" href="index.php?url=admin/dashboard">Administration</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="index.php?url=profile" class="btn btn-outline-secondary btn-sm">Profil</a>
                        <a href="logout.php" class="btn btn-primary btn-sm">Déconnexion</a>
                    <?php else: ?>
                        <a href="index.php?url=login" class="btn btn-outline-secondary btn-sm">Connexion</a>
                        <a href="index.php?url=register" class="btn btn-primary btn-sm">S'inscrire</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="container py-5">
