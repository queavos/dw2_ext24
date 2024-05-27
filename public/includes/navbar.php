<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gestión Académica</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/actas/index.php">Actas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/materias/index.php">Materias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/carreras/index.php">Carreras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profesores/index.php">Docentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/oportunidades/index.php">Oportunidades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/roles/index.php">Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/usuarios/index.php">Usuarios</a>
                </li>
                <?php if (isLoggedIn()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/cambiar_contrasena.php">Cambiar Contraseña</a>
                </li>
                <?php if (isAdmin()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/admin_cambiar_contrasena.php">Cambiar Contraseña de Usuario</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="/logout.php">Cerrar Sesión</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
