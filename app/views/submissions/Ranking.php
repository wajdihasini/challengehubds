<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="py-4">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-black text-dark mb-3">Classement Général</h1>
        <p class="lead text-secondary mx-auto" style="max-width: 700px;">Les créations les plus plébiscitées par la communauté ChallengeHub.</p>
    </div>

    <?php if (!empty($ranking)) : ?>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase fw-black text-muted small tracking-widest border-0">Rang</th>
                            <th class="py-3 text-uppercase fw-black text-muted small tracking-widest border-0">Participation</th>
                            <th class="py-3 text-uppercase fw-black text-muted small tracking-widest border-0 text-center">Votes</th>
                            <th class="pe-4 py-3 text-uppercase fw-black text-muted small tracking-widest border-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ranking as $index => $sub) : ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="d-flex align-items-center justify-content-center rounded-3 fw-black fs-5" 
                                          style="width: 45px; height: 45px; <?php 
                                            if ($index === 0) echo 'background: #fff8e1; color: #ffab00;';
                                            elseif ($index === 1) echo 'background: #f5f5f5; color: #9e9e9e;';
                                            elseif ($index === 2) echo 'background: #fff3e0; color: #fb8c00;';
                                            else echo 'background: #fafafa; color: #bdbdbd;';
                                          ?>">
                                        <?= $index + 1 ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3 py-2">
                                        <div class="flex-shrink-0" style="width: 70px; height: 70px;">
                                            <?php 
                                            // Récupération du chemin de l'image et nettoyage du slash initial
                                            $photoPath = $sub['image'] ?? $sub['image_path'] ?? '';
                                            if (!empty($photoPath)): ?>
                                                <img src="<?= ltrim(htmlspecialchars($photoPath), '/') ?>" 
                                                     class="rounded-3 w-100 h-100 object-fit-cover shadow-sm" 
                                                     style="object-fit: cover;">
                                            <?php else: ?>
                                                <div class="rounded-3 w-100 h-100 bg-light d-flex align-items-center justify-content-center border border-dashed text-muted">
                                                    <i class="bi bi-image" style="font-size: 1.5rem;"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1 text-truncate" style="max-width: 300px;">
                                                <?= htmlspecialchars($sub['description']) ?>
                                            </h6>
                                            <p class="mb-0 text-muted small">
                                                Par <span class="fw-semibold"><?= htmlspecialchars(($sub['user_prenom'] ?? $sub['prenom'] ?? 'Utilisateur') . ' ' . ($sub['user_nom'] ?? $sub['nom'] ?? '')) ?></span> 
                                                dans <span class="fst-italic text-primary-emphasis"><?= htmlspecialchars($sub['challenge_titre'] ?? $sub['challenge_title'] ?? $sub['titre'] ?? 'Défi') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex flex-column align-items-center">
                                        <span class="fs-3 fw-black text-primary line-height-1"><?= $sub['vote_count'] ?? 0 ?></span>
                                        <span class="text-uppercase fw-black text-muted mt-minus-1" style="font-size: 0.6rem; letter-spacing: 0.1em;">Points</span>
                                    </div>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="index.php?url=submission/view&id=<?= $sub['id_sub'] ?? $sub['id'] ?>" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold text-uppercase" style="font-size: 0.65rem;">
                                        Voir l'œuvre
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else : ?>
        <div class="card border-0 border-dashed bg-light text-center py-5 rounded-4 mt-4">
            <div class="py-4">
                <i class="bi bi-trophy display-4 text-muted mb-3 d-block"></i>
                <h4 class="fw-bold text-muted fst-italic">Le classement est encore vide.</h4>
                <p class="text-muted small">Soyez le premier à voter pour une participation !</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
