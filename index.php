<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="{{ url_for('static', filename='css/style.css')}}">
    <link rel="icon" type="image/x-icon" href="assets/images/icon.jpg">
    <link rel="stylesheet" type="text/css" href="static/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="static/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="static/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="static/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="static/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="{{ url_for('static', filename='css/adminlte.min.css')}}">
    <link rel="stylesheet" href="static/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="static/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="static/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="static/css/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles:wght@700&family=Source+Serif+Pro:ital,wght@1,600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script type="text/javascript" src="static/js/bootstrap.min.js"></script>

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
        /* puedes cambiar el color */
        border-top: 1px solid #ddd;
        text-align: center;
        padding: 10px;
        z-index: 1030;
        /* asegura que quede encima de otros elementos */
      }
    </style>
	

</head>

<body class="hold-transition sidebar-mini layout-fixed" style="background-image: url('static/img/fondo3.png');background-size: cover;background-repeat: no-repeat; background-position: center;">

    <!--------------------------------------LOGO MALLAMAS CON ANIMACIONAL INICIO DE CADA VENTANA------------------------------------------------------->
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="static/img/logonegro.png" alt="MllS" height="150" width="150">
        </div>
    </div>
    <!--------------------------------------------------------------------------------------------->




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
		
			<div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -100%" data-bs-smooth-scroll="true" class="scrollspy-example  p-10 rounded-2 text-black" tabindex="0">
				<p>
					
					<div class="card mb-10">
						<div class="row g-0" style="background-color: #DADED6;">
                            <h4 id="scrollspyHeading1" align="center"><b><i>REGISTRO DE USUARIOS EN LOS MODULOS </i></b></h4>
							<div class="col-100">
								
									<div class="container" align="center">
										<br>
										<table class="table table-striped width: 100%;">
                      <tr align="left" valign="middle">
												<td>
													<h5>REGISTRAR USUARIOS TABLEROS DE CONTROL</h5>
												</td>
                          <td>
                             <a href="RegistrarUsuarios/RegistroUsuarioTC.php" class="btn btn-success w-100 " name="enviar" >Ir</a>
												</td>
											</tr>
                      <tr align="left" valign="middle">
												<td>
													<h5>REGISTRAR USUARIOS MATRIZ DE INDICADORES</h5>
												</td>
                          <td>
                             <a href="RegistrarUsuarios/RegistroUsuarioGI.php" class="btn btn-success w-100 " name="enviar" >Ir</a>
												</td>
											</tr>
                       <tr align="left" valign="middle">
												<td>
													<h5>SOLICITUDES DE REGISTRO</h5>
												</td>
                          <td>
                             <a href="RegistrarUsuarios/SolicitudesRegistro.php" class="btn btn-success w-100 " name="enviar" >Ir</a>
												</td>
											</tr>
										</table>
                                        
									</div>
                                    
								
                                
							</div>
						</div>
					</div>
					
				</p>
                
			</div>
	  	
		</div>
	</div>

	
	<!-------------------------------------------BARRA FINAL COPYRIGHT-------------------------------------------------->
    <footer class="footer-fixed">
      <strong>Copyright &copy; 2025 <a target="_blank">COORDINACIÓN ESTADÍSTICA</a></strong> Todos los derechos
      reservados.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.1.0
      </div>
    </footer>
    <aside class="control-sidebar control-sidebar-dark"></aside>
    <!--------------------------------------------------------------------------------------------->
      
    <script src="static/plugins/jquery/jquery.min.js"></script>
    <script src="static/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="static/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="static/plugins/chart.js/Chart.min.js"></script>
    <script src="static/plugins/sparklines/sparkline.js"></script>
    <script src="static/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="static/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="static/plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="static/plugins/moment/moment.min.js"></script>
    <script src="static/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="static/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="static/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="static/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="static/js/adminlte.js"></script>
    <script src="static/js/pages/dashboard.js"></script>
    <script src="static/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="static/js/adminlte.min.js"></script>   
    <script src="static/js/confirmacion.js"></script>
</body>



</html>
