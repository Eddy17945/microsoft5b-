<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Contactos</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>">Sistema de Gestión</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>index.php?controller=persona&action=index">Personas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>index.php?controller=direccion&action=index">Direcciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>index.php?controller=telefono&action=index">Teléfonos</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="catalogosDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Catálogos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="catalogosDropdown">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=sexo&action=index">Sexos</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=estadocivil&action=index">Estados Civiles</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?? 'info' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
            <?php unset($_SESSION['message_type']); ?>
        <?php endif; ?>
        
        <!-- Aquí va el contenido principal -->
        <?php if (!isset($content) || empty($content)): ?>
            <!-- Este es el contenido que se mostrará en la página principal cuando no hay otro contenido -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Bienvenido al Sistema de Gestión de Contactos</h2>
                            <p class="card-text">Este sistema le permite gestionar información de contactos, incluyendo datos personales, direcciones y teléfonos.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Tarjetas de acceso rápido -->
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-user fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title">Personas</h5>
                            <p class="card-text">Gestione la información de contactos.</p>
                            <!-- Añadir contador de registros -->
                            <div class="badge bg-primary mb-2">
                                <?php 
                                // Asegurarse que estamos mostrando el valor correcto con una verificación adicional
                                echo (isset($stats['personas']) && is_numeric($stats['personas'])) ? $stats['personas'] : '0';
                                ?> registros
                            </div>
                            <a href="<?= BASE_URL ?>index.php?controller=persona&action=index" class="btn btn-primary">Acceder</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt fa-3x mb-3 text-success"></i>
                            <h5 class="card-title">Direcciones</h5>
                            <p class="card-text">Administre las direcciones de sus contactos.</p>
                            <!-- Añadir contador de registros -->
                            <div class="badge bg-success mb-2">
                                <?php 
                                echo (isset($stats['direcciones']) && is_numeric($stats['direcciones'])) ? $stats['direcciones'] : '0';
                                ?> registros
                            </div>
                            <a href="<?= BASE_URL ?>index.php?controller=direccion&action=index" class="btn btn-success">Acceder</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-phone fa-3x mb-3 text-info"></i>
                            <h5 class="card-title">Teléfonos</h5>
                            <p class="card-text">Gestione números telefónicos.</p>
                            <!-- Añadir contador de registros -->
                            <div class="badge bg-info text-dark mb-2">
                                <?php 
                                echo (isset($stats['telefonos']) && is_numeric($stats['telefonos'])) ? $stats['telefonos'] : '0';
                                ?> registros
                            </div>
                            <a href="<?= BASE_URL ?>index.php?controller=telefono&action=index" class="btn btn-info">Acceder</a>
                        </div>
                    </div>
                </div>
                
                <!-- El resto de la tarjeta de catálogos permanece igual -->
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-list fa-3x mb-3 text-warning"></i>
                            <h5 class="card-title">Catálogos</h5>
                            <p class="card-text">Edite catálogos del sistema.</p>
                            <div class="dropdown">
                                <button class="btn btn-warning dropdown-toggle" type="button" id="catalogosButton" 
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Seleccionar
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="catalogosButton">
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=sexo&action=index">Sexos</a></li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?controller=estadocivil&action=index">Estados Civiles</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Sección de acciones rápidas -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Acciones Rápidas</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="<?= BASE_URL ?>index.php?controller=persona&action=create" class="list-group-item list-group-item-action">
                                    <i class="fas fa-user-plus me-2"></i> Agregar nueva persona
                                </a>
                                <a href="<?= BASE_URL ?>index.php?controller=direccion&action=create" class="list-group-item list-group-item-action">
                                    <i class="fas fa-map-marker-plus me-2"></i> Registrar dirección
                                </a>
                                <a href="<?= BASE_URL ?>index.php?controller=telefono&action=create" class="list-group-item list-group-item-action">
                                    <i class="fas fa-phone-plus me-2"></i> Agregar teléfono
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sección informativa -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Información del Sistema</h5>
                        </div>
                        <div class="card-body">
                            <p>Este sistema de gestión permite:</p>
                            <ul>
                                <li>Registrar personas con sus datos personales</li>
                                <li>Asociar múltiples direcciones a cada persona</li>
                                <li>Registrar varios números telefónicos por contacto</li>
                                <li>Administrar catálogos como sexo y estado civil</li>
                            </ul>
                            <p>Utilice el menú superior para navegar entre las diferentes secciones del sistema.</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php echo $content; ?>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © <?= date('Y') ?> Sistema de Gestión de Contactos
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?= BASE_URL ?>js/main.js"></script>
</body>
</html>