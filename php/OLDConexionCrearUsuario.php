<?php
include '../bd/conexion.php';

// 🔹 Recibir datos del formulario
$cedula         = $_POST["cedula"];
$nombre         = $_POST["nombre"];
$apellidos      = $_POST["apellidos"];
$codigoGeneral  = $_POST["codigoAtencionUsuario"]; // Usamos este como base para los códigos
$correo         = $_POST["correo"];
$telefono       = $_POST["telefono"];
$direccion      = $_POST["direccion"];
$ciudad         = $_POST["ciudad"];
$credencial     = $_POST["credencial"];
$cargo          = $_POST["cargo"];
$password       = $_POST["contraseña"];
$repitepassword = $_POST["repitecontraseña"];
$tablerosSeleccionados = isset($_POST["tableros"]) ? $_POST["tableros"] : [];

// 🔹 Validar contraseñas
if ($password !== $repitepassword) {
    echo '<script>alert("Las contraseñas no coinciden");window.location.href="../RegistrarUsuarios/RegistroUsuarios.php"</script>';
    exit;
}

// 🔹 Validar credencial maestra (si aplica)
if ($credencial != 111) {
    echo '<script>alert("Credencial incorrecta");window.location.href="../RegistrarUsuarios/RegistroUsuarios.php"</script>';
    exit;
}

// 🔹 Encriptar contraseña
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// 🔹 Verificar si ya existe la persona
$consultaCedula = "SELECT Cedula FROM persona WHERE Cedula = ?";
$stmtCedula     = sqlsrv_query($conexion, $consultaCedula, [$cedula]);
$rowCedula      = sqlsrv_fetch_array($stmtCedula, SQLSRV_FETCH_ASSOC);

if ($rowCedula) {
    echo '<script>alert("Ya existe una persona registrada con esa cédula");window.location.href="../RegistrarUsuarios/RegistroUsuarios.php"</script>';
    exit;
}

// 🔹 Iniciar transacción
sqlsrv_begin_transaction($conexion);

try {
    // 1️⃣ Insertar en persona (siempre)
    $sqlPersona = "INSERT INTO persona (Cedula, Nombres, Apellidos, Correo, Telefono, Direccion, Ciudad)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $paramsPersona = [$cedula, $nombre, $apellidos, $correo, $telefono, $direccion, $ciudad];
    $ok1 = sqlsrv_query($conexion, $sqlPersona, $paramsPersona);

    if (!$ok1) {
        throw new Exception("Error al insertar en persona: " . print_r(sqlsrv_errors(), true));
    }

    // 2️⃣ Insertar en las tablas seleccionadas
    if (!empty($tablerosSeleccionados)) {

        // 🔹 Mapeo exacto según tus nombres reales de tablas
        $mapaTablas = [
            'ATENCION AL USUARIO'               => 'AtencionUsuario',
            'ALMACEN'                           => 'Almacen',
            'ASEGURAMIENTO'                     => 'Aseguramiento',
            'SISTEMAS INTEGRADOS'               => 'SistemasIntegrados',
            'CARTERA'                           => 'Cartera',
            'COMUNICACIONES'                    => 'Comunicaciones',
            'CONTABILIDAD'                      => 'Contabilidad',
            'SAOS'                              => 'Saos',
            'CONTRATACIONES'                    => 'Contrataciones',
            'TABLEROS'                          => 'TablerosU',
            'SISTEMAS'                          => 'Sistemas',
            'GESTION DEL RIESGO'                => 'GestionRiesgo',
            'PLANEACION'                        => 'Planeacion',
            'RADICACION Y AUDITORIA DE CUENTAS' => 'RadAudCuentas',
            'RECOBROS'                          => 'Recobros',
            'TESORERIA'                         => 'Tesoreria'
        ];

        foreach ($tablerosSeleccionados as $idTablero) {
            // Obtener el nombre del tablero según su ID
            $sqlNombre = "SELECT NombreTablero FROM Tableros WHERE IdTableros = ?";
            $stmtNombre = sqlsrv_query($conexion, $sqlNombre, [$idTablero]);
            $rowNombre = sqlsrv_fetch_array($stmtNombre, SQLSRV_FETCH_ASSOC);

            if ($rowNombre) {
                $nombreTableroBD = strtoupper(trim($rowNombre['NombreTablero'])); // Mayúsculas limpias

                // Verificar si existe mapeo
                if (isset($mapaTablas[$nombreTableroBD])) {
                    $nombreTabla = $mapaTablas[$nombreTableroBD];
                    $campoCodigo = "codigo" . $nombreTabla; // Ejemplo: codigoAtencionUsuario

                    // Insertar en la tabla correspondiente
                    $sqlInsert = "INSERT INTO [$nombreTabla] ($campoCodigo, Cedula, Credencial, Cargo, Password)
                                  VALUES (?, ?, ?, ?, ?)";
                    $paramsInsert = [$codigoGeneral, $cedula, $credencial, $cargo, $passwordHash];
                    $ok2 = sqlsrv_query($conexion, $sqlInsert, $paramsInsert);

                    if (!$ok2) {
                        throw new Exception("Error al insertar en la tabla $nombreTabla: " . print_r(sqlsrv_errors(), true));
                    }
                } else {
                    throw new Exception("No existe mapeo para el tablero: $nombreTableroBD");
                }
            }
        }
    } else {
        throw new Exception("Debe seleccionar al menos un tablero para registrar al usuario.");
    }

    // ✅ Confirmar transacción
    sqlsrv_commit($conexion);
    echo '<script>alert("✅ Usuario creado exitosamente en las tablas seleccionadas");window.location.href="../index.php"</script>';

} catch (Exception $e) {
    sqlsrv_rollback($conexion);
    echo "❌ Error en el registro:<br>" . $e->getMessage();
}

sqlsrv_close($conexion);
?>
