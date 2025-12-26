<?php
include '../bd/conexion.php';

// Recibir datos del formulario
$cedula         = $_POST["cedula"];
$nombre         = $_POST["nombre"];
$apellidos      = $_POST["apellidos"];
$codigoUsuario  = $_POST["codigoUsuario"];
$correo         = $_POST["correo"];
$telefono       = $_POST["telefono"];
$ciudad         = $_POST["ciudad"];
$credencial     = $_POST["credencial"];
$cargo          = $_POST["cargo"];
$password       = $_POST["contraseña"];
$repitepassword = $_POST["repitecontraseña"];
$super_usuario = isset($_POST['super_usuario']) ? 1 : 0;
$procesosSeleccionados = isset($_POST["procesos"]) ? $_POST["procesos"] : [];
$CoordinacionesSeleccionadas = isset($_POST["coordinaciones"]) ? $_POST["coordinaciones"] : [];

// Validar contraseñas
if ($password !== $repitepassword) {
    echo '<script>alert("Las contraseñas no coinciden");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';
    exit;
}

// Validar credencial maestra (si aplica)
if ($credencial != 111) {
    echo '<script>alert("Credencial incorrecta");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';
    exit;
}

// Encriptar contraseña
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// Validar que haya procesos seleccionados
if (empty($procesosSeleccionados)) {
    echo '<script>alert("Debe seleccionar al menos un proceso");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';
    exit;
}

// Validar que haya coordinaciones seleccionadas
if (empty($CoordinacionesSeleccionadas)) {
    echo '<script>alert("Debe seleccionar al menos una coordinacion");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';
    exit;
}


// Verificar si ya existe la persona
$consultaCedula = "SELECT Cedula FROM persona WHERE Cedula = ?";
$stmtCedula = sqlsrv_query($conexionGestionIndicadores, $consultaCedula, [$cedula]);
if ($stmtCedula && sqlsrv_fetch_array($stmtCedula, SQLSRV_FETCH_ASSOC)) {
    echo '<script>alert("Ya existe una persona registrada con esa cédula");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';
    exit;
}

// Iniciar transacción
sqlsrv_begin_transaction($conexionGestionIndicadores);

try {
    // 1Insertar persona
    $sqlPersona = "INSERT INTO persona 
        (Cedula, Nombres, Apellidos, Correo, Telefono, Ciudad, codigoUsuario, Credencial, Cargo, Password, super_usuario)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $paramsPersona = [
        $cedula,
        $nombre,
        $apellidos,
        $correo,
        $telefono,
        $ciudad,
        $codigoUsuario,
        $credencial,
        $cargo,
        $passwordHash,
        $super_usuario
    ];

    $ok1 = sqlsrv_query($conexionGestionIndicadores, $sqlPersona, $paramsPersona);
    if (!$ok1) {
        throw new Exception("Error al insertar en persona: " . print_r(sqlsrv_errors(), true));
    }

    // 2.1 Insertar los procesos seleccionados en persona_proceso
    $sqlRelacion = "INSERT INTO persona_proceso (Cedula, idProceso) VALUES (?, ?)";
    foreach ($procesosSeleccionados as $idProceso) {
        $ok2 = sqlsrv_query($conexionGestionIndicadores, $sqlRelacion, [$cedula, $idProceso]);
        if (!$ok2) {
            throw new Exception("Error al insertar proceso {$idProceso}: " . print_r(sqlsrv_errors(), true));
        }
    }

    // 2.2 Insertar lss coordinaciones seleccionadas en persona_coordinacion 
    $sqlRelacion2 = "INSERT INTO persona_coordinacion (Cedula, idCoordinacion) VALUES (?, ?)";
    foreach ($CoordinacionesSeleccionadas as $idCoordinacion) {
        $ok3 = sqlsrv_query($conexionGestionIndicadores, $sqlRelacion2, [$cedula, $idCoordinacion]);
        if (!$ok3) {
            throw new Exception("Error al insertar coordinacion {$idCoordinacion}: " . print_r(sqlsrv_errors(), true));
        }
    }

    // 3Confirmar cambios
    sqlsrv_commit($conexionGestionIndicadores);

    echo '<script>alert("✅ Usuario registrado correctamente con sus procesos y coordinaciones.");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';

} catch (Exception $e) {
    sqlsrv_rollback($conexionGestionIndicadores);
    echo "❌ Error en el registro:<br>" . $e->getMessage();
}

// Cerrar conexión
sqlsrv_close($conexionGestionIndicadores);
?>
