<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 fw-black text-dark tracking-tight mb-0">Modifier ma participation</h1>
                    <a href="index.php?url=submission/view&id=<?= $submission->getIdSub() ?>" class="btn-close" aria-label="Close"></a>
                </div>

                <form action="index.php?url=submission/update" method="POST" enctype="multipart/form-data" class="needs-validation">
                    <input type="hidden" name="id_sub" value="<?= $submission->getIdSub(); ?>">

                    <div class="mb-4">
                        <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Ma description</label>
                        <textarea name="description" required rows="6" class="form-control rounded-4 p-3 border-light shadow-sm focus-ring" placeholder="Décrivez votre création..."><?= htmlspecialchars($submission->getDescription()); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Changer l'image (Optionnel)</label>
                        <div class="input-group">
                            <input type="file" name="image" class="form-control rounded-4 border-light shadow-sm">
                        </div>
                        <?php if ($submission->getImage()): ?>
                            <div class="mt-3 p-2 bg-light rounded-3 d-flex align-items-center border border-dashed">
                                <i class="bi bi-image text-muted me-2"></i>
                                <span class="text-muted small truncate">Image actuelle : <?= htmlspecialchars(basename($submission->getImage())) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-4 mt-2 border-top border-light">
                        <a href="index.php?url=submission/view&id=<?= $submission->getIdSub() ?>" class="btn btn-link link-secondary text-decoration-none fw-bold text-uppercase small tracking-widest">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary rounded-4 py-3 px-5 fw-black text-uppercase shadow-sm tracking-widest">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
