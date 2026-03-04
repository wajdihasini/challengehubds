<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Back Link -->
        <a href="index.php?url=challenges" class="btn btn-link text-primary p-0 mb-4 text-decoration-none fw-bold">
            <i class="bi bi-arrow-left me-2"></i> Retour à la liste des défis
        </a>

        <!-- Main Challenge Card -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
            <div class="position-relative" style="height: 400px; background-color: #000;">
                <?php if ($challenge->getImagePath()): ?>
                    <img src="<?= htmlspecialchars($challenge->getImagePath()) ?>" class="w-100 h-100 object-cover opacity-75" style="object-fit: cover;">
                <?php else: ?>
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark">
                        <i class="bi bi-image text-secondary opacity-25" style="font-size: 5rem;"></i>
                    </div>
                <?php endif; ?>
                <div class="position-absolute bottom-0 start-0 w-100 p-4 p-md-5 bg-gradient-to-t" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                    <span class="badge bg-primary text-uppercase mb-3 px-3 py-2">
                        <?= htmlspecialchars($challenge->getCategorie()) ?>
                    </span>
                    <h1 class="display-4 fw-black text-white mb-0">
                        <?= htmlspecialchars($challenge->getTitre()) ?>
                    </h1>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <section>
                            <h2 class="h4 fw-bold text-dark mb-4 d-flex align-items-center">
                                <i class="bi bi-text-left text-primary me-2"></i> Description du défi
                            </h2>
                            <div class="text-secondary lead lh-base">
                                <?= nl2br(htmlspecialchars($challenge->getDescription())) ?>
                            </div>
                        </section>
                    </div>

                    <div class="col-lg-4">
                        <div class="card bg-light border-0 rounded-4 p-4 mb-4">
                            <h3 class="small fw-bold text-muted text-uppercase tracking-widest mb-4">Détails de l'événement</h3>
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-white rounded-3 shadow-sm me-3 text-primary">
                                        <i class="bi bi-calendar-event"></i>
                                    </div>
                                    <div>
                                        <p class="small text-muted mb-0">Date limite</p>
                                        <p class="fw-bold text-dark mb-0"><?= htmlspecialchars($challenge->getDateLimite()) ?></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start">
                                    <div class="p-2 bg-white rounded-3 shadow-sm me-3 text-success">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div>
                                        <p class="small text-muted mb-0">Publié le</p>
                                        <p class="fw-bold text-dark mb-0"><?= htmlspecialchars($challenge->getCreatedAt()) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php 
                        $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                        if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] === $challenge->getUserId() || $isAdmin)): ?>
                            <div class="d-grid gap-2">
                                <?php if ($_SESSION['user_id'] === $challenge->getUserId()): ?>
                                    <a href="index.php?url=challenge/edit&id=<?= $challenge->getId() ?>" class="btn btn-outline-dark rounded-3">
                                        <i class="bi bi-pencil-square me-2"></i> Modifier ce défi
                                    </a>
                                <?php endif; ?>
                                <form action="index.php?url=challenge/delete&id=<?= $challenge->getId() ?>" method="POST" class="w-100">
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr ?')" class="btn btn-outline-danger w-100 rounded-3">
                                        <i class="bi bi-trash me-2"></i> Supprimer le défi
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Participations -->
        <div class="card border-0 bg-light rounded-4 p-4 p-md-5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
                <h2 class="h2 fw-black text-dark mb-0">Participations</h2>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="index.php?url=submission/create&challenge_id=<?= $challenge->getId() ?>" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                        <i class="bi bi-plus-circle me-2"></i> Participer maintenant
                    </a>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($submissions)) : ?>
                <div class="row g-4">
                    <?php foreach ($submissions as $sub) : ?>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-shrink-0 bg-light rounded-3 overflow-hidden" style="width: 80px; height: 80px;">
                                        <?php if($sub['image']): ?>
                                            <img src="<?= htmlspecialchars($sub['image']) ?>" class="w-100 h-100 object-cover">
                                        <?php else: ?>
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center opacity-25">
                                                <i class="bi bi-image fs-1"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <p class="fw-bold text-dark mb-1 text-truncate">
                                            <?= htmlspecialchars($sub['description']) ?>
                                        </p>
                                        <p class="small text-muted text-uppercase tracking-wider mb-2" style="font-size: 0.65rem;">
                                            Par <?= htmlspecialchars($sub['user_prenom'] . ' ' . $sub['user_nom']) ?>
                                        </p>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="small fw-bold text-primary d-flex align-items-center">
                                                <i class="bi bi-hand-thumbs-up-fill me-1"></i> <?= $sub['vote_count'] ?> votes
                                            </span>
                                            <?php if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] !== (int)$sub['id_user']): ?>
                                                <a href="index.php?url=vote&id=<?= $sub['id_sub'] ?>&ch=<?= $challenge->getId() ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 0.65rem;">
                                                    Voter
                                                </a>
                                            <?php endif; ?>
                                            <a href="index.php?url=submission/view&id=<?= $sub['id_sub'] ?>" class="btn btn-sm btn-link text-muted p-0 text-decoration-none fw-bold" style="font-size: 0.65rem;">
                                                Détails <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="text-center py-5">
                    <p class="text-muted fst-italic mb-0">Aucune participation pour le moment. Soyez le premier !</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>