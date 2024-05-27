<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Actas.php';
require_once '../../config/config.php';
restrictAccess(['Administrador', 'Secretario']);
$database = new Database();
$db = $database->connect();

$actas = new Actas($db);
$result = $actas->obtenerActas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Actas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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

    <h1 class="mb-4">Lista de Actas</h1>
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
    </div>
    <a href="crear.php" class="btn btn-primary mb-3">Crear Nueva Acta</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código del Acta</th>
                <th>Fecha del Acta</th>
                <th>Archivo del Acta</th>
                <th>Fecha de Recepción</th>
                <th>Archivo de la Planilla</th>
                <th>Materia</th>
                <th>Oportunidad</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="actasTable">
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['acta_codi']; ?></td>
                <td><?php echo $row['acta_fecha']; ?></td>
                <td>
                    <?php if ($row['acta_archivo']): ?>
                        <a href="uploads/<?php echo $row['acta_archivo']; ?>" target="_blank"><i class="fas fa-file-pdf"></i> Descargar</a>
                    <?php else: ?>
                        No disponible
                    <?php endif; ?>
                </td>
                <td><?php echo $row['acta_recibido']; ?></td>
                <td>
                    <?php if ($row['acta_planilla']): ?>
                        <a href="uploads/<?php echo $row['acta_planilla']; ?>" target="_blank"><i class="fas fa-file-pdf"></i> Descargar</a>
                    <?php else: ?> 
                        No disponible
                    <?php endif; ?>
                </td>
                <td><?php echo $row['materia']; ?></td>
                <td><?php echo $row['opor_code']; ?></td>
                <td><?php echo $row['user_nombre']; ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta acta?');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var searchValue = this.value.toLowerCase();
        var rows = document.querySelectorAll('#actasTable tr');

        rows.forEach(function(row) {
            var showRow = Array.from(row.cells).some(function(cell) {
                return cell.textContent.toLowerCase().includes(searchValue);
            });

            if (showRow) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
