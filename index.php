

<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Usuarios</title>

    <link rel="icon" type="image/x-icon" href="assets/images/icon.jpg">
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="static/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="static/css/adminlte.min.css">
    <link rel="stylesheet" href="static/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="static/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

    

    <style>
      .card-img-top {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
      }

      .card-img-top:hover {
        transform: scale(1.15);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
      }

      .footer-fixed {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #fff;
        border-top: 1px solid #ddd;
        text-align: center;
        padding: 10px;
        z-index: 1030;
      }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed" 
      style="background-image: url('static/img/fondo3.png');
             background-size: cover;background-repeat: no-repeat; background-position: center;">

    <!--------------------------------------LOGO INICIO------------------------------------------------------>
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="static/img/logonegro.png" alt="MllS" height="150" width="150">
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------>




   <header>
        <nav id="navbar-example2" class="navbar px-3 mb-3" style="background-color: #038f03ff;">
            <a href="index.php" class="brand-link">
                <img src="static/img/CycLogo.png" alt="MLLS LOGO" class="brand-image ">
            </a>
            <span style="color:white; font-weight:bold; margin-left:15px;">
              MENU DE REGISTROS
            </span>
        </nav>
    </header>

    <br><br>

	<div class="row h-100 justify-content-center align-items-center ">
		<div class="card col-6 border-black" style="background-color: #F0F2EE;" >
		
			<div class="p-10 rounded-2 text-black" tabindex="0">

				<div class="card mb-10">
					<div class="row g-0" style="background-color: #DADED6;">
                        <h4 align="center"><b><i>REGISTRO DE USUARIOS EN LOS MODULOS </i></b></h4>

						<div class="col-100">
							<div class="container" align="center">
								<br>

								<table class="table table-striped">
									<tr>
										<td><h5>REGISTRAR USUARIOS TABLEROS DE CONTROL</h5></td>
										<td>
											<a href="#" onclick="accesoProtegido('tc')" class="btn btn-success w-100">Ir</a>
										</td>
									</tr>

									<tr>
										<td><h5>REGISTRAR USUARIOS MATRIZ DE INDICADORES</h5></td>
										<td>
											<a href="#" onclick="accesoProtegido('gi')" class="btn btn-success w-100">Ir</a>
										</td>
									</tr>

                                    <tr>
										<td><h5>SOLICITUDES DE REGISTRO</h5></td>
										<td>
											<a href="RegistrarUsuarios/SolicitudesRegistro.php" class="btn btn-success w-100">Ir</a>
										</td>
									</tr>

								</table>

							</div>
						</div>

					</div>
				</div>
                
			</div>
	  	
		</div>
	</div>

	
	<!-------------------------------------------FOOTER-------------------------------------------------->
    <footer class="footer-fixed">
      <strong>Copyright &copy; 2025 <a target="_blank">COORDINACIÓN ESTADÍSTICA</a></strong> Todos los derechos reservados.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.1.0
      </div>
    </footer>




    <!-------------------------------------------SCRIPTS-------------------------------------------------->
    <script>
        // CLAVES POR MÓDULO
        const CLAVES = {
            tc: "Estadistica*2025",
            gi: "Calidad*2025"
        };

        function accesoProtegido(tipo) {
            const claveCorrecta = CLAVES[tipo];

            let claveIngresada = prompt("Ingrese la clave para acceder:");
            if (claveIngresada === null) return; // cancelado

            if (claveIngresada === claveCorrecta) {

                // Marcar acceso autorizado
                fetch("php/set_acceso_registro.php", { method: "POST" })
                    .then(() => {
                        if (tipo === "tc") {
                            window.location.href = "RegistrarUsuarios/RegistroUsuarioTC.php";
                        }
                        if (tipo === "gi") {
                            window.location.href = "RegistrarUsuarios/RegistroUsuarioGI.php";
                        }
                    });

            } else {
                alert("❌ Clave incorrecta. Acceso denegado.");
            }
        }
    </script>
    <script>
        // Evita volver a páginas anteriores
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, "", window.location.href);
        };
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
    <script src="static/plugins/jquery/jquery.min.js"></script>
    <script src="static/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="static/js/adminlte.min.js"></script>

</body>

</html>
