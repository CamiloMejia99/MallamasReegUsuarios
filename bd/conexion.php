<?php

    // // ============================================
    // // CONEXIÓN A BASE DE DATOS MALLAMASADMIN
    // // (Para el módulo: REGISTRAR USUARIOS TABLEROS DE CONTROL)
    // // ============================================

    // $serverName = "CAMILO\\SQLEXPRESS"; 

    // $connectionOptionsMallamas = [
    //     "Database" => "MallamasAdmin",
    //     "TrustServerCertificate" => true
    // ];

    // $conexionMallamas = sqlsrv_connect($serverName, $connectionOptionsMallamas);

    // if ($conexionMallamas === false) {
    //     error_log(print_r(sqlsrv_errors(), true));
    //     die("❌ Error en la conexión a la base de datos MallamasAdmin.");
    // }


    // // ============================================
    // // CONEXIÓN A BASE DE DATOS SIRIS_EPS
    // // (Para el módulo: REGISTRAR USUARIOS MATRIZ DE INDICADORES)
    // // ============================================

    // $connectionOptionsSiris = [
    //     "Database" => "DB_GESTION_INDICADORES",
    //     "TrustServerCertificate" => true
    // ];

    // $conexionSiris = sqlsrv_connect($serverName, $connectionOptionsSiris);

    // if ($conexionSiris === false) {
    //     error_log(print_r(sqlsrv_errors(), true));
    //     die("❌ Error en la conexión a la base de datos SIRIS_EPS.");
    // }


    /*============================================
    CONEXIÓN A BASE DE DATOS MALLAMASADMIN
    (Para el módulo: REGISTRAR USUARIOS TABLEROS DE CONTROL)
    ============================================*/

    $serverName = "ESTADISTICA01"; 

    $connectionOptionsMallamas = [
        "Database" => "MallamasAdmin",
        "TrustServerCertificate" => true
    ];

    $conexionMallamas = sqlsrv_connect($serverName, $connectionOptionsMallamas);

    if ($conexionMallamas === false) {
        error_log(print_r(sqlsrv_errors(), true));
        die("❌ Error en la conexión a la base de datos MallamasAdmin.");
    }


   /* ============================================
    CONEXIÓN A BASE DE DATOS SIRIS_EPS
    (Para el módulo: REGISTRAR USUARIOS MATRIZ DE INDICADORES)
    ============================================*/

    $connectionOptionsSiris = [
        "Database" => "DB_GESTION_INDICADORES",
        "TrustServerCertificate" => true
    ];

    $conexionGestionIndicadores = sqlsrv_connect($serverName, $connectionOptionsSiris);

    if ($conexionGestionIndicadores === false) {
        error_log(print_r(sqlsrv_errors(), true));
        die("❌ Error en la conexión a la base de datos SIRIS_EPS.");
    }

    // // ============================================
    // // CONEXIÓN A BASE DE DATOS DB_GESTION_TABLEROS_CONTROL
    // // (Para el módulo: REGISTRAR USUARIOS TABLEROS DE CONTROL)
    // // ============================================

    // $serverName = "172.17.1.120";

    // $connectionOptionsMallamas = [
    //     "Database" => "DB_GESTION_TABLEROS_CONTROL",
    //     "UID" => "Estadistica",            
    //     "PWD" => 'E$tadi$tica*2025',     
    //     "TrustServerCertificate" => true
    // ];

    // $conexionMallamas = sqlsrv_connect($serverName, $connectionOptionsMallamas);

    // if ($conexionMallamas === false) {
    //     error_log(print_r(sqlsrv_errors(), true));
    //     die("❌ Error en la conexión a la base de datos MallamasAdmin.");
    // }


    // // ============================================
    // // CONEXIÓN A BASE DE DATOS SIRIS_EPS
    // // (Para el módulo: REGISTRAR USUARIOS MATRIZ DE INDICADORES)
    // // ============================================

    // $connectionOptionsSiris = [
    //     "Database" => "DB_GESTION_INDICADORES",
    //     "UID" => "Estadistica",            
    //     "PWD" => 'E$tadi$tica*2025',     
    //     "TrustServerCertificate" => true
    // ];

    // $conexionGestionIndicadores = sqlsrv_connect($serverName, $connectionOptionsSiris);

    // if ($conexionGestionIndicadores === false) {
    //     error_log(print_r(sqlsrv_errors(), true));
    //     die("❌ Error en la conexión a la base de datos SIRIS_EPS.");
    // }

?>