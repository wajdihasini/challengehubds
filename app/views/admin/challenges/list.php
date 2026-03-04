<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="mb-5">
    <h1 class="h2 fw-bold text-dark mb-1">Gestion des Défis</h1>
    <p class="text-secondary small">Liste de tous les défis créés par les utilisateurs.</p>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="px-4 py-3 border-0 small text-uppercase fw-bold text-muted">ID</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Titre</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Date limite</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Catégorie</th>
                    <th class="px-4 py-3 border-0 small text-uppercase fw-bold text-muted text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                <?php foreach ($challenges as $c): ?>
                <tr>
                    <td class="px-4 py-3 small fw-bold text-dark"><?php echo $c->getId(); ?></td>
                    <td class="px-3 py-3 small fw-bold text-dark"><?php echo htmlspecialchars($c->getTitre()); ?></td>
                    <td class="px-3 py-3 small text-secondary">
                        <i class="bi bi-calendar-event me-1"></i> <?php echo htmlspecialchars($c->getDateLimite()); ?>
                    </td>
                    <td class="px-3 py-3">
                        <span class="badge bg-info-subtle text-info px-3 small rounded-pill">
                            <?php echo htmlspecialchars($c->getCategorie() ?? 'N/A'); ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php?url=challenge/view&id=<?php echo $c->getId(); ?>" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                <i class="bi bi-eye"></i> <span class="d-none d-md-inline ms-1">Voir</span>
                            </a>
                            <a href="index.php?url=admin/challenge/delete&id=<?php echo $c->getId(); ?>" class="btn btn-sm btn-outline-danger rounded-3 px-3" onclick="return confirm('Supprimer ce défi ainsi que toutes les participations associées ?')">
                                <i class="bi bi-trash"></i> <span class="d-none d-md-inline ms-1">Supprimer</span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>
