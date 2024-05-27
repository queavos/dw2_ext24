<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Actas.php';
require_once '../../classes/Materias.php';
require_once '../../classes/Oportunidades.php';
require_once '../../classes/Usuarios.php';
require_once '../../config/config.php';
restrictAccess(['Administrador', 'Secretario']);
$database = new Database();
$db = $database->connect();

$actas = new Actas($db);
$materias = new Materias($db);
$materias_result = $materias->obtenerMaterias();

$oportunidades = new Oportunidades($db);
$oportunidades_result = $oportunidades->obtenerOportunidades();

$usuarios = new Usuarios($db);
$usuarios_result = $usuarios->obtenerUsuarios();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $acta_codi = $_POST['acta_codi'];
    $acta_fecha = $_POST['acta_fecha'];
    $acta_recibido = $_POST['acta_recibido'];
    $mate_id = $_POST['mate_id'];
    $opor_id = $_POST['opor_id'];
    $usr_id = $_POST['usr_id'];

    $acta_archivo = $_FILES['acta_archivo'];
    $acta_planilla = $_FILES['acta_planilla'];

    try {
        $actas->actualizarActa($id, $acta_codi, $acta_fecha, $acta_archivo, $acta_recibido, $acta_planilla, $mate_id, $opor_id, $usr_id);
        header('Location: index.php');
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
} else {
    $id = $_GET['id'];
    $acta = $actas->obtenerActaPorId($id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Acta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dropzone {
            border: 2px dashed #007bff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            color: #007bff;
            cursor: pointer;
        }
        .dropzone.dragover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
     <?php include '../includes/navbar.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Editar Acta</h1>
    <?php if ($error): ?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>
    <form action="editar.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $acta['id']; ?>">
        <div class="mb-3">
            <label for="acta_codi" class="form-label">Código del Acta:</label>
            <input type="text" name="acta_codi" id="acta_codi" class="form-control" value="<?php echo $acta['acta_codi']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="acta_fecha" class="form-label">Fecha del Acta:</label>
            <input type="date" name="acta_fecha" id="acta_fecha" class="form-control" value="<?php echo $acta['acta_fecha']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="acta_archivo" class="form-label">Archivo del Acta:</label>
            <div class="dropzone" id="dropzone-acta">Arrastra el archivo aquí o haz clic para seleccionarlo</div>
            <input type="file" name="acta_archivo" id="acta_archivo" class="form-control-file d-none">
        </div>
        <div class="mb-3">
            <label for="acta_recibido" class="form-label">Fecha de Recepción del Acta:</label>
            <input type="date" name="acta_recibido" id="acta_recibido" class="form-control" value="<?php echo $acta['acta_recibido']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="acta_planilla" class="form-label">Archivo de la Planilla:</label>
            <div class="dropzone" id="dropzone-planilla">Arrastra el archivo aquí o haz clic para seleccionarlo</div>
            <input type="file" name="acta_planilla" id="acta_planilla" class="form-control-file d-none">
        </div>
        <div class="mb-3">
            <label for="mate_id" class="form-label">Materia:</label>
            <select name="mate_id" id="mate_id" class="form-control" required>
                <?php while ($row = $materias_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $acta['mate_id']) echo 'selected'; ?>><?php echo $row['mate_code'] . ' - ' . $row['mate_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="opor_id" class="form-label">Oportunidad:</label>
            <select name="opor_id" id="opor_id" class="form-control" required>
                <?php while ($row = $oportunidades_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $acta['opor_id']) echo 'selected'; ?>><?php echo $row['opor_code']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="usr_id" class="form-label">Usuario:</label>
            <select name="usr_id" id="usr_id" class="form-control" required>
                <?php while ($row = $usuarios_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $acta['usr_id']) echo 'selected'; ?>><?php echo $row['user_nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupDropzone(dropzoneId, inputId) {
        var dropzone = document.getElementById(dropzoneId);
        var input = document.getElementById(inputId);

        dropzone.addEventListener('click', function() {
            input.click();
        });

        dropzone.addEventListener('dragover', function(event) {
            event.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', function() {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', function(event) {
            event.preventDefault();
            dropzone.classList.remove('dragover');
            input.files = event.dataTransfer.files;
            dropzone.textContent = event.dataTransfer.files[0].name;
        });

        input.addEventListener('change', function() {
            dropzone.textContent = input.files[0].name;
        });
    }

    setupDropzone('dropzone-acta', 'acta_archivo');
    setupDropzone('dropzone-planilla', 'acta_planilla');
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
