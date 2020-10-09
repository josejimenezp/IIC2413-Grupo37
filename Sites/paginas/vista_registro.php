<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V6</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../css/util.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->
</head>
<?php
session_start(); 
?>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-85 p-b-20">
				<form class="login100-form validate-form" action="registro.php" method="POST">
					<span class="login100-form-title p-b-70">
						Registro
					</span>
					<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Este campo es requerido">
						<input class="input100" type="text" name="nombre">
						<span class="focus-input100" data-placeholder="Nombre"></span>
					</div>
                    
                    <div class="wrap-input100 validate-input m-b-50" data-validate="Este campo es requerido">
						<input class="input100" type="number" name="edad">
						<span class="focus-input100" data-placeholder="Edad"></span>
					</div>
                    
					<div>	
                        <select name= "sexo" required>
                            <option class="options100" value="">Sexo</option>
                            <option class="options100" value="Hombre">Hombre</option>
                            <option class="options100" value="Mujer">Mujer</option>
                            <option class="options100" value="Otro">Otro</option>
                        </select>
                        <br></br>
					</div>
                    
                    <div class="wrap-input100 validate-input m-b-50" data-validate="Este campo es requerido">
						<input class="input100" type="text" name="n_pasaporte">
						<span class="focus-input100" data-placeholder="N° pasaporte"></span>
                    </div>
                    
                    <div class="wrap-input100 validate-input m-b-50" data-validate="Este campo es requerido">
						<input class="input100" type="text" name="nacionalidad">
						<span class="focus-input100" data-placeholder="Nacionalidad"></span>
                    </div>
                    
                    <div class="wrap-input100 validate-input m-b-50" data-validate="Este campo es requerido">
						<input class="input100" type="password" name="password">
						<span class="focus-input100" data-placeholder="Contraseña"></span>
					</div>




					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Registrarse
						</button>
					</div>

					<ul class="login-more p-t-190">
						<li class="m-b-8">
							<span class="txt1">
								Forgotewn
							</span>

							<a href="#" class="txt2">
								Username / Password?
							</a>
						</li>

						<li>
							<span class="txt1">
								Don’t have an account?
							</span>

							<a class="txt2" href="registro.php">
								Sign up
							</a>
						</li>
					</ul>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/bootstrap/js/popper.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/daterangepicker/moment.min.js"></script>
	<script src="../vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../js/main.js"></script>

</body>
</html>