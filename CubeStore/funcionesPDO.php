<?php

	/*
	 * Se le pasa una cadena y un tamaño, devuelve si la cadena 
	 * es menor que tam
	 */

	function compruebaLongMax($cadena, $tamMax){
		return strlen($cadena) <= $tamMax;
	}

	/*
	 * Se le pasa una cadena y un tamaño, devuelve si la cadena 
	 * es mayor que tam
	 */

	function compruebaLongMin($cadena, $tamMin){
		return strlen($cadena) >= $tamMin;
	}

	/*
	 * Comprueba si una cuenta cumple el formato
	 */

	function compruebaCuenta($cuenta){
		return strlen($cuenta) == 12;
	}

	/*
	 * Comprueba la validez del los atr pasados
	 */

	function compruebaForm($nombre, $apellidos, $email, $numTarjeta){
		if(!(compruebaLongMax($nombre, 30) && compruebaLongMin($nombre, 2))){
			echo 'Longitud del campo Nombre no es adecuada';
			return false;
		}else if(!(compruebaLongMax($apellidos, 40) && compruebaLongMin($apellidos, 2))){
			echo 'Longitud del campo Apellidos no es adecuada';
			return false;
		}else if(!strpos($email, '@')){
			echo 'Tu email no es correcto';
			return false;
		}else if(!compruebaCuenta($numTarjeta)){
			echo 'El numero de la tarjeta debe tener 12 numeros';
			return false;
		}
		return true;
	}

	/*
	 * Añade las categorias al dom
	 */

	function annadeCategorias(){
		$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');
		$consulta = "SELECT Nombre FROM categoria";
		$resultado = $conexion->query($consulta);
		while($col = $resultado->fetch()){
			echo "<li><a href=\"CubeStore.php?categoria=".$col['Nombre']."\">".$col['Nombre']."</a></li>";
		}
		$resultado->closeCursor();
	}

	/*
	 * Selecionada una categoria, mostramos todos los productos asociados a ella
	 * en el div contenido
	 */

	function muestraProductosCategoria(){
		if(isset($_GET['categoria'])){
			$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');
			$consulta = "SELECT ModeloProducto FROM tiene WHERE NombreCategoria = '".$_GET['categoria']."'";
			$resultado = $conexion->query($consulta);
			marcaDesmarcaDeseado($conexion);
			$i = 0;
			while ($modelo = $resultado->fetch()) {
				insertaLinea($conexion, $modelo['ModeloProducto']);
				muestraProductoFormatoCategoria($modelo['ModeloProducto'], $conexion, $i);
				$i++;
			}
			$resultado->closeCursor();
		}
	}

	/*
	 * Muestra la informacion de UN PRODUCTO de una categoria
	 */

	function muestraProductoFormatoCategoria($modeloP, $conexion, $i){
		$consulta = "SELECT * FROM producto WHERE Modelo =".$modeloP;
		$resultado = $conexion->query($consulta);
		$producto = $resultado->fetch();
		$marcado = marcaDeseado($conexion, $modeloP);
		$consultaCategoria = "SELECT NombreCategoria FROM tiene WHERE ModeloProducto =".$modeloP;
		$resultadoCategoria = $conexion->query($consultaCategoria);
		$tiene = $resultadoCategoria->fetch();
		echo "<div class=\"productoCategoria\"> <img id=\"imagenProdCat\" src=\"".$producto['Foto1']."\"/>
			  <span>Nombre: <a href=\"CubeStore.php?modelo=".$modeloP."\">".$producto['Nombre']."
			  </a></br><span>Precio: ".$producto['Precio']."€</span>
			  <a id='".$modeloP."' class=\"enlace\" href=\"CubeStore.php?carritoModelo=".$modeloP."&cantidad=1&categoria=".$tiene['NombreCategoria']."\"><img class=\"icono\" 
			  src=\"http://www.s-rd.info/images/shop6.png\"/></span></a>
			  <a class=\"enlace\" href=\"CubeStore.php?modeloMarcado=".$modeloP."&categoria=".$tiene['NombreCategoria']."\"><img id=\"deseado".$i."\" class=\"icono\" 
			  src=\"res/deseado.png\"/></a></div>
			  <script type=\"text/javascript\">
				function marcaDeseados".$i."(){
					if(".$marcado."){
						document.getElementById('deseado".$i."').src = 'res/deseadoMarcado.png';
					}

				}

				function eliminaBotonCarrito".$i."(){
					var p = document.getElementById('".$modeloP."');
					p.style.display = 'initial';
					if(".$producto['CantidadEnStock']." == 0){
						p.style.display = 'none';

					}
				}

				if (document.addEventListener){
			        window.addEventListener('load', function(){
			        	marcaDeseados".$i."();
			        	eliminaBotonCarrito".$i."();
			        },false);
			    } else {
			        window.attachEvent('onload', function(){
			        	marcaDeseados".$i."();
			        	eliminaBotonCarrito".$i."();
			        });
			    }
			  </script>";
		$resultadoCategoria->closeCursor();
		$resultado->closeCursor();
	}

	/*
	 * Con esta función lo que hacemos es usar js, para marcar si un producto esta
	 * en la lista de deseados
	 */

	function marcaDeseado($conexion, $modelo){
		$marcado = "false";
		if(isset($_COOKIE['usuario'])){
			$consulta = "SELECT * FROM lista_de_deseados WHERE Modelo_de_Producto =".$modelo." AND Usuario_Cliente = 
			\"".$_COOKIE['usuario']."\"";
			$resultado = $conexion->query($consulta);
			if($resultado->rowCount() !== 0) $marcado = "true";
			$resultado->closeCursor();
		}
		return $marcado;
	}

	/*
	 * Marca y desmarca para los productos cuando le das a la categoria
	 */

	function marcaDesmarcaDeseado($conexion){
	//vemos si se llama a la pagina para añadir el producto a deseado
		if(isset($_GET['modeloMarcado'])){
			if(isset($_COOKIE['usuario'])){
				$consulta = "SELECT * FROM lista_de_deseados WHERE Modelo_de_Producto =".$_GET['modeloMarcado']." AND Usuario_Cliente =\"".$_COOKIE['usuario']."\"";
				$resultado = $conexion->query($consulta);
				if($resultado->rowCount() === 0){
					$consulta = "INSERT INTO lista_de_deseados VALUES (\"".$_COOKIE['usuario']."\", ".$_GET['modeloMarcado'].");";
					$conexion->exec($consulta);
				}else{
					$consulta = "DELETE FROM lista_de_deseados WHERE Modelo_de_Producto =".$_GET['modeloMarcado']." AND Usuario_Cliente =\"".$_COOKIE['usuario']."\"";
					$conexion->exec($consulta);
				}
				$resultado->closeCursor();	
			}else{
				echo "Por favor, haz log in con una cuenta de cliente";
			}
		}
	}

	/*
	 * Vamos a mostrar la información de un producto en pantalla
	 * Tambien vamos a meter unos controles para cambiar de imagen, insertando código js
	 * , para poder visualizar cuales son deseados y poder marcarlos y desmarcarlos, asi
	 * como añadirlos al carrito.
	 */

	function producto(){
		if(isset($_GET['modelo'])){
			$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');
			marcaDesmarcaDeseado($conexion);
			insertaLinea($conexion, $_GET['modelo']);
			$consulta = "SELECT * FROM producto WHERE Modelo =".$_GET['modelo'];
			$resultado = $conexion->query($consulta);
			$producto = $resultado->fetch();
			$marcado = marcaDeseado($conexion, $producto['Modelo']);
			echo "<div id=\"producto\"> <h2>".$producto['Nombre']."</h2></br>
				  <img id=\"imagenProducto\" src=\"".$producto['Foto1']."\"/>
				  <div><strong><span>Tamaño: ".$producto['Tamano']." mm</span></br>
				  <span>Peso: ".$producto['Peso']." gr</span></br>
				  <span>Marca: ".$producto['MarcaProveedor']."</span></br>
				  <span>Precio: ".$producto['Precio']." €</span></br>
				  <span>Cantidad en Stock: ".$producto['CantidadEnStock']." ud.</span></strong>
				  <select id=\"cantidad\"></select></br>
				  <a id=\"carrito\" href=\"CubeStore.php?modelo=".$_GET['modelo']."&carritoModelo=".$_GET['modelo']."&cantidad=none\">
				  <img class=\"icono\" src=\"http://www.s-rd.info/images/shop6.png\"/></a>
				  <a href=\"CubeStore.php?modelo=".$_GET['modelo']."&modeloMarcado=".$producto['Modelo']."\"><img id=\"deseado\" 
				  class=\"icono\" src=\"res/deseado.png\"/></a>
				  </div></br><div id=\"controles\"><input type=\"button\" id=\"anterior\" value=\"< Anterior\">
				  <input type=\"button\" id=\"siguiente\" value=\"Siguiente >\"></div></div>
				  <iframe id=\"video\" src=\"https://www.youtube.com/embed/".$producto['Video']."\" allowfullscreen></iframe>
				  <script type=\"text/javascript\">
				    const NUM_IMAGES = 2;
					var contImagen = 0;

					function onClickSiguiente(){
						contImagen++;
						document.getElementById('imagenProducto').src = \"".$producto['Foto2']."\";
						if(contImagen == NUM_IMAGES-1){
							document.getElementById('siguiente').disabled = true;
							document.getElementById('anterior').disabled = false;
						}
					}

					function onClickAnterior(){
						contImagen--;
						document.getElementById('imagenProducto').src = \"".$producto['Foto1']."\";
						if(contImagen == 0){
							document.getElementById('anterior').disabled = true;
							document.getElementById('siguiente').disabled = false;
						}
					}

				  	function manejaVisor(){
						document.getElementById('anterior').disabled = true;
						document.getElementById('siguiente').disabled = false;
						document.getElementById('anterior').onclick = onClickAnterior;
						document.getElementById('siguiente').onclick = onClickSiguiente;
						if(true === ".$marcado."){
							document.getElementById('deseado').src = \"res/deseadoMarcado.png\";
						}
				  	}

					if (document.addEventListener){
				        window.addEventListener('load', manejaVisor(),false);
				    } else {
				        window.attachEvent('onload', manejaVisor());
				    }
				  </script>";
			anadeStock($producto['CantidadEnStock']);
			anadeCantidadAlPedido();
			$resultado->closeCursor();
		}
	}

	/*
	 * Esta función sirve para mandar la cantidad deseada a insertar en el pedido
	 */

	function anadeCantidadAlPedido(){
		echo "<script type=\"text/javascript\">
			function onChangeDesplegable(){
				lista = document.getElementById('cantidad');
				selec = lista.options[lista.selectedIndex];
				var str = document.getElementById('carrito').href;
				str = str.substr(0, str.indexOf('&cantidad='));
				str += '&cantidad=' + selec.value; 
				document.getElementById('carrito').href = str;

			}
			
			if (document.addEventListener){
		        window.addEventListener('load', function(){
		        	document.getElementById('cantidad').onchange = onChangeDesplegable;
		        },false);
		    } else {
		        window.attachEvent('onload', function(){
		        	document.getElementById('cantidad').onchange = onChangeDesplegable;
		        });
		    }
		</script>";
	}

	/*
	 * Va ha introducir el la lista desplegable cuantas unidades hay disponibles
	 */

	function anadeStock($stock){
		echo "<script type=\"text/javascript\">
			function anadeCantidadStock(){
				document.getElementById('cantidad').innerHTML += \"<option value='none'>none</option>\";
				for(var i = 1; i <= ".$stock."; i++){
					document.getElementById('cantidad').innerHTML += \"<option value='\"+i+\"'>\"+i+\"</option>\";
				}
			}
			
			if (document.addEventListener){
		        window.addEventListener('load', anadeCantidadStock(),false);
		    } else {
		        window.attachEvent('onload', anadeCantidadStock());
		    }

		</script>";
	}

	/*
	 * Función que controla el login, mira si alguien se quiere logear, o está ya logeado
	 * tanto para cliente como para el admin.
	 */

	function login(){
		if(isset($_GET['logOut'])) {
			if(isset($_COOKIE['usuario'])) setcookie("usuario", $_COOKIE['usuario'], time() - 1);
			if(isset($_COOKIE['admin'])) setcookie("admin", $_COOKIE['admin'], time() - 1);

			echo "<script type=\"text/javascript\">window.location = 'CubeStore.php'</script>";
		} 
		else if(isset($_COOKIE['usuario'])){
			echo "<script type=\"text/javascript\">
				function onLoadLog(){
					var logUser = \"<span><strong>Hola, ".$_COOKIE['usuario']."</strong></span></br>\";
					logUser += \"<ol><li><a href='CubeStore.php?carrito=true'>Carrito de la Compra</a></li>\";
					logUser += \"<li><a href='CubeStore.php?pedidos=true'>Pedidos Realizados</a></li>\";
					logUser += \"<li><a href='CubeStore.php?listaDeseados=true'>Lista de Deseados</a></li>\";
					logUser += \"<li><a href='CubeStore.php?logOut=true'>Log Out</a></li></ol>\";
					document.getElementById('log').innerHTML = logUser;
				};
				if (document.addEventListener){
			        window.addEventListener('load', onLoadLog(),false);
			    } else {
			        window.attachEvent('onload', onLoadLog());
			    }
			</script>";

		}else if(isset($_COOKIE['admin'])){
			echo "<script type=\"text/javascript\">
				function onLoadLog(){
					var logUser = \"<span><strong>Admin, ".$_COOKIE['admin']."</strong></span></br>\";
					logUser += \"<ol><li><a href='CubeStore.php?pedidos=true'>Todos los Pedidos</a></li>\";
					logUser += \"<li><a href='CubeStore.php?cuentasC=true'>Cuentas de Clientes</a></li>\";
					logUser += \"<li><a href='CubeStore.php?cuentasA=true'>Cuentas de Admins</a></li>\";
					logUser += \"<li><a href='CubeStore.php?logOut=true'>Log Out</a></li></ol>\";
					document.getElementById('log').innerHTML = logUser;
				};
				if (document.addEventListener){
			        window.addEventListener('load', onLoadLog(),false);
			    } else {
			        window.attachEvent('onload', onLoadLog());
			    }
			</script>";

		}else{
			if(isset($_POST['contrasena']) && isset($_POST['usuario'])){
		 		$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');
				$consultaA = "SELECT Contrasena FROM administrador WHERE Usuario = '".$_POST['usuario']."'";
				$resultadoA = $conexion->query($consultaA);
				$consultaC = "SELECT Contrasena FROM cliente WHERE Usuario = '".$_POST['usuario']."'";
				$resultadoC = $conexion->query($consultaC);
				if ($resultadoA->rowCount() === 0 && $resultadoC->rowCount() === 0) { 
			      echo 'El usuario no existe.','<br/>';
			    } else {
			    	if($resultadoA->rowCount() === 0) $contrasena = $resultadoC->fetch();
			    	else $contrasena = $resultadoA->fetch(); 
			    	
			    	if($contrasena['Contrasena'] == $_POST['contrasena']){
			    		if($resultadoA->rowCount() === 0) setcookie ('usuario', $_POST['usuario'], time()+3600);
			    		else setcookie ('admin', $_POST['usuario'], time()+3600);

			    		echo "<script type=\"text/javascript\">window.location = 'CubeStore.php'</script>";
			    	}else {
			    		echo 'Contrasena incorrecta';
			    	}    	
			    }
				$resultadoA->closeCursor();
				$resultadoC->closeCursor();
		 	}
		}
	}

	/*
	 * Funcion que sirve para el registro
	 */

	function registro(){
		if(isset($_GET['registro'])){
			FormRegistro();
			if(isset($_POST['nuevo_usuario'])){
		 		$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');
				$consulta = "SELECT Contrasena FROM cliente WHERE Usuario = '".$_POST['nuevo_usuario']."'";
				$resultado = $conexion->query($consulta);
				if ($resultado->rowCount() === 0) {
					if(compruebaForm($_POST['nombre'], $_POST['apellido'], $_POST['correo_electronico'], $_POST['num_tarjeta'])){
						//No existe un usuario con ese nombre, lo vamos ha meter
				      	$consulta = "INSERT INTO cliente VALUES('".$_POST['nuevo_usuario']."', '".$_POST['nueva_contrasena']."', '".$_POST['nombre']."', '".$_POST['apellido']."', '".$_POST['correo_electronico']."', '".$_POST['direccion']."', ".$_POST['num_tarjeta'].");";
				  
				      	$conexion->exec($consulta);
				      	echo "<script type=\"text/javascript\">window.location = 'CubeStore.php'</script>";
				    }

			    } else {
			    	//Entonces ya existe un usuario con ese nombre
			    	echo 'Ya hay un usuario con ese nombre, prueba con otro';
			    }
				$resultado->closeCursor();	
		 	}
		}
	}

	/*
	 * Es el formulario a rellenar para registrarse
	 */

	function FormRegistro(){
		echo "
			<h2>Registrate</h2>
			<form id=\"registro\" action=\"#\" method='post'>
				<fieldset>
				<legend><strong>Cuenta</strong></legend>
				<label>Nombre de usario: </label><input type=\"text\" name=\"nuevo_usuario\"> </br>
				<label>Contrasena: </label><input type=\"password\" name=\"nueva_contrasena\"></fieldset> </br>
				<fieldset>
				<legend><strong>Tus Datos</strong></legend>
				<label>Nombre: </label><input type=\"text\" name=\"nombre\"> </br>
				<label>Apellidos: </label><input type=\"text\" name=\"apellido\"> </br>
				<label>Correo electronico: </label><input type=\"text\" name=\"correo_electronico\"> </br>
				<label>Direccion: </label><input type=\"text\" name=\"direccion\"> </br>
				<label>Numero de tarjeta: </label><input type=\"text\" name=\"num_tarjeta\"></fieldset>
				<input type=\"submit\" class=\"boton\" value=\"Enviar\">
			</form>";
	}

	/*
	 * Con esta función vamos ha insertar lineas en el pedido
	 * Si no hay un pedido que no este comprado lo creamos
	 */

	function insertaLinea($conexion, $modelo){
		if(isset($_GET['carritoModelo']) && $modelo == $_GET['carritoModelo']){
			if(isset($_COOKIE['usuario'])){
				if($_GET['cantidad'] != 'none'){
					$consulta = "SELECT * FROM pedido WHERE Usuario_Cliente = '".$_COOKIE['usuario']."' AND Comprado = 'false'";
					$resultado = $conexion->query($consulta);
					$pedido = $resultado->fetch();
					if($resultado->rowCount() === 0){
						$fecha = getdate();
						$fecha = $fecha['mday'].'/'.$fecha['mon'].'/'.$fecha['year'];
						$consulta = "INSERT INTO pedido (FechaCompra, Comprado, Usuario_Cliente) VALUES (\"".$fecha."\", \"false\", \"".$_COOKIE['usuario']."\");";
						$conexion->exec($consulta);
						$consulta = "SELECT * FROM pedido WHERE Usuario_Cliente = '".$_COOKIE['usuario']."' AND Comprado = 'false'";
						$resultado = $conexion->query($consulta);
						$pedido = $resultado->fetch();
					}

					$consulta = "INSERT INTO linea (IdPedido_L, ModeloProducto_L, Cantidad) VALUES (".$pedido['Id_P'].", ".$modelo.
					", ".$_GET['cantidad'].");";
					$conexion->exec($consulta);

					//necesitamos ver el precio del producto
					$consulta = "SELECT Precio FROM producto WHERE Modelo = ".$modelo."";
					$resultado = $conexion->query($consulta);
					$producto = $resultado->fetch();

					//actualizamos el precio total
					$precioT = $pedido['Precio_Total'] + $producto['Precio'] * $_GET['cantidad'];
					$consulta = "UPDATE pedido SET Precio_Total = ".$precioT." WHERE Id_P = ".$pedido['Id_P']."";
					$conexion->exec($consulta);
					$resultado->closeCursor();
				}else{
					echo "No has seleccionado las unidades que quieres comprar";
				}
			}else{
				echo "Por favor, haz log in con una cuenta de cliente";
			}
		}
	}

	/*
	 * Vamos a mostrar la lista de deseados
	 */

	function muestraDeseados(){
		if(isset($_GET['listaDeseados']) && isset($_COOKIE['usuario'])){
			$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');
			$consulta = "SELECT * FROM lista_de_deseados WHERE Usuario_Cliente = '".$_COOKIE['usuario']."';";
			$resultado = $conexion->query($consulta);
			$i = 0;
			marcaDesmarcaDeseado($conexion);
			while($deseado = $resultado->fetch()){
				insertaLinea($conexion, $deseado['Modelo_de_Producto']);
				muestraProductoFormatoCategoria($deseado['Modelo_de_Producto'], $conexion, $i);
				$i++;
			}

			//hago esto para mantenerme el la lista de deseados al pulsar sobre un enlace
			echo "<script type=\"text/javascript\">
				function reEnlaza(){
					var enlaces = document.getElementsByClassName('enlace');
					for(var i = 0; i < enlaces.length; i++){
						var str = enlaces[i].href;
						str = str.substr(0, str.indexOf('categoria='));
						str += 'listaDeseados=true';
						enlaces[i].href = str;
					}
				}

				if (document.addEventListener){
			        window.addEventListener('load', reEnlaza(),false);
			    } else {
			        window.attachEvent('onload', reEnlaza());
			    }
			  </script>";
			$resultado->closeCursor();
		}
	}

	/*
	 * Muestra un producto, en formato pedido
	 */

	function muestraLinea($conexion, $modeloP, $cantidad, $idLin){
		$consulta = "SELECT * FROM producto WHERE Modelo =".$modeloP;
		$resultado = $conexion->query($consulta);
		$producto = $resultado->fetch();
		$consultaCategoria = "SELECT NombreCategoria FROM tiene WHERE ModeloProducto =".$modeloP;
		$resultadoCategoria = $conexion->query($consultaCategoria);
		$tiene = $resultadoCategoria->fetch();
		$precio = $cantidad * $producto['Precio'];
		echo "<div class=\"carrito\"><img src=\"".$producto['Foto1']."\"/>
			  <span>Nombre: ".$producto['Nombre']."<a href='CubeStore.php?carrito=true&lin=".$idLin."'>
			  <img class=\"iconoP\" src=\"res/borrar.png\"/></a>
			  </br></br>Cantidad: ".$cantidad."</span>
			  <span class=\"precio\">Precio: ".$precio."€</span></br></div>";
		$resultadoCategoria->closeCursor();
		$resultado->closeCursor();
		return $precio;
	}

	/*
	 * Elimina una linea de un pedido y actualiza el precio de este
	 */

	function eliminaLinea($conexion){
		if(isset($_GET['lin'])){
			//linea para el producto
			$consulta = "SELECT ModeloProducto_L, IdPedido_L, Cantidad FROM linea WHERE Id_L = ".$_GET['lin'];
			$resultado = $conexion->query($consulta);
			$lin = $resultado->fetch();

			//precio producto
			$consulta = "SELECT Precio FROM producto WHERE Modelo = ".$lin['ModeloProducto_L'];
			$resultado = $conexion->query($consulta);
			$producto = $resultado->fetch();

			$consulta = "SELECT * FROM pedido WHERE Id_P = ".$lin['IdPedido_L'];
			$resultado = $conexion->query($consulta);
			$pedido = $resultado->fetch();

			//actualizamos el precio total
			$precioTotal = $pedido['Precio_Total'] - $producto['Precio'] * $lin['Cantidad'];
			$consulta = "UPDATE pedido SET Precio_Total = ".$precioTotal." WHERE Id_P = ".$pedido['Id_P'].";";
			$conexion->exec($consulta);

			//si no hay más articulos en el carrito eliminamos el pedido 
			if($precioTotal == 0){
				$consulta = "DELETE FROM pedido WHERE Id_P = ".$pedido['Id_P'].";";
				$conexion->exec($consulta);
			}else{
				$consulta = "DELETE FROM linea WHERE Id_L = ".$_GET['lin'].";";
				$conexion->exec($consulta);
			}
			$resultado->closeCursor();
		}
	}


	/*
	 * Mostramos el contenido del carrito de la compra, para que usuario pueda aceptar su compra
	 */

	function carrito(){
		if(isset($_GET['carrito']) && isset($_COOKIE['usuario'])){
			$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');

			//eliminamos la linea correspondiente y actualizamos el precio total
			eliminaLinea($conexion);

			$consulta = "SELECT * FROM pedido WHERE Usuario_Cliente = '".$_COOKIE['usuario']."' AND Comprado = 'false'";
			$resultado = $conexion->query($consulta);
			$pedido = $resultado->fetch();
			if($resultado->rowCount() === 0){
				echo "No has añadido ningun producto al carrito";
			}else{
				$consulta = "SELECT * FROM linea WHERE IdPedido_L = ".$pedido['Id_P'];
				$resultado = $conexion->query($consulta);
				echo "<h2>Carrito de la Compra</h2></br></br>";
				$total = 0;
				while($linea = $resultado->fetch()){
					muestraLinea($conexion, $linea['ModeloProducto_L'], $linea['Cantidad'], $linea['Id_L']);
				}
				echo "<span id=\"total\"> <input id=\"comprar\"  type=\"button\" value=\"Comprar\"> 
						<strong>TOTAL: ".$pedido['Precio_Total']."€</strong></span>";
				$modelo = confirmaStock($conexion, $pedido['Id_P']);
				echo "<script type=\"text/javascript\">
						
					  function onClickComprar(){
						var modelo = \"".$modelo."\";
						if(modelo === \"exito\") {
							window.location = 'CubeStore.php?pedido=".$pedido['Id_P']."';
						}
						else{
							document.getElementById('contenido').innerHTML += 
							\"<span>Lo senimos, no disponemos de suficientes unidades de: \" + modelo + \"</span>\";
						}
					  }

					  if (document.addEventListener){
					        window.addEventListener('load', function(){
					        	document.getElementById('comprar').onclick = onClickComprar;
					        },false);
					    } else {
					        window.attachEvent('onload', function(){
					        	document.getElementById('comprar').onclick = onClickComprar;
					        });
					    }

					  </script>";
			}
			$resultado->closeCursor();
		}
	}

	/*
	 * Lo que queremos ver es si hay stock suficiente para ese pedido
	 */

	function confirmaStock($conexion, $idPedido){
		$consulta = "SELECT ModeloProducto_L, Cantidad FROM linea WHERE IdPedido_L = ".$idPedido;
		$resultado = $conexion->query($consulta);
		while($linea = $resultado->fetch()){

			$consulta = "SELECT Cantidad FROM linea WHERE IdPedido_L = ".$idPedido." AND ModeloProducto_L = ".$linea['ModeloProducto_L'];
			$resultadoL = $conexion->query($consulta);
			$stock = 0;
			while($lin = $resultadoL->fetch()){
				$stock += $lin['Cantidad'];
			}
			//ahora tenemos que ver si el producto puede abastecer
			$consulta = "SELECT CantidadEnStock, Nombre FROM producto WHERE Modelo = ".$linea['ModeloProducto_L'];
			$resultadoP = $conexion->query($consulta);
			$producto = $resultadoP->fetch();
			if($producto['CantidadEnStock'] < $stock) {
				$resultadoP->closeCursor();
				$resultadoL->closeCursor();
				$resultado->closeCursor();
				return $producto['Nombre'];
			}
		}
		$resultadoP->closeCursor();
		$resultadoL->closeCursor();
		$resultado->closeCursor();
		return "exito";
	}

	/*
	 * Vamos a actualizar las unidades en stock al confirmarse el pedido
	 */

	function actualizaStock($conexion, $idPedido){
		$consulta = "SELECT ModeloProducto_L, Cantidad FROM linea WHERE IdPedido_L = ".$idPedido;
		$resultado = $conexion->query($consulta);
		while($linea = $resultado->fetch()){
			$consulta = "SELECT CantidadEnStock, Nombre FROM producto WHERE Modelo = ".$linea['ModeloProducto_L'];
			$resultadoP = $conexion->query($consulta);
			$producto = $resultadoP->fetch();
			$producto['CantidadEnStock'] -= $linea['Cantidad'];
			$consulta = "UPDATE producto SET CantidadEnStock = ".$producto['CantidadEnStock']." WHERE Modelo = ".$linea['ModeloProducto_L'].";";
			$conexion->exec($consulta);
		}
		$resultadoP->closeCursor();
		$resultado->closeCursor();
	}

	/*
	 * Confirma el pedido y muestra sus datos
	 */

	function confirmaPedido(){
		if(isset($_GET['pedido'])){
			$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');

			$fecha = getdate();
			$fecha = $fecha['mday'].'/'.$fecha['mon'].'/'.$fecha['year'];
			$consulta = "UPDATE pedido SET FechaCompra = '".$fecha."', Comprado = 'true' WHERE Id_P = ".$_GET['pedido'].";";
			$conexion->exec($consulta);
			actualizaStock($conexion, $_GET['pedido']);
			echo "<script type=\"text/javascript\">window.location = 'CubeStore.php?factura=".$_GET['pedido']."'</script>";
		}
	}

	/*
	 * Muestra la factura de un pedido
	 */

	function muestraFactura(){
		if(isset($_GET['factura'])){
			$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');

			//para los datos del pedido
			$consulta = "SELECT * FROM pedido WHERE Id_P = ".$_GET['factura'];
			$resultado = $conexion->query($consulta);
			$pedido = $resultado->fetch();

			//para los datos del cliente
			$consulta = "SELECT * FROM cliente WHERE Usuario = '".$pedido['Usuario_Cliente']."'";
			$resultado = $conexion->query($consulta);
			$cliente = $resultado->fetch();

			echo "<p id=\"pedido\">
				  Numero de Pedido: ".$pedido['Id_P']."</br>
				  ".$cliente['Nombre']." ".$cliente['Apellido']."</br>
				  Direccion de envio: ".$cliente['Direccion']."</br>
				  Fecha de Compra: ".$pedido['FechaCompra']."</br></p>";

			//vamos a generar una tabla con los datos del pedido
			$consulta = "SELECT * FROM linea WHERE IdPedido_L = ".$_GET['factura'];
			$resultado = $conexion->query($consulta);
			echo "<table id='tablaPedido'>
				  <tr><th>Cant.</th>
				  <th>Modelo</th>
				  <th colspan='3'>Nombre del Producto</th>
				  <th>IVA</th>
				  <th>Total sin IVA</th>
				  <th>Total con IVA</th></tr>";
			while($linea = $resultado->fetch()){
				$consulta = "SELECT Nombre, Precio FROM producto WHERE Modelo = ".$linea['ModeloProducto_L'];
				$resultadoP = $conexion->query($consulta);
				$prod = $resultadoP->fetch();
				$iva = $prod['Precio'] * 0.21;
				echo "<tr><td>".$linea['Cantidad']."</td>
					  <td>".$linea['ModeloProducto_L']."</td>
					  <td colspan='3'>".$prod['Nombre']."</td>
					  <td>".$iva."€</td>
					  <td>".($prod['Precio'] - $iva)."€</td>
					  <td>".$prod['Precio']."€</td></tr>";
			}
			$iva = $pedido['Precio_Total'] * 0.21;
			echo "</table><p id='total'><strong>Total sin IVA: ".($pedido['Precio_Total'] - $iva)."€</br>
										Total con IVA: ".$pedido['Precio_Total']."€</strong></p>";

			$resultadoP->closeCursor();
			$resultado->closeCursor();
		}
	}

	/*
	 * Vamos a mostrar todos los pedidos realizados, esto dependerá de si esta conectado
	 * un usuario, o el administrador.
	 */

	function muestraPedidos(){
		if(isset($_GET['pedidos'])){
			$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');

			if(isset($_COOKIE['admin'])) $consulta = "SELECT * FROM pedido WHERE Comprado = 'true' ORDER BY Usuario_Cliente";
			else $consulta = "SELECT * FROM pedido WHERE Usuario_Cliente = '".$_COOKIE['usuario']."' AND Comprado = 'true'";

			$resultado = $conexion->query($consulta);
			while($pedido = $resultado->fetch()){
				echo "<fieldset class=\"factura\"><p><a href='CubeStore.php?factura=".$pedido['Id_P']."'>Numero de pedido: ".$pedido['Id_P']."</a></br>
					  Usuario: ".$pedido['Usuario_Cliente']."</br>
					  Fecha de Compra: ".$pedido['FechaCompra']."</br>
					  Precio total: ".$pedido['Precio_Total']."€</br>";

				//recorremos las lineas de un pedido
				$consulta = "SELECT * FROM linea WHERE IdPedido_L = ".$pedido['Id_P'];
				$resultadoL = $conexion->query($consulta);
				while($linea = $resultadoL->fetch()){
					muestraLinea($conexion, $linea['ModeloProducto_L'], $linea['Cantidad'], $linea['Id_L']);
				}

				echo "</fieldset>";
			}

			$resultadoL->closeCursor();
			$resultado->closeCursor();
		}
	}

	/*
	 * Vamos a mostrar los datos de todas las cuentas de los clientes
	 */

	function muestraCuentaCliente(){
		if(isset($_GET['cuentasC']) && isset($_COOKIE['admin'])){
			$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');
			$consulta = "SELECT * FROM cliente";
			$resultado = $conexion->query($consulta);

			echo "<h2>Cuentas de Clientes</h2></br>";
			while($cliente = $resultado->fetch()){
				echo "<div class=\"cuenta\">
					<p>Cuenta: <strong>".$cliente['Usuario']."</strong></br>
					Contraseña: <strong>".$cliente['Contrasena']."</strong></br></br>
					Nombre: <strong>".$cliente['Nombre']."</strong></br>
					Apellido: <strong>".$cliente['Apellido']."</strong></br></br>
					Correo Electrónico: <strong>".$cliente['CorreoElectronico']."</strong></br>
					Dirección: <strong>".$cliente['Direccion']."</strong></br>
					Numero de Tarjeta: <strong>".$cliente['NumeroTarjeta']."</strong></p>
				</div>";
			}

			$resultado->closeCursor();
		}
	}

	/*
	 * Muestra las cuentas de los administradores
	 */

	function muestraCuentaAdmin(){
		if(isset($_GET['cuentasA']) && isset($_COOKIE['admin'])){
			$conexion = new PDO('mysql:host=localhost;dbname=cubestore','root','');
			$consulta = "SELECT * FROM administrador";
			$resultado = $conexion->query($consulta);

			echo "<h2>Cuentas de Administradores</h2></br>";
			while($cliente = $resultado->fetch()){
				echo "<div class=\"cuenta\">
					<p>Cuenta: <strong>".$cliente['Usuario']."</strong></br>
					Contraseña: <strong>".$cliente['Contrasena']."</strong></br></br>
					Nombre: <strong>".$cliente['Nombre']."</strong></br>
					Apellido: <strong>".$cliente['Apellido']."</strong></br></br>
					Correo Electrónico: <strong>".$cliente['CorreoElectronico']."</strong></br>
					</p></div>";
			}

			$resultado->closeCursor();
		}
	}

	/*
	 * La usamos para mostrar la página principal
	 */

	function muestraPrincipal(){
		if (!$_GET && !$_POST){
			echo "<p id=\"tituloDestacado\">Productos Destacados</p></br>
				  <div id=\"fotosDestacados\">
					<a id=\"enlaceIzq\" href=\"CubeStore.php?modelo=6\"><img class=\"destacada\" id=\"fotoIzq\" 
						src=\"http://www.championscubestore.com/images/s/201511/14481694130.jpg\"/></a>
					<a id=\"enlaceP\" href=\"CubeStore.php?modelo=88\"><img class=\"destacada\" id=\"fotoP\" 
						src=\"http://www.championscubestore.com/images/s/201612/1481372829vba.jpg\"/></a>
					<a id=\"enlaceDer\" href=\"CubeStore.php?modelo=80\"><img class=\"destacada\" id=\"fotoDer\" 
						src=\"http://www.championscubestore.com/images/s/201608/YJAP04_14724518713.jpg\"/></a>
					</br><p id=\"nombreProducto\">YuXin 11x11 Stickerless</p>
				  </div></br>
				  <div id=\"videosDestacados\">
					<iframe class=\"videoD\" src=\"https://www.youtube.com/embed/Iw8DgSVUEjU\" allowfullscreen></iframe>
					<iframe class=\"videoD\" src=\"https://www.youtube.com/embed/SI_Gjpt-m1g\" allowfullscreen></iframe>
					<iframe class=\"videoD\" src=\"https://www.youtube.com/embed/gvA0ho_-cvg\" allowfullscreen></iframe>
				  </div>";


			echo "<script type=\"text/javascript\">
				const NUM_IMAGES = 3;
				var fotos = [];
				var nombres = [];
				var enlaces = [];
				var cont = 0;

				function cargaFotos(){
					fotos.push('http://www.championscubestore.com/images/s/201612/1481372829vba.jpg');
					fotos.push('http://www.championscubestore.com/images/s/201608/YJAP04_14724518713.jpg');
					fotos.push('http://www.championscubestore.com/images/s/201511/14481694130.jpg');
					
					nombres.push('3x3 Apple Cube');
					nombres.push('YuXin Mirror Pink');
					nombres.push('YuXin 11x11 Stickerless');

					enlaces.push('CubeStore.php?modelo=88');
					enlaces.push('CubeStore.php?modelo=80');
					enlaces.push('CubeStore.php?modelo=6');
				}

				function cambiaImagen(){
					document.getElementById('fotoIzq').src = fotos[cont];
					document.getElementById('fotoP').src = fotos[(cont + 1) % NUM_IMAGES];
					document.getElementById('fotoDer').src = fotos[(cont + 2) % NUM_IMAGES];

					document.getElementById('nombreProducto').innerHTML = nombres[cont];

					document.getElementById('enlaceIzq').href = enlaces[cont];
					document.getElementById('enlaceP').href = enlaces[(cont + 1) % NUM_IMAGES];
					document.getElementById('enlaceDer').href = enlaces[(cont + 2) % NUM_IMAGES];

					cont = (cont + 1) % NUM_IMAGES;
				}

				function main(){
					cargaFotos();
					setInterval(function(){ cambiaImagen(); }, 4000);
				}

				if (document.addEventListener){
			        window.addEventListener('load', main(),false);
			    } else {
			        window.attachEvent('onload', main());
			    }
			</script>";
		}
	}
?>