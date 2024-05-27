<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Materias.php';
require_once '../../classes/Carreras.php';
require_once '../../classes/Profesores.php';
require_once '../../config/config.php';
restrictAccess(['Administrador', 'Secretario']);
$database = new Database();
$db = $database->connect();

$materias = new Materias($db);
$carreras = new Carreras($db);
$carreras_result = $carreras->obtenerCarreras();

$docentes = new Profesores($db);
$docentes_result = $docentes->obtenerProfesores();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $mate_code = $_POST['mate_code'];
    $mate_name = $_POST['mate_name'];
    $mate_anho = $_POST['mate_anho'];
    $carre_id = $_POST['carre_id'];
    $doce_id = $_POST['doce_id'];

    try {
        $materias->actualizarMateria($id, $mate_code, $mate_name, $mate_anho, $carre_id, $doce_id);
        header('Location: index.php');
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
} else {
    $id = $_GET['id'];
    $materia = $materias->obtenerMateriaPorId($id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Materia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Editar Materia</h1>
    <?php if ($error): ?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>
    <form action="editar.php" method="post">
        <input type="hidden" name="id" value="<?php echo $materia['id']; ?>">
        <div class="mb-3">
            <label for="mate_code" class="form-label">Código de la Materia:</label>
            <input type="text" name="mate_code" id="mate_code" class="form-control" value="<?php echo $materia['mate_code']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="mate_name" class="form-label">Nombre de la Materia:</label>
            <input type="text" name="mate_name" id="mate_name" class="form-control" value="<?php echo $materia['mate_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="mate_anho" class="form-label">Año:</label>
            <input type="number" name="mate_anho" id="mate_anho" class="form-control" value="<?php echo $materia['mate_anho']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="carre_id" class="form-label">Carrera:</label>
            <select name="carre_id" id="carre_id" class="form-control" required>
                <?php while ($row = $carreras_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $materia['carre_id']) echo 'selected'; ?>><?php echo $row['carre_sigla']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="doce_id" class="form-label">Docente:</label>
            <select name="doce_id" id="doce_id" class="form-control" required>
                <?php while ($row = $docentes_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $materia['doce_id']) echo 'selected'; ?>><?php echo $row['doce_apellido'] . ' ' . $row['doce_nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
