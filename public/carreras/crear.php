<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Carreras.php';
require_once '../../classes/Facultades.php';

$error = '';

$database = new Database();
$db = $database->connect();

$facultades = new Facultades($db);
$facultades_result = $facultades->obtenerFacultades();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $carre_sigla = $_POST['carre_sigla'];
    $carre_nombre = $_POST['carre_nombre'];
    $facu_id = $_POST['facu_id'];

    $carreras = new Carreras($db);

    try {
        $resultado = $carreras->crearCarrera($carre_sigla, $carre_nombre, $facu_id);
        if ($resultado) {
            header('Location: index.php');
        } else {
            $error = 'Error al crear la carrera.';
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Carrera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Crear Nueva Carrera</h1>
    <?php if ($error): ?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>
    <form action="crear.php" method="post">
        <div class="mb-3">
            <label for="carre_sigla" class="form-label">Sigla de la Carrera:</label>
            <input type="text" name="carre_sigla" id="carre_sigla" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="carre_nombre" class="form-label">Nombre de la Carrera:</label>
            <input type="text" name="carre_nombre" id="carre_nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="facu_id" class="form-label">Facultad:</label>
            <select name="facu_id" id="facu_id" class="form-control" required>
                <?php while ($row = $facultades_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['facu_code']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
