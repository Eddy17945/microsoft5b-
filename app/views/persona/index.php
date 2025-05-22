<?php
$content = ob_get_clean();

?>

<div class="d-flex justify-content-between mb-4">
    <h2>Listado de Personas</h2>
    <a href="<?= BASE_URL ?>index.php?controller=persona&action=create" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Nueva Persona
    </a>
</div>

<?php if(empty($personas)): ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> No hay personas registradas.
        <a href="<?= BASE_URL ?>index.php?controller=persona&action=create" class="alert-link">¡Registra la primera!</a>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha Nacimiento</th>
                    <th>Sexo</th>
                    <th>Estado Civil</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($personas as $persona): ?>
                <tr>
                    <td><?= htmlspecialchars($persona['id_persona'] ?? '') ?></td>
                    <td><?= htmlspecialchars($persona['nombre'] ?? '') ?></td>
                    <td><?= htmlspecialchars($persona['apellido'] ?? '') ?></td>
                    <td><?= htmlspecialchars($persona['fecha_nacimiento'] ?? '') ?></td>
                    <td><?= htmlspecialchars($persona['sexo_descripcion'] ?? '') ?></td>
                    <td><?= htmlspecialchars($persona['estadocivil_descripcion'] ?? '') ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="<?= BASE_URL ?>index.php?controller=persona&action=view&id=<?= $persona['id_persona'] ?>" 
                               class="btn btn-sm btn-info" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= BASE_URL ?>index.php?controller=persona&action=edit&id=<?= $persona['id_persona'] ?>" 
                               class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= BASE_URL ?>index.php?controller=persona&action=delete&id=<?= $persona['id_persona'] ?>" 
                               class="btn btn-sm btn-danger" 
                               title="Eliminar"
                               onclick="return confirm('¿Estás seguro de que deseas eliminar a <?= htmlspecialchars($persona['nombre'] . ' ' . $persona['apellido']) ?>?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>