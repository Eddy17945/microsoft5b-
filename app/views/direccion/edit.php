<?php
$content = ob_get_clean();
?>

<h4>Editar Dirección</h4>

<form action="<?= BASE_URL ?>index.php?controller=direccion&action=update&id=<?= $this->direccion->id_direccion ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    
    <div class="mb-3">
        <label for="calle" class="form-label">Calle</label>
        <input type="text" class="form-control" id="calle" name="calle" value="<?= htmlspecialchars($this->direccion->calle) ?>" required>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="ciudad" class="form-label">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?= htmlspecialchars($this->direccion->ciudad) ?>" required>
        </div>
        <div class="col-md-6">
            <label for="estado" class="form-label">Estado/Provincia</label>
            <input type="text" class="form-control" id="estado" name="estado" value="<?= htmlspecialchars($this->direccion->estado) ?>" required>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="codigo_postal" class="form-label">Código Postal</label>
        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="<?= htmlspecialchars($this->direccion->codigo_postal) ?>">
    </div>
    
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="<?= BASE_URL ?>index.php?controller=persona&action=view&id=<?= $this->direccion->id_persona ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?php ?>