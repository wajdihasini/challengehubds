<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="mb-5">
    <h1 class="h2 fw-bold text-dark mb-1">Gestion des Votes</h1>
    <p class="text-secondary small">Surveillance des votes sur la plateforme.</p>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="px-4 py-3 border-0 small text-uppercase fw-bold text-muted">ID</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Votant</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Participation #</th>
                    <th class="px-3 py-3 border-0 small text-uppercase fw-bold text-muted">Date du vote</th>
                    <th class="px-4 py-3 border-0 small text-uppercase fw-bold text-muted text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                <?php foreach ($votes as $v): ?>
                <tr>
                    <td class="px-4 py-3 small fw-bold text-dark"><?php echo $v['id_vote']; ?></td>
                    <td class="px-3 py-3 small fw-medium text-dark"><?php echo htmlspecialchars($v['user_email']); ?></td>
                    <td class="px-3 py-3">
                        <span class="badge bg-secondary-subtle text-secondary px-2 rounded-2">
                            #<?php echo htmlspecialchars($v['submission_id']); ?>
                        </span>
                    </td>
                    <td class="px-3 py-3 small text-secondary italic"><?php echo htmlspecialchars($v['voted_at']); ?></td>
                    <td class="px-4 py-3 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php?url=submission/view&id=<?php echo $v['submission_id']; ?>" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                <i class="bi bi-eye"></i> <span class="d-none d-md-inline ms-1">Voir</span>
                            </a>
                            <a href="index.php?url=admin/vote/delete&id=<?php echo $v['id_vote']; ?>" class="btn btn-sm btn-outline-danger rounded-3 px-3" onclick="return confirm('Initialiser ce vote ?')">
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
