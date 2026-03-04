<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row g-4 mb-5">
    <div class="col-md-8">
        <h1 class="display-5 fw-bold text-dark">Défis Créatifs</h1>
        <p class="lead text-secondary">Relevez le défi, partagez votre talent et votez pour les meilleurs.</p>
    </div>
    <div class="col-md-4 d-flex align-items-center justify-content-md-end">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?url=challenge/create" class="btn btn-primary btn-lg shadow">
                <i class="bi bi-plus-lg me-2"></i> Créer un défi
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Filtres et Recherche -->
<div class="card border-0 shadow-sm mb-5">
    <div class="card-body p-4">
        <form method="GET" action="index.php" class="row g-3">
            <input type="hidden" name="url" value="challenges">
            <div class="col-md-5">
                <label class="form-label small fw-bold text-muted text-uppercase">Rechercher</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Titre, description..." class="form-control border-start-0 ps-0">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Catégorie</label>
                <select name="category" class="form-select">
                    <option value="">Toutes</option>
                    <option value="Art" <?= ($_GET['category']??'') === 'Art' ? 'selected' : '' ?>>Art</option>
                    <option value="Photo" <?= ($_GET['category']??'') === 'Photo' ? 'selected' : '' ?>>Photo</option>
                    <option value="Musique" <?= ($_GET['category']??'') === 'Musique' ? 'selected' : '' ?>>Musique</option>
                    <option value="Écriture" <?= ($_GET['category']??'') === 'Écriture' ? 'selected' : '' ?>>Écriture</option>
                    <option value="Autre" <?= ($_GET['category']??'') === 'Autre' ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted text-uppercase">Trier par</label>
                <select name="sort" class="form-select">
                    <option value="newest" <?= ($_GET['sort']??'') === 'newest' ? 'selected' : '' ?>>Plus récents</option>
                    <option value="popular" <?= ($_GET['sort']??'') === 'popular' ? 'selected' : '' ?>>Plus populaires</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-dark w-100">Filtrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Messages Flash -->
<?php
$msg = $_GET['msg'] ?? '';
if ($msg): ?>
    <div class="alert <?= strpos($msg, 'success') !== false ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi <?= strpos($msg, 'success') !== false ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?> me-2"></i>
            <div>
                <?php 
                    if ($msg === 'create_success') echo "Le défi a été publié avec succès !";
                    elseif ($msg === 'edit_success') echo "Le défi a été mis à jour.";
                    elseif ($msg === 'delete_success') echo "Le défi a été supprimé.";
                ?>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Liste des Défis -->
<?php if (empty($challenges)): ?>
    <div class="text-center py-5 bg-white rounded-4 border border-2 border-dashed border-light-subtle">
        <div class="display-1 text-muted mb-3"><i class="bi bi-folder-x"></i></div>
        <h3 class="fw-bold text-dark">Aucun défi</h3>
        <p class="text-secondary">Soyez le premier à lancer un défi à la communauté.</p>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($challenges as $challenge): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-shadow transition-all border-0 rounded-4 overflow-hidden">
                    <div class="position-relative h-200">
                        <?php if ($challenge->getImagePath()): ?>
                            <img src="<?= htmlspecialchars($challenge->getImagePath()) ?>" class="card-img-top w-100 h-100 object-cover" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary-subtle d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image text-secondary opacity-25" style="font-size: 4rem;"></i>
                            </div>
                        <?php endif; ?>
                        <div class="position-absolute top-0 start-0 p-3">
                            <span class="badge bg-white text-primary shadow-sm text-uppercase">
                                <?= htmlspecialchars($challenge->getCategorie()) ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title fw-bold mb-2">
                            <?= htmlspecialchars($challenge->getTitre()) ?>
                        </h5>
                        <p class="card-text text-secondary mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= nl2br(htmlspecialchars($challenge->getDescription())) ?>
                        </p>
                        <hr class="text-light-subtle">
                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <div class="small">
                                <span class="d-block text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Expire le</span>
                                <span class="fw-bold text-dark"><?= htmlspecialchars($challenge->getDateLimite()) ?></span>
                            </div>
                            <a href="index.php?url=challenge/view&id=<?= $challenge->getId() ?>" class="btn btn-link text-primary fw-bold text-decoration-none p-0">
                                Voir plus <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>