<?php
include '../bd/conexion.php';

// 🔹 Recibir datos del formulario
$cedula         = $_POST["cedula"];
$nombre         = $_POST["nombre"];
$apellidos      = $_POST["apellidos"];
$codigoUsuario  = $_POST["codigoUsuario"];
$correo         = $_POST["correo"];
$telefono       = $_POST["telefono"];
$direccion      = $_POST["direccion"];
$ciudad         = $_POST["ciudad"];
$credencial     = $_POST["credencial"];
$cargo          = $_POST["cargo"];
$password       = $_POST["contraseña"];
$repitepassword = $_POST["repitecontraseña"];
$super_usuario = isset($_POST['super_usuario']) ? 1 : 0;
$procesosSeleccionados = isset($_POST["procesos"]) ? $_POST["procesos"] : [];

// 🔹 Validar contraseñas
if ($password !== $repitepassword) {
    echo '<script>alert("Las contraseñas no coinciden");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';
    exit;
}

// 🔹 Validar credencial maestra (si aplica)
if ($credencial != 111) {
    echo '<script>alert("Credencial incorrecta");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';
    exit;
}

// 🔹 Encriptar contraseña
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// 🔹 Validar que haya procesos seleccionados
if (empty($procesosSeleccionados)) {
    echo '<script>alert("Debe seleccionar al menos un proceso");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';
    exit;
}

// 🔹 Verificar si ya existe la persona
$consultaCedula = "SELECT Cedula FROM persona WHERE Cedula = ?";
$stmtCedula = sqlsrv_query($conexionGestionIndicadores, $consultaCedula, [$cedula]);
if ($stmtCedula && sqlsrv_fetch_array($stmtCedula, SQLSRV_FETCH_ASSOC)) {
    echo '<script>alert("Ya existe una persona registrada con esa cédula");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';
    exit;
}

// 🔹 Iniciar transacción
sqlsrv_begin_transaction($conexionGestionIndicadores);

try {
    // 1️⃣ Insertar persona
    $sqlPersona = "INSERT INTO persona 
        (Cedula, Nombres, Apellidos, Correo, Telefono, Direccion, Ciudad, codigoUsuario, Credencial, Cargo, Password, super_usuario)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $paramsPersona = [
        $cedula,
        $nombre,
        $apellidos,
        $correo,
        $telefono,
        $direccion,
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

    // 2️⃣ Insertar los procesos seleccionados en persona_proceso
    $sqlRelacion = "INSERT INTO persona_proceso (Cedula, idProceso) VALUES (?, ?)";
    foreach ($procesosSeleccionados as $idProceso) {
        $ok2 = sqlsrv_query($conexionGestionIndicadores, $sqlRelacion, [$cedula, $idProceso]);
        if (!$ok2) {
            throw new Exception("Error al insertar proceso {$idProceso}: " . print_r(sqlsrv_errors(), true));
        }
    }

    // 3️⃣ Confirmar cambios
    sqlsrv_commit($conexionGestionIndicadores);

    echo '<script>alert("✅ Usuario registrado correctamente con sus procesos.");window.location.href="../RegistrarUsuarios/RegistroUsuarioGI.php"</script>';

} catch (Exception $e) {
    sqlsrv_rollback($conexionGestionIndicadores);
    echo "❌ Error en el registro:<br>" . $e->getMessage();
}

// Cerrar conexión
sqlsrv_close($conexionGestionIndicadores);
?>
