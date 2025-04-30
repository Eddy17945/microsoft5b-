<?php
// Asegurarse de que existen las variables necesarias
$sexos = $sexos ?? [];
$estadosCiviles = $estadosCiviles ?? [];
?>

<h2>Editar Persona</h2>

<form action="/public/index.php?controller=persona&action=update" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <input type="hidden" name="id_persona" value="<?= htmlspecialchars($this->persona->id_persona) ?>">
    
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($this->persona->nombre) ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($this->persona->apellido) ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $this->persona->fecha_nacimiento ?>">
    </div>
    
    <div class="mb-3">
        <label for="id_sexo" class="form-label">Sexo</label>
        <select class="form-select" id="id_sexo" name="id_sexo" required>
            <option value="">Seleccione...</option>
            <?php foreach ($sexos as $sexo): ?>
                <option value="<?= $sexo['id_sexo'] ?>" <?= $sexo['id_sexo'] == $this->persona->id_sexo ? 'selected' : '' ?>>
                    <?= htmlspecialchars($sexo['descripcion']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="id_estadocivil" class="form-label">Estado Civil</label>
        <select class="form-select" id="id_estadocivil" name="id_estadocivil" required>
            <option value="">Seleccione...</option>
            <?php foreach ($estadosCiviles as $estado): ?>
                <option value="<?= $estado['id_estadocivil'] ?>" <?= $estado['id_estadocivil'] == $this->persona->id_estadocivil ? 'selected' : '' ?>>
                    <?= htmlspecialchars($estado['descripcion']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="/public/index.php?controller=persona&action=view&id=<?= $this->persona->id_persona ?>" class="btn btn-secondary">Cancelar</a>
</form>