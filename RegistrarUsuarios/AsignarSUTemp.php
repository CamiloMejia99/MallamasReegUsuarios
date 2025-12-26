<?php
session_start();
include '../bd/conexion.php';

// Bloqueo de caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificación de acceso
if (!isset($_SESSION['acceso_registro']) || $_SESSION['acceso_registro'] !== true) {
    header("Location: ../index.php?error=acceso_denegado");
    exit;
}

// -------------------------- SUTEMP --------------------------
$mensaje = null;

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['activarSU'])) {

    $cedula   = $_POST['cedula'] ?? null;
    $permisos = $_POST['permisos'] ?? [];

    if (!$cedula) {
        $mensaje = "Debe seleccionar un usuario";
    } else {

        $inicio = new DateTime($_POST['fecha_inicio']);
        $fin    = new DateTime($_POST['fecha_fin']);

        // Validar orden de fechas
        if ($fin < $inicio) {
            $mensaje = "La fecha final no puede ser menor a la fecha inicial";
        } else {

            // Validar rango máximo (6 meses = 183 días)
            $diff = $inicio->diff($fin)->days;
            if ($diff > 183) {
                $mensaje = "El rango máximo permitido es de 6 meses";
            } else {

                // Validar que NO exista un SU temporal activo
                $sqlVal = "
                    SELECT 1
                    FROM super_usuario_temporal
                    WHERE Cedula = ?
                      AND GETDATE() BETWEEN fecha_inicio AND fecha_fin
                ";

                $stmtVal = sqlsrv_query(
                    $conexionGestionIndicadores,
                    $sqlVal,
                    [$cedula]
                );

                if ($stmtVal === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                if (sqlsrv_fetch($stmtVal)) {

                    $mensaje = "Este usuario ya tiene un Super Usuario Temporal activo";

                } else {

                    // Insertar SU temporal
                    $sql = "
                        INSERT INTO super_usuario_temporal (
                            Cedula,
                            fecha_inicio,
                            fecha_fin,
                            p_registrar_indicador,
                            p_registrar_resultado,
                            p_editar_indicador,
                            p_eliminar_indicador
                        ) VALUES (?, ?, ?, ?, ?, ?, ?)
                    ";

                    $params = [
                        $cedula,
                        $inicio->format('Y-m-d H:i:s'),
                        $fin->format('Y-m-d H:i:s'),
                        in_array('registrar_indicador', $permisos) ? 1 : 0,
                        in_array('registrar_resultado', $permisos) ? 1 : 0,
                        in_array('editar_indicador', $permisos) ? 1 : 0,
                        in_array('eliminar_indicador', $permisos) ? 1 : 0
                    ];

                    $stmt = sqlsrv_query(
                        $conexionGestionIndicadores,
                        $sql,
                        $params
                    );

                    if ($stmt === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    $mensaje = "Super Usuario Temporal asignado correctamente";
                }

                sqlsrv_free_stmt($stmtVal);
            }
        }
    }
}

 // =================== EDITAR FECHAS ===================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editarFechas'])) {

        $id = $_POST['id_su_temp'];
        $inicio = new DateTime($_POST['nueva_fecha_inicio']);
        $fin    = new DateTime($_POST['nueva_fecha_fin']);

        if ($fin < $inicio) {
            $mensaje = "La fecha final no puede ser menor a la inicial";
        } else {
            $diff = $inicio->diff($fin)->days;
            if ($diff > 183) {
                $mensaje = "El rango máximo permitido es de 6 meses";
            } else {
                $sqlUpdate = "
                    UPDATE super_usuario_temporal
                    SET fecha_inicio = ?, fecha_fin = ?
                    WHERE id_su_temp = ?
                ";

                $stmt = sqlsrv_query(
                    $conexionGestionIndicadores,
                    $sqlUpdate,
                    [
                        $inicio->format('Y-m-d H:i:s'),
                        $fin->format('Y-m-d H:i:s'),
                        $id
                    ]
                );

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                $mensaje = "Fechas del Super Usuario Temporal actualizadas correctamente";
            }
        }
    }

    // =================== ELIMINAR SU TEMPORAL ===================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminarSU'])) {

        $id = $_POST['id_su_temp'];

        $sqlDelete = "DELETE FROM super_usuario_temporal WHERE id_su_temp = ?";
        $stmt = sqlsrv_query($conexionGestionIndicadores, $sqlDelete, [$id]);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $mensaje = "Super Usuario Temporal eliminado correctamente";
    }

     // =================== PERMISOS SU TEMPORAL ===================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_permiso'])) {

        $id = $_POST['id_su_temp'];
        $permiso = $_POST['agregar_permiso'];

        $mapa = [
            'registrar_indicador' => 'p_registrar_indicador',
            'registrar_resultado' => 'p_registrar_resultado',
            'editar_indicador'    => 'p_editar_indicador',
            'eliminar_indicador'  => 'p_eliminar_indicador'
        ];

        if (isset($mapa[$permiso])) {

            $campo = $mapa[$permiso];

            $sql = "
                UPDATE super_usuario_temporal
                SET $campo = 1
                WHERE id_su_temp = ?
            ";

            $stmt = sqlsrv_query(
                $conexionGestionIndicadores,
                $sql,
                [$id]
            );

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $mensaje = "Permiso agregado correctamente";
        }
    }

    // =================== QUITAR PERMISOS SU TEMPORAL ===================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quitar_permiso'])) {

        $id = $_POST['id_su_temp'];
        $permiso = $_POST['quitar_permiso'];

        $mapa = [
            'registrar_indicador' => 'p_registrar_indicador',
            'registrar_resultado' => 'p_registrar_resultado',
            'editar_indicador'    => 'p_editar_indicador',
            'eliminar_indicador'  => 'p_eliminar_indicador'
        ];

        if (isset($mapa[$permiso])) {

            $campo = $mapa[$permiso];

            $sql = "
                UPDATE super_usuario_temporal
                SET $campo = 0
                WHERE id_su_temp = ?
            ";

            $stmt = sqlsrv_query(
                $conexionGestionIndicadores,
                $sql,
                [$id]
            );

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $mensaje = "Permiso retirado correctamente";
        }
    }



// Cargar usuarios NO super usuario
$sqlUsuarios = "
    SELECT Cedula, Nombres, Apellidos
    FROM persona
    WHERE super_usuario = 0
    ORDER BY Nombres
";

$usuarios = sqlsrv_query(
    $conexionGestionIndicadores,
    $sqlUsuarios
);

//Consultar SU temporales activos
$sqlSUTemporales = "
            SELECT 
            sut.id_su_temp,
            sut.Cedula,
            p.Nombres,
            p.Apellidos,
            sut.fecha_inicio,
            sut.fecha_fin,
            sut.p_registrar_indicador,
            sut.p_registrar_resultado,
            sut.p_editar_indicador,
            sut.p_eliminar_indicador
        FROM super_usuario_temporal sut
        INNER JOIN persona p ON sut.Cedula = p.Cedula
        WHERE GETDATE() BETWEEN sut.fecha_inicio AND sut.fecha_fin
        ORDER BY sut.fecha_fin ASC
        ";

$suTemporales = sqlsrv_query($conexionGestionIndicadores, $sqlSUTemporales);

?>



<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asignar SU Temporal</title>
    <link rel="stylesheet" href="{{ url_for('../static', filename='css/style.css')}}">
    <link rel="icon" type="image/x-icon" href="../assets/images/icon.jpg">
    <link rel="stylesheet" type="text/css" href="../static/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../static/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../static/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../static/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../static/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="{{ url_for('../static', filename='css/adminlte.min.css')}}">
    <link rel="stylesheet" href="../static/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="../static/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../static/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="../static/css/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href="../static/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles:wght@700&family=Source+Serif+Pro:ital,wght@1,600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../static/js/bootstrap.min.js"></script>

     <style>
      #password-hint,
      #password-match-hint {
      font-size: 0.9rem;
      margin-top: 5px;
      }
      .valid {
      color: green;
      font-weight: bold;
      }
      .invalid {
      color: red;
      font-weight: bold;
      }
    </style>
</head>



<body class="hold-transition sidebar-mini layout-fixed" style="background-image: url('../static/img/fondo3.png');background-size: cover;background-repeat: no-repeat; background-position: center;">
      
    <!--------------------------------------LOGO MALLAMAS CON ANIMACIONAL INICIO DE CADA VENTANA------------------------------------------------------->
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="../static/img/logonegro.png" alt="MllS" height="150" width="150">
        </div>
    </div>
    <!--------------------------------------------------------------------------------------------->

   <header>
        <nav id="navbar-example2" class="navbar px-3 mb-3" style="background-color: #038f03ff;">
            <a href="../index.php" class="brand-link">
                <img src="../static/img/CycLogo.png" alt="MLLS LOGO" class="brand-image">
            </a>
            <span style="color:white; font-weight:bold; margin-left:15px;">
               
            </span>
        </nav>
    </header>

        <br><br>
      <div class="row h-100 justify-content-center align-items-center ">
            <div class="card col-10 border-black" style="background-color: #F0F2EE;" >
                  <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example  p-3 rounded-2 text-black" tabindex="0">
                        <div class="card-group" align="center">
                              <div class="card bg-transparent " style="width: 18rem;">
                                <div class="card-body">
                                    <div class="alert alert-success border-dark text-black" role="alert">
                                        <b>ASIGNAR SUPER USUARIO TEMPORAL</b>
                                    </div>

                                    <!-- MENSAJE DE RESULTADO -->
                                    <?php if (!empty($mensaje)): ?>
                                        <script>
                                            alert("<?= addslashes($mensaje) ?>");
                                            window.history.replaceState({}, document.title, window.location.pathname);
                                        </script>
                                    <?php endif; ?>

                                    <form method="POST" action="AsignarSUTemp.php">
                                        <table class="table table-success table-striped">

                                            <tr align="center" valign="middle">
                                                <td>Seleccione Cedula de Usuario:</td>
                                                <td>
                                                    <select name="cedula" class="form-control" required>
                                                        <option value="">Seleccione un usuario</option>
                                                        <?php while ($u = sqlsrv_fetch_array($usuarios, SQLSRV_FETCH_ASSOC)): ?>
                                                            <option value="<?= $u['Cedula'] ?>">
                                                                <?= $u['Cedula'] ?> - <?= $u['Nombres'] ?> <?= $u['Apellidos'] ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr align="center" valign="middle">
                                                <td>Seleccione accesos:</td>
                                                <td>
                                                    Registrar Indicadores
                                                    <input type="checkbox" name="permisos[]" value="registrar_indicador"><br>

                                                    Registrar Resultado Indicadores
                                                    <input type="checkbox" name="permisos[]" value="registrar_resultado"><br>

                                                    Editar Indicadores
                                                    <input type="checkbox" name="permisos[]" value="editar_indicador"><br>

                                                    Eliminar Indicadores
                                                    <input type="checkbox" name="permisos[]" value="eliminar_indicador"><br>
                                                </td>
                                            </tr>

                                            <tr align="center" valign="middle">
                                                <td>Seleccione Rango de fechas de acceso:</td>
                                                <td>
                                                    <input type="date" name="fecha_inicio" required>
                                                    <input type="date" name="fecha_fin" required>
                                                </td>
                                            </tr>

                                            <tr align="center" valign="middle">
                                                <td>Activar SU Temporal:</td>
                                                <td>
                                                    <button class="btn btn-warning border-dark" type="submit" name="activarSU">
                                                        OK
                                                    </button>
                                                </td>
                                            </tr>

                                        </table>
                                        <hr>
                                        <div class="alert alert-info border-dark text-black">
                                            <b>SUPER USUARIOS TEMPORALES ACTIVOS</b>
                                        </div>

                                        

                                    </form>
                                    <table class="table table-bordered table-striped table-success">
                                            <thead class="table-dark">
                                                <tr align="center">
                                                    <th>Usuario</th>
                                                    <th>Desde</th>
                                                    <th>Hasta</th>
                                                    <th>Accesos concedidos</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($su = sqlsrv_fetch_array($suTemporales, SQLSRV_FETCH_ASSOC)): ?>
                                                <tr align="center">
                                                    <td><?= $su['Nombres'] ?> <?= $su['Apellidos'] ?></td>
                                                    <td><?= $su['fecha_inicio']->format('Y-m-d') ?></td>
                                                    <td><?= $su['fecha_fin']->format('Y-m-d') ?></td>
                                                    <td align="left">
                                                    <?php
                                                        $accesos = [];

                                                        if ($su['p_registrar_indicador']) {
                                                            $accesos[] = 'Registrar Indicadores';
                                                        }
                                                        if ($su['p_registrar_resultado']) {
                                                            $accesos[] = 'Registrar Resultados';
                                                        }
                                                        if ($su['p_editar_indicador']) {
                                                            $accesos[] = 'Editar Indicadores';
                                                        }
                                                        if ($su['p_eliminar_indicador']) {
                                                            $accesos[] = 'Eliminar Indicadores';
                                                        }

                                                        echo empty($accesos)
                                                            ? '<span class="text-danger">Sin accesos</span>'
                                                            : implode('<br>', $accesos);
                                                    ?>
                                                    <td>

                                                        <!-- EDITAR FECHAS -->
                                                        <form method="POST" style="display:inline;">
                                                            <input type="hidden" name="id_su_temp" value="<?= $su['id_su_temp'] ?>">
                                                            <input type="date" name="nueva_fecha_inicio" required>
                                                            <input type="date" name="nueva_fecha_fin" required>
                                                            <button class="btn btn-sm btn-primary" name="editarFechas">
                                                                <i class='fas fa-edit'></i>
                                                            </button>
                                                        </form>

                                                        <!-- ELIMINAR SU TEMP -->
                                                        <form method="POST" style="display:inline;" 
                                                            onsubmit="return confirm('¿Desea eliminar este Super Usuario Temporal?');">
                                                            <input type="hidden" name="id_su_temp" value="<?= $su['id_su_temp'] ?>">
                                                            <button class="btn btn-sm btn-danger" name="eliminarSU">
                                                               <i class='fas fa-trash'></i>
                                                            </button>
                                                        </form>

                                                        <!-- PERMISOS SU TEMP -->
                                                        <form method="POST" style="display:inline;">
                                                            <br>
                                                       
                                                            <input type="hidden" name="id_su_temp" value="<?= $su['id_su_temp'] ?>">

                                                            <br>
                                                        
                                                            <h6>PERMISOS</h6>

                                                            <!-- registrar_indicador -->
                                                            <?php if (!$su['p_registrar_indicador']): ?>
                                                                <button class="btn btn-sm btn-outline-success"
                                                                        name="agregar_permiso"
                                                                        value="registrar_indicador">
                                                                    + Registrar Indicadores
                                                                </button><br>
                                                            <?php else: ?>
                                                                <button class="btn btn-sm btn-outline-danger"
                                                                        name="quitar_permiso"
                                                                        value="registrar_indicador"
                                                                        onclick="return confirm('¿Desea quitar este permiso?');">
                                                                    − Quitar Registrar Indicadores
                                                                </button><br>
                                                            <?php endif; ?>

                                                            <!--  registrar_resultado -->
                                                            <?php if (!$su['p_registrar_resultado']): ?>
                                                                <button class="btn btn-sm btn-outline-success"
                                                                        name="agregar_permiso"
                                                                        value="registrar_resultado">
                                                                    + Registrar Resultado Indicadores
                                                                </button><br>
                                                            <?php else: ?>
                                                                <button class="btn btn-sm btn-outline-danger"
                                                                        name="quitar_permiso"
                                                                        value="registrar_resultado"
                                                                        onclick="return confirm('¿Desea quitar este permiso?');">
                                                                    − Quitar Registrar Resultado Indicadores
                                                                </button><br>
                                                            <?php endif; ?>

                                                            <!--  editar_indicador -->
                                                            <?php if (!$su['p_editar_indicador']): ?>
                                                                <button class="btn btn-sm btn-outline-success"
                                                                        name="agregar_permiso"
                                                                        value="editar_indicador">
                                                                    + Editar Indicadores
                                                                </button><br>
                                                            <?php else: ?>
                                                                <button class="btn btn-sm btn-outline-danger"
                                                                        name="quitar_permiso"
                                                                        value="editar_indicador">
                                                                    − Quitar Editar Indicadores
                                                                </button><br>
                                                            <?php endif; ?>

                                                            <!--  eliminar_indicador -->
                                                            <?php if (!$su['p_eliminar_indicador']): ?>
                                                                <button class="btn btn-sm btn-outline-success"
                                                                        name="agregar_permiso"
                                                                        value="eliminar_indicador">
                                                                    + Eliminar Indicadores
                                                                </button><br>
                                                            <?php else: ?>
                                                                <button class="btn btn-sm btn-outline-danger"
                                                                        name="quitar_permiso"
                                                                        value="eliminar_indicador"
                                                                        onclick="return confirm('¿Desea quitar este permiso?');">
                                                                    − Quitar Eliminar Indicadores
                                                                </button><br>
                                                            <?php endif; ?>
                                                        </form>

                                                        

                                                    
                                                                

                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>

                                </div>

                              </div>
                        </div>
                  </div>
            </div>
      </div>







    <script src="../static/plugins/jquery/jquery.min.js"></script>
    <script src="../static/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="../static/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../static/plugins/chart.js/Chart.min.js"></script>
    <script src="../static/plugins/sparklines/sparkline.js"></script>
    <script src="../static/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../static/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="../static/plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="../static/plugins/moment/moment.min.js"></script>
    <script src="../static/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="../static/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="../static/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="../static/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="../static/js/adminlte.js"></script>
    <script src="../static/js/pages/dashboard.js"></script>
    <script src="../static/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="../static/js/adminlte.min.js"></script>   
   
</body>
</html>
