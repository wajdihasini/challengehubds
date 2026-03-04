<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-4 p-3 mb-4 text-primary shadow-sm">
                        <i class="bi bi-pencil-square fs-1"></i>
                    </div>
                    <h2 class="display-6 fw-black text-dark mb-2">Modifier le défi</h2>
                    <p class="text-muted small">Ajustez les détails de votre challenge pour le rendre encore plus attractif.</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-5 p-4">
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

                <form method="post" action="index.php?url=challenge/edit&id=<?= $challenge->getId() ?>" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Titre du défi <span class="text-primary">*</span></label>
                        <input type="text" name="titre" required value="<?= htmlspecialchars($challenge->getTitre()) ?>" class="form-control rounded-3 p-3 border-light shadow-sm focus-ring" placeholder="Titre du défi">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Description détaillée <span class="text-primary">*</span></label>
                        <textarea name="description" required rows="6" class="form-control rounded-3 p-3 border-light shadow-sm focus-ring" placeholder="Décrivez le défi..."><?= htmlspecialchars($challenge->getDescription()) ?></textarea>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Catégorie <span class="text-primary">*</span></label>
                            <select name="categorie" required class="form-select rounded-3 p-3 border-light shadow-sm focus-ring">
                                <?php
                                $cats = ['Art', 'Photo', 'Musique', 'Écriture', 'Autre'];
                                foreach ($cats as $cat): ?>
                                    <option value="<?= $cat ?>" <?= $challenge->getCategorie() === $cat ? 'selected' : '' ?>>
                                        <?= $cat ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Date limite <span class="text-primary">*</span></label>
                            <input type="date" name="date_limite" required value="<?= htmlspecialchars($challenge->getDateLimite()) ?>" class="form-control rounded-3 p-3 border-light shadow-sm focus-ring">
                        </div>
                    </div>

                    <div class="bg-light border border-dashed rounded-4 p-4 mb-5">
                        <div class="row align-items-center g-4">
                            <div class="col-sm-auto">
                                <div class="bg-white rounded-3 shadow-sm overflow-hidden border" style="width: 120px; height: 120px;">
                                    <?php if ($challenge->getImagePath()): ?>
                                        <img src="<?= htmlspecialchars($challenge->getImagePath()) ?>" alt="Image actuelle" class="w-100 h-100 object-fit-cover">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted bg-light p-2">
                                            <i class="bi bi-image fs-3 mb-1"></i>
                                            <span class="fw-bold" style="font-size: 0.6rem;">AUCUNE</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-sm">
                                <label class="form-label text-uppercase fw-black text-muted small tracking-widest mb-2">Changer l'image (facultatif)</label>
                                <input type="file" name="image" accept="image/jpeg,image/png,image/gif" class="form-control rounded-3 border-light shadow-sm">
                                <p class="mt-2 text-muted small text-uppercase tracking-widest fw-bold" style="font-size: 0.65rem;">JPG, PNG ou GIF (max. 5 Mo)</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-top border-light d-flex align-items-center justify-content-between">
                        <a href="index.php?url=challenge/view&id=<?= $challenge->getId() ?>" class="btn btn-link link-secondary text-decoration-none fw-bold text-uppercase small tracking-widest">
                            <i class="bi bi-x-lg me-1"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary rounded-4 py-3 px-5 fw-black text-uppercase shadow-sm tracking-widest">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
