<!DOCTYPE html>
<html>
<head>
	<title>Cube Store</title>
	<link rel="stylesheet" type="text/css" href="estiloCubeStore.css" media="screen">
</head>
<body>
	<?php include("funciones.php"); ?>
	<div id="contenedor">
		<div id="cabecera">
			<a href="CubeStore.php"><img id="titulo" src="res/titulo1sinfondo.png"></a>
			<div id="log">
				<form action="#" method='post'>
					<label> Usuario: </label> <input type="text" name="usuario" size="15"></br>
					<label> Contrasena: </label> <input type="password" name="contrasena" size="15"></br></br>
					<input type="submit" class=\"boton\" value="Log In" id="enviar">
					<a href="CubeStore.php?registro=true">Registrate</a>
				</form>
			</div>
			<?php login(); ?>
		</div>
		<div id="categorias" class="cuerpo">
		<h2>Categorias</h2></br>
		<ol id="listaCategorias"><?php annadeCategorias(); ?> </ol>
		</div>

		<div id="contenido" class="cuerpo">
			<?php 
				muestraPrincipal();
				muestraProductosCategoria(); 
				producto();
				registro();
				muestraDeseados();
				carrito();
				confirmaPedido();
				muestraPedidos();
				muestraCuentaCliente();
				muestraCuentaAdmin();
				muestraFactura();
			?>
		</div>

		<div id="pie">
			<p>
				Autores: Elisa Arscott Mateos &amp; Youssef El Faqir El Rhazoui</br>
				Trabajo para la asignatura de Sistemas de Gesti&oacute;n Empresarial</br>
				Curso: 2016-2017
			</p>

		</div>
	</div>
</body>
</html>