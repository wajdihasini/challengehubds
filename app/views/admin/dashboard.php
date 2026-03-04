<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="mb-5 d-flex justify-content-between align-items-center">
    <h1 class="display-6 fw-bold text-dark tracking-tight">Tableau de bord Administrateur</h1>
</div>

<div class="row g-4 mb-5">
    <!-- Utilisateurs Stats Card -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-gradient rounded-3 p-3">
                        <i class="bi bi-people text-white fs-4"></i>
                    </div>
                    <div class="ms-4">
                        <p class="text-muted small text-uppercase fw-bold mb-1">Utilisateurs</p>
                        <h2 class="fw-black text-dark mb-0"><?php echo $stats['users']; ?></h2>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-0 px-4 py-3">
                <a href="index.php?url=admin/users" class="small fw-bold text-primary text-decoration-none d-flex align-items-center">
                    Gérer les utilisateurs <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Défis Stats Card -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success bg-gradient rounded-3 p-3">
                        <i class="bi bi-trophy text-white fs-4"></i>
                    </div>
                    <div class="ms-4">
                        <p class="text-muted small text-uppercase fw-bold mb-1">Défis</p>
                        <h2 class="fw-black text-dark mb-0"><?php echo $stats['challenges']; ?></h2>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-0 px-4 py-3">
                <a href="index.php?url=admin/challenges" class="small fw-bold text-success text-decoration-none d-flex align-items-center">
                    Gérer les défis <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Participations Stats Card -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-warning bg-gradient rounded-3 p-3">
                        <i class="bi bi-check-circle text-white fs-4"></i>
                    </div>
                    <div class="ms-4">
                        <p class="text-muted small text-uppercase fw-bold mb-1">Participations</p>
                        <h2 class="fw-black text-dark mb-0"><?php echo $stats['submissions']; ?></h2>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-0 px-4 py-3">
                <a href="index.php?url=admin/submissions" class="small fw-bold text-warning text-decoration-none d-flex align-items-center">
                    Gérer les participations <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Feedback Management -->
    <div class="col-md-6">
        <a href="index.php?url=admin/comments" class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden text-decoration-none hover-shadow transition-all border-hover-primary">
            <div class="card-body p-4">
                <div class="bg-primary-subtle rounded-3 d-inline-block p-3 mb-3">
                    <i class="bi bi-chat-dots text-primary fs-3"></i>
                </div>
                <h3 class="h5 fw-bold text-dark">Commentaires</h3>
                <p class="text-muted small mb-0">Modérer les discussions et supprimer les contenus inappropriés.</p>
            </div>
        </a>
    </div>

    <div class="col-md-6">
        <a href="index.php?url=admin/votes" class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden text-decoration-none hover-shadow transition-all border-hover-danger">
            <div class="card-body p-4">
                <div class="bg-danger-subtle rounded-3 d-inline-block p-3 mb-3">
                    <i class="bi bi-heart text-danger fs-3"></i>
                </div>
                <h3 class="h5 fw-bold text-dark">Votes</h3>
                <p class="text-muted small mb-0">Surveiller et gérer l'intégrité des votes sur les participations.</p>
            </div>
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
