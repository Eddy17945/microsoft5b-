<?php
$content = ob_get_clean();

?>

<div class="d-flex justify-content-between mb-4">
    <h2>Listado de Personas</h2>
    <a href="<?= BASE_URL ?>/public/index.php?controller=persona&action=create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Persona
    </a>
</div>

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
                <a href="<?= BASE_URL ?>/public/index.php?controller=persona&action=view&id=<?= $persona['id_persona'] ?>" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="<?= BASE_URL ?>/public/index.php?controller=persona&action=edit&id=<?= $persona['id_persona'] ?>" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="<?= BASE_URL ?>/public/index.php?controller=persona&action=delete&id=<?= $persona['id_persona'] ?>" method="POST" style="display: inline;">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php  ?>