<?php
$content = ob_get_clean();
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Detalles del Teléfono</h5>
        <div>
            <a href="/public/index.php?controller=telefono&action=edit&id=<?= $this->telefono->id_telefono ?>" class="btn btn-sm btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="/public/index.php?controller=persona&action=view&id=<?= $this->telefono->id_persona ?>" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver a Persona
            </a>
        </div>
    </div>
    <div class="card-body">
        <h6 class="card-subtitle mb-3 text-muted">Persona: <?= htmlspecialchars($this->persona->nombre . ' ' . $this->persona->apellido) ?></h6>
        
        <table class="table table-bordered">
            <tr>
                <th style="width: 30%">Número</th>
                <td><?= htmlspecialchars($this->telefono->numero) ?></td>
            </tr>
            <tr>
                <th>Tipo</th>
                <td><?= htmlspecialchars($this->telefono->tipo) ?></td>
            </tr>
        </table>
    </div>
    <div class="card-footer text-end">
        <form action="/public/index.php?controller=telefono&action=delete&id=<?= $this->telefono->id_telefono ?>" method="POST" style="display: inline;">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este teléfono?')">
                <i class="bi bi-trash"></i> Eliminar
            </button>
        </form>
    </div>
</div>

<?php ?>