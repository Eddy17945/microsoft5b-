<?php
?>

<div class="d-flex justify-content-between mb-4">
    <h2>Detalles de Persona</h2>
    <div>
        <a href="<?= BASE_URL ?>index.php?controller=persona&action=edit&id=<?= $this->persona->id_persona ?>" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="<?= BASE_URL ?>index.php?controller=persona&action=index" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <a href="<?= BASE_URL ?>index.php?controller=direccion&action=byPersona&id_persona=<?= $this->persona->id_persona ?>" class="btn btn-sm btn-info">
            Ver Direcciones
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Información Personal
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>ID:</strong> <?= $this->persona->id_persona ?></p>
                <p><strong>Nombre:</strong> <?= htmlspecialchars($this->persona->nombre) ?></p>
                <p><strong>Apellido:</strong> <?= htmlspecialchars($this->persona->apellido) ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Fecha Nacimiento:</strong> <?= $this->persona->fecha_nacimiento ?></p>
                <p><strong>Sexo:</strong> <?= htmlspecialchars($sexo_desc ?? '') ?></p>
                <p><strong>Estado Civil:</strong> <?= htmlspecialchars($estadocivil_desc ?? '') ?></p>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <ul class="nav nav-tabs" id="personaTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="direcciones-tab" data-bs-toggle="tab" data-bs-target="#direcciones" type="button">Direcciones</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="telefonos-tab" data-bs-toggle="tab" data-bs-target="#telefonos" type="button">Teléfonos</button>
        </li>
    </ul>
    <div class="tab-content p-3 border border-top-0 rounded-bottom">
        <div class="tab-pane fade show active" id="direcciones" role="tabpanel">
            <?php if (file_exists(__DIR__ . '/../direccion/index.php')): ?>
                <?php include __DIR__ . '/../direccion/index.php'; ?>
            <?php else: ?>
                <p>No hay direcciones disponibles.</p>
            <?php endif; ?>
        </div>
        
        <div class="tab-pane fade" id="telefonos" role="tabpanel">
            <!-- Sección de teléfonos -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Teléfonos</h5>
                        <a href="<?= BASE_URL ?>index.php?controller=telefono&action=create&id_persona=<?= $this->persona->id_persona ?>" class="btn btn-sm btn-success">
                            <i class="bi bi-plus-circle"></i> Agregar Teléfono
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($telefonos)): ?>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($telefonos as $telefono): ?>
                            <tr>
                                <td><?= htmlspecialchars($telefono['numero']) ?></td>
                                <td><?= htmlspecialchars($telefono['tipo']) ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>index.php?controller=telefono&action=edit&id=<?= $telefono['id_telefono'] ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?= BASE_URL ?>index.php?controller=telefono&action=delete&id=<?= $telefono['id_telefono'] ?>" method="POST" style="display: inline;">
                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este teléfono?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="alert alert-info">No hay teléfonos</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ?>