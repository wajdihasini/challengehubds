<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Header section -->
            <div class="p-5 text-white" style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);">
                <div class="d-flex align-items-center">
                    <div class="avatar-circle rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 100px; height: 100px; font-size: 2.5rem; backdrop-filter: blur(5px); border: 2px solid rgba(255,255,255,0.3);">
                        <?= strtoupper(substr($user->getPrenom(), 0, 1) . substr($user->getNom(), 0, 1)) ?>
                    </div>
                    <div class="ms-4">
                        <h2 class="display-6 fw-black mb-1"><?= htmlspecialchars($user->getPrenom() . " " . $user->getNom()) ?></h2>
                        <p class="mb-0 opacity-75 d-flex align-items-center">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <?= htmlspecialchars($user->getEmail()) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Body section -->
            <div class="card-body p-5">
                <div class="row g-5">
                    <div class="col-md-7">
                        <div class="mb-4">
                            <h3 class="text-uppercase tracking-wider text-muted fw-bold small mb-2">Détails personnels</h3>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="text-muted small d-block">Genre</label>
                                    <span class="fw-bold text-dark"><?= $user->getSexe() === 'M' ? 'Homme' : 'Femme' ?></span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Date de naissance</label>
                                    <span class="fw-bold text-dark"><?= htmlspecialchars($user->getDateNaissance()) ?></span>
                                </div>
                                <div class="col-12 mt-4">
                                    <label class="text-muted small d-block">Adresse</label>
                                    <p class="text-dark mb-0"><?= nl2br(htmlspecialchars($user->getAdresse())) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 d-flex flex-column justify-content-center">
                        <div class="d-grid gap-3">
                            <a href="index.php?url=edit-profile" class="btn btn-primary btn-lg rounded-3 fw-bold py-3 shadow-sm d-flex align-items-center justify-content-center">
                                <i class="bi bi-pencil-square me-2"></i> Modifier le profil
                            </a>
                            <a href="index.php?url=delete-user" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')" class="btn btn-outline-danger btn-lg rounded-3 fw-bold py-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-trash3 me-2"></i> Supprimer mon compte
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>