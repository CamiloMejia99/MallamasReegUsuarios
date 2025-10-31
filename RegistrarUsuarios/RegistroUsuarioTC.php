
<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro Usuarios</title>
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
                                               <B> REGISTRO PERSONAL USUARIOS GESTION TABLEROS DE CONTROL</B>
                                          </div>
                                          <form class="row g-3" name="nuevo usuario" method="POST" action="../php/ConexionCrearUsuarioTC.php">
                                                <table class="table table-success table-striped">
                                                      <tr align="center" valign="middle">
                                                            <td>
                                                                  Cedula:
                                                            </td>
                                                            <td>
                                                                  <input type="number" name="cedula" placeholder="Cedula" class="form-control" id="validationDefault01" required>
                                                            </td>
                                                            <td>
                                                                  Nombres:
                                                            </td>
                                                            <td>
                                                                  <input type="text" name="nombre" placeholder="Nombres" class="form-control" id="validationDefault01" required>
                                                            </td>
                                                            <td>
                                                                  Apellidos:
                                                            </td>
                                                            <td>
                                                                  <input type="text" name="apellidos" placeholder="Apellidos" class="form-control" id="validationDefault02" required>
                                                            </td>
                                                      </tr>
                                                      <tr align="center" valign="middle">
                                                            <td>
                                                                  Nombre de Usuario:
                                                            </td>
                                                            <td>
                                                                  <input type="text" name="codigoAtencionUsuario" placeholder="Nombre de Usuario" class="form-control" id="validationDefault05" required>
                                                            </td>
                                                            <td>
                                                                  Correo:
                                                            </td>
                                                            <td>
                                                                  <div class="input-group">
                                                                        <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                                                        <input type="email" name="correo" placeholder="Email" class="form-control" id="validationDefaultUsername"  aria-describedby="inputGroupPrepend2" required>
                                                                  </div>
                                                            </td>
                                                            <td>
                                                                  Telefono:
                                                            </td>
                                                            <td>
                                                                  <input type="phone" name="telefono" placeholder="Telefono" class="form-control" id="validationDefault05" required>
                                                            </td>
                                                      </tr>
                                                      <tr align="center" valign="middle">
                                                            <td>
                                                                  Dependencia:
                                                            </td>
                                                            <td>
                                                                  <input type="text" name="direccion" placeholder="Dependencia" class="form-control" id="validationDefault05" required>
                                                            </td>
                                                            <td>
                                                                  Ciudad:
                                                            </td>
                                                            <td>
                                                                  <input type="text" name="ciudad" placeholder="Ciudad" class="form-control" id="validationDefault05" required>
                                                            </td>
                                                            <td>
                                                                  Credencial:
                                                            </td>
                                                            <td>
                                                                  <input type="password" name="credencial" placeholder="Credencial" class="form-control" id="validationDefault05" required>
                                                            </td>
                                                      </tr>
                                                      <tr align="center" valign="middle">
                                                            <td>
                                                                  Cargo:
                                                            </td>
                                                            <td>
                                                                  <input type="text" name="cargo" placeholder="Cargo" class="form-control" id="validationDefault05" required>
                                                            </td>
                                                            <td>
                                                                  Contraseña:
                                                            </td>
                                                            <td>
                                                                 <div class="input-group">
                                                                  <input type="password" id="password" name="contraseña" class="form-control" 
                                                                        placeholder="Contraseña" data-bs-toggle="tooltip" title="Debe tener mínimo 8 caracteres, mayúscula, número y símbolo" required>
                                                                  <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                                        <i class="fas fa-eye"></i>
                                                                  </button>
                                                                  </div>
                                                            </td>
                                                            <td>
                                                                  Repite Contraseña:
                                                            </td>
                                                            <td>
                                                                  <div class="input-group">
                                                                  <input type="password" id="confirm-password" name="repitecontraseña" class="form-control" 
                                                                        placeholder="Repite contraseña" data-bs-toggle="tooltip" title="Debe coincidir con la contraseña" required>
                                                                  <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                                        <i class="fas fa-eye"></i>
                                                                  </button>
                                                                  </div>
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td colspan="6">
                                                                <div class="alert alert-info border-dark text-black mt-3" role="alert">
                                                                    <b>Seleccione los tableros a los que tendrá acceso:</b>
                                                                </div>

                                                                <?php
                                                                include('../bd/conexion.php');
                                                                $query = sqlsrv_query($conexionMallamas, "SELECT IdTableros, NombreTablero FROM Tableros");
                                                                if ($query) {
                                                                    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                                                        echo '
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="tableros[]" id="tablero'.$row['IdTableros'].'" value="'.$row['IdTableros'].'">
                                                                            <label class="form-check-label" for="tablero'.$row['IdTableros'].'">'.$row['NombreTablero'].'</label>
                                                                        </div>';
                                                                    }
                                                                } else {
                                                                    echo '<p class="text-danger">Error al cargar los tableros.</p>';
                                                                }
                                                                ?>
                                                            </td>
                                                      </tr>
                                                      <tr align="center" valign="middle">
                                                            <td colspan="10">
                                                                  <button class="btn btn-success border-dark"  type="submit" name="enviar">ok</button>
                                                            </td>
                                                      </tr>
                                                      <br>
                                                      <table align="center">
                                                            <td>
                                                             <a href="../index.php" class="btn btn-danger border-dark text-white">Salir</a>
                                                            </td>
                                                      </table>
                                                </table>	
                                          </form>
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
       <script>
      document.addEventListener("DOMContentLoaded", () => {
      const passwordInput = document.getElementById("password");
      const confirmPasswordInput = document.getElementById("confirm-password");
      const togglePassword = document.getElementById("togglePassword");
      const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");

      const regex = {
            upper: /[A-Z]/,
            number: /[0-9]/,
            special: /[!@#$%^&*(),.?":{}|<>]/
      };

      // Inicializar tooltips Bootstrap
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

      // Función para actualizar tooltip dinámicamente
      function updateTooltip(el, messages) {
            const tooltip = bootstrap.Tooltip.getInstance(el);
            el.setAttribute("data-bs-original-title", messages);
            tooltip.setContent({ '.tooltip-inner': messages });
      }

      // Validar seguridad de la contraseña
      passwordInput.addEventListener("input", () => {
            const value = passwordInput.value;
            let messages = [];

            if (value.length < 8) messages.push("Mínimo 8 caracteres");
            if (!regex.upper.test(value)) messages.push("Al menos una mayúscula");
            if (!regex.number.test(value)) messages.push("Al menos un número");
            if (!regex.special.test(value)) messages.push("Al menos un caracter especial");

            if (messages.length === 0) {
                  updateTooltip(passwordInput, "✔ Contraseña válida");
            } else {
                  updateTooltip(passwordInput, messages.join(" • "));
            }
      });

      // Validar coincidencia
      function checkPasswordMatch() {
            if (passwordInput.value === confirmPasswordInput.value) {
                  updateTooltip(confirmPasswordInput, "✔ Las contraseñas coinciden");
            } else {
                  updateTooltip(confirmPasswordInput, "✖ Las contraseñas no coinciden");
            }
      }

      passwordInput.addEventListener("input", checkPasswordMatch);
      confirmPasswordInput.addEventListener("input", checkPasswordMatch);

      // Botón ojito para contraseña
      togglePassword.addEventListener("click", function () {
            const icon = this.querySelector("i");
            if (passwordInput.type === "password") {
                  passwordInput.type = "text";
                  icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                  passwordInput.type = "password";
                  icon.classList.replace("fa-eye-slash", "fa-eye");
            }
      });

      // Botón ojito para repetir contraseña
      toggleConfirmPassword.addEventListener("click", function () {
            const icon = this.querySelector("i");
            if (confirmPasswordInput.type === "password") {
                  confirmPasswordInput.type = "text";
                  icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                  confirmPasswordInput.type = "password";
                  icon.classList.replace("fa-eye-slash", "fa-eye");
            }
      });

      // Validar al enviar formulario
      document.querySelector("form").addEventListener("submit", (e) => {
            let pass = passwordInput.value;
            if (
                  pass.length < 8 ||
                  !regex.upper.test(pass) ||
                  !regex.number.test(pass) ||
                  !regex.special.test(pass)
            ) {
                  e.preventDefault();
                  alert("La contraseña no cumple los requisitos.");
                  return;
            }
            if (pass !== confirmPasswordInput.value) {
                  e.preventDefault();
                  alert("Las contraseñas no coinciden.");
            }
      });
      });

    </script>
</body>
</html>
