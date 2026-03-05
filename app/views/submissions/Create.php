<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 p-4 p-md-5 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h1 class="h3 fw-black text-dark mb-0">Soumettre une participation</h1>
                    <a href="index.php?url=submissions" class="btn-close" aria-label="Close"></a>
                </div>
            </div>
            <div class="card-body p-4 p-md-5">
                <form action="index.php?url=submission/store" method="POST" enctype="multipart/form-data">
                    <?php if(isset($_GET['challenge_id'])): ?>
                        <input type="hidden" name="challenge_id" value="<?= htmlspecialchars($_GET['challenge_id']) ?>">
                        <div class="alert alert-primary d-flex align-items-center rounded-3 border-0 mb-4 py-3">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>Défi sélectionné #<?= htmlspecialchars($_GET['challenge_id']) ?></div>
                        </div>
                    <?php else: ?>
                        <div class="mb-4">
                            <label class="form-label small fw-black text-muted text-uppercase tracking-widest mb-3">Choisir un défi</label>
                            <select name="challenge_id" required class="form-select form-select-lg rounded-3">
                                <option value="" disabled selected>Sélectionnez le défi auquel vous participez...</option>
                                <?php if (!empty($challenges)): ?>
                                    <?php foreach ($challenges as $ch): ?>
                                        <option value="<?= $ch->getId() ?>"><?= htmlspecialchars($ch->getTitre()) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label small fw-black text-muted text-uppercase tracking-widest mb-3">Description de votre œuvre</label>
                        <textarea name="description" required rows="6" placeholder="Racontez-nous l'histoire de votre création..." class="form-control rounded-3"></textarea>
                    </div>

                    <div class="mb-5">
                        <label class="form-label small fw-black text-muted text-uppercase tracking-widest mb-3">Votre création (Image)</label>
                        <input type="file" name="image" required class="form-control form-control-lg rounded-3">
                    </div>

                    <div class="d-grid">
                        <button type="submit" onclick="return confirm('Confirmer votre participation ?')" class="btn btn-primary btn-lg rounded-3 fw-black text-uppercase tracking-widest py-3 shadow">
                            Publier ma participation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>