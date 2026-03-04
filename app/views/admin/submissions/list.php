<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="mb-5">
    <h1 class="h2 fw-bold text-dark mb-1">Gestion des Participations</h1>
    <p class="text-secondary small">Liste de toutes les solutions soumises par les participants.</p>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="px-4 py-3 border-0 small text-uppercase fw-bold text-muted">ID</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Email Participant</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Défis (ID)</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Date</th>
                    <th class="px-4 py-3 border-0 small text-uppercase fw-bold text-muted text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                <?php foreach ($submissions as $s): ?>
                <tr>
                    <td class="px-4 py-3 small fw-bold text-dark"><?php echo $s['id_sub']; ?></td>
                    <td class="px-3 py-3 small text-dark"><?php echo htmlspecialchars($s['user_email']); ?></td>
                    <td class="px-3 py-3 small">
                        <span class="badge bg-secondary-subtle text-secondary px-2 rounded-2">
                             #<?php echo htmlspecialchars($s['id_ch']); ?>
                        </span>
                    </td>
                    <td class="px-3 py-3 small text-secondary italic"><?php echo htmlspecialchars($s['submitted_at']); ?></td>
                    <td class="px-4 py-3 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php?url=submission/view&id=<?php echo $s['id_sub']; ?>" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                <i class="bi bi-eye"></i> <span class="d-none d-md-inline ms-1">Voir</span>
                            </a>
                            <a href="index.php?url=admin/submission/delete&id=<?php echo $s['id_sub']; ?>" class="btn btn-sm btn-outline-danger rounded-3 px-3" onclick="return confirm('Confirmer la suppression ?')">
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
