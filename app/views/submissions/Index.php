<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row g-4 mb-5 align-items-center">
    <div class="col-md-8">
        <h1 class="display-5 fw-bold text-dark">Participations</h1>
        <p class="lead text-secondary">Découvrez les créations de la communauté ChallengeHub.</p>
    </div>
    <div class="col-md-4 d-flex justify-content-md-end">
        <a href="index.php?url=submission/create" class="btn btn-primary btn-lg shadow-sm rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i> Ajouter une participation
        </a>
    </div>
</div>

<?php if (!empty($submissions)) : ?>
    <div class="row g-4">
        <?php foreach ($submissions as $submission) : ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all">
                    <div class="position-relative" style="height: 250px;">
                        <?php if(!empty($submission['image'])) : ?>
                            <img src="<?= htmlspecialchars($submission['image']); ?>" class="w-100 h-100 object-cover">
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary-subtle opacity-25">
                                <i class="bi bi-image" style="font-size: 4rem;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center opacity-0 hover-opacity-100 transition-all" style="background: rgba(0,0,0,0.5);">
                             <a href="index.php?url=submission/view&id=<?= $submission['id_sub']; ?>" class="btn btn-light fw-bold rounded-pill px-4">
                                Voir les détails
                             </a>
                        </div>
                    </div>

                    <div class="card-body p-4 d-flex flex-col">
                        <div class="mb-2">
                            <span class="badge bg-secondary-subtle text-secondary text-uppercase tracking-widest" style="font-size: 0.6rem;">Submission #<?= $submission['id_sub'] ?></span>
                        </div>
                        <p class="card-text text-secondary mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= htmlspecialchars($submission['description']); ?>
                        </p>
                        
                        <hr class="text-light-subtle">
                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <a href="index.php?url=submission/view&id=<?= $submission['id_sub']; ?>" class="btn btn-link text-primary fw-bold text-decoration-none p-0 small">
                                Plus d'infos <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                            
                            <?php 
                            $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                            if ((isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$submission['id_user']) || $isAdmin): ?>
                                <a href="index.php?url=submission/delete&id=<?= $submission['id_sub']; ?>" onclick="return confirm('Supprimer cette participation ?')" class="btn btn-link text-muted p-0 hover-text-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <div class="text-center py-5 bg-white rounded-4 border border-2 border-dashed border-light-subtle">
        <h3 class="fw-bold text-muted mb-0">Aucune participation pour le moment.</h3>
    </div>
<?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>