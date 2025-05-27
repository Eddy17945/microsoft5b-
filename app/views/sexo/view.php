<?php

if (ob_get_level() == 0) ob_start();
?>

<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>Detalles de Sexo</h2>
        <div>
            <a href="<?= BASE_URL ?>index.php?controller=sexo&action=edit&id=<?= $this->sexo->id_sexo ?>" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="<?= BASE_URL ?>index.php?controller=sexo&action=index" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Información del Sexo ID: <?= $this->sexo->id_sexo ?>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 30%">ID</th>
                    <td><?= $this->sexo->id_sexo ?></td>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <td><?= htmlspecialchars($this->sexo->descripcion) ?></td>
                </tr>
            </table>
        </div>
        <div class="card-footer text-end">
            <form action="<?= BASE_URL ?>index.php?controller=sexo&action=delete&id=<?= $this->sexo->id_sexo ?>" method="POST" style="display: inline;">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<?php

?>