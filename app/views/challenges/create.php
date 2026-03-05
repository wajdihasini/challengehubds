<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-4 p-3 mb-4 text-primary shadow-sm">
                        <i class="bi bi-plus-circle fs-1"></i>
                    </div>
                    <h2 class="display-6 fw-black text-dark mb-2">Lancer un défi</h2>
                    <p class="text-muted small">Inspirez d'autres créateurs en proposant un nouveau challenge.</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-5 p-4 animate-pulse">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-octagon-fill me-2 fs-5"></i>
                            <p class="mb-0 fw-bold small text-uppercase tracking-widest">Oups ! Des erreurs sont survenues :</p>
                        </div>
                        <ul class="list-unstyled mb-0 small ps-4">
                            <?php foreach ($errors as $err): ?>
                                <li class="mb-1"><i class="bi bi-dot me-1"></i><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="index.php?url=challenge/create" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Titre du défi <span class="text-primary">*</span></label>
                        <input type="text" name="titre" required value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" placeholder="Ex: Illustration Cyberpunk de Printemps" class="form-control rounded-3 p-3 border-light shadow-sm focus-ring">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Description détaillée <span class="text-primary">*</span></label>
                        <textarea name="description" required rows="6" placeholder="Expliquez les règles, le thème et ce que vous attendez des participations..." class="form-control rounded-3 p-3 border-light shadow-sm focus-ring"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Catégorie <span class="text-primary">*</span></label>
                            <select name="categorie" required class="form-select rounded-3 p-3 border-light shadow-sm focus-ring">
                                <option value="">-- Choisir une catégorie --</option>
                                <option value="Art" <?= ($_POST['categorie']??'') === 'Art' ? 'selected' : '' ?>>Art</option>
                                <option value="Photo" <?= ($_POST['categorie']??'') === 'Photo' ? 'selected' : '' ?>>Photo</option>
                                <option value="Musique" <?= ($_POST['categorie']??'') === 'Musique' ? 'selected' : '' ?>>Musique</option>
                                <option value="Écriture" <?= ($_POST['categorie']??'') === 'Écriture' ? 'selected' : '' ?>>Écriture</option>
                                <option value="Autre" <?= ($_POST['categorie']??'') === 'Autre' ? 'selected' : '' ?>>Autre</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Date limite <span class="text-primary">*</span></label>
                            <input type="date" name="date_limite" required value="<?= htmlspecialchars($_POST['date_limite'] ?? '') ?>" class="form-control rounded-3 p-3 border-light shadow-sm focus-ring">
                        </div>
                    </div>

                    <div class="bg-light border border-dashed rounded-4 p-5 mb-5 text-center group transition">
                        <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-4 d-block">Illustration du défi (facultatif)</label>
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-image text-muted fs-1 mb-3 group-hover-text-primary transition"></i>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/gif" class="form-control rounded-3 border-light shadow-sm max-w-md mx-auto">
                        </div>
                        <p class="mt-4 text-muted small text-uppercase tracking-widest fw-bold" style="font-size: 0.65rem;">JPG, PNG ou GIF (max. 5 Mo)</p>
                    </div>

                    <div class="pt-4 border-top border-light d-flex align-items-center justify-content-between">
                        <a href="index.php?url=challenges" class="btn btn-link link-secondary text-decoration-none fw-bold text-uppercase small tracking-widest">
                            <i class="bi bi-x-lg me-1"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary rounded-4 py-3 px-5 fw-black text-uppercase shadow-sm tracking-widest bg-gradient">
                            Publier le défi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
