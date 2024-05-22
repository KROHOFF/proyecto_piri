<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>VirtuaNet - Registro Usuario</title>

	<link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="img/favicon.png" rel="icon" type="image/png">
	<link href="img/favicon.ico" rel="shortcut icon">

    <link rel="stylesheet" href="../../public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="../../public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="../../public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/main.css">

    <link rel="stylesheet" href="../../public/css/lib/bootstrap-sweetalert/sweetalert.css">
    <link rel="stylesheet" href="../../public/css/separate/vendor/sweet-alert-animations.min.css">

</head>
<body>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box new-user-box" id='usuario_form'>
                    <header class="sign-title">Registro Usuario</header>
                    <div class="form-group">
						<input type="text" id="usu_nom" name="usu_nom" class="form-control" placeholder="Nombre"/>
                    </div>
					<div class="form-group">
						<input type="text" id="usu_ape" name="usu_ape" class="form-control" placeholder="Apellido"/>
                    </div>
					<div class="form-group">
						<input type="email" id="usu_correo" name="usu_correo" class="form-control" placeholder="Correo Electronico"/>
                    </div>
					<div class="form-group">
						<input type="text" id="usu_pass" name="usu_pass" class="form-control" placeholder="Contraseña"/>
                    </div>
					<div class="form-group">
						<input type="text" id="usu_telf" name="usu_telf" class="form-control" placeholder="Telefono"/>
                    </div>
						<input type="hidden" id="rol_id" name="rol_id" value="1">
						
                    <button type="submit" id="btnenviar" class="btn btn-rounded">Enviar</button>
					<a href="../../index.php">Regresar</a>
                </form>
            </div>
        </div>
    </div><!--.page-center-->

<script src="../../public/js/lib/jquery/jquery.min.js"></script>
<script src="../../public/js/lib/tether/tether.min.js"></script>
<script src="../../public/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="../../public/js/plugins.js"></script>
<script type="text/javascript" src="../../public/js/lib/match-height/jquery.matchHeight.min.js"></script>
<script src="../../public/js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
<script>
    $(function() {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function(){
            setTimeout(function(){
                $('.page-center').matchHeight({ remove: true });
                $('.page-center').matchHeight({
                    target: $('html')
                });
            },100);
        });
    });
</script>
<script src="../../public/js/app.js"></script>
<script type="text/javascript" src="registrousuario.js"></script>
</body>
</html>