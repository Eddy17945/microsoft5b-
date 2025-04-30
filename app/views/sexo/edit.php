<?php

if (ob_get_level() == 0) ob_start();
?>

<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>Editar Sexo</h2>
        <a href="/public/index.php?controller=sexo&action=index" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="/public/index.php?controller=sexo&action=update" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <input type="hidden" name="id_sexo" value="<?= $this->sexo->id_sexo ?>">
                
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= htmlspecialchars($this->sexo->descripcion) ?>" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="/public/index.php?controller=sexo&action=index" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<?php

?>