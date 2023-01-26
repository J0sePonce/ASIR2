<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CRUD</title>
<link rel="stylesheet" type="text/css" href="hoja.css">


</head>

<body>

<?php
/* CREAMOS LA CONEXION CON LA BASE DE DATOS */
include("conexion.php");
/* CREAMOS INSTRUCCION SQL QUE NOS DEVUELVA TODO LO QUE HA EN LA TABLA datos_usuarios. Y además almacenamos esos registros en un array de objetos*/
	
/*----------------- PAGINACION --------------------	*/
	
	$registros_por_pagina=3; /* CON ESTA VARIABLE INDICAREMOS EL NUMERO DE REGISTROS QUE QUEREMOS POR PAGINA*/
	$estoy_en_pagina=1;/* CON ESTA VARIABLE INDICAREMOS la pagina en la que estamos*/
		
		if (isset($_GET["pagina"])){
			$estoy_en_pagina=$_GET["pagina"];				
		}
		
	$empezar_desde=($estoy_en_pagina-1)*$registros_por_pagina;
		
	$sql_total="SELECT * FROM datos_usuarios";
	/* CON LIMIT 0,3 HACE LA SELECCION DE LOS 3 REGISTROS QUE HAY EMPEZANDO DESDE EL REGISTRO 0*/
	$resultado=$base->prepare($sql_total);
	$resultado->execute(array());
		
	$num_filas=$resultado->rowCount(); /* nos dice el numero de registros del reusulset*/
	$total_paginas=ceil($num_filas/$registros_por_pagina); /* FUNCION CEIL REDONDEA EL RESULTADO*/
	
	echo "Numero de Registros de la consulta: " . $num_filas . "<br>";
	echo "Mostramos " . $registros_por_pagina . " Registros por página." . "<br>";
	echo "Mostrando la página " . $estoy_en_pagina . " de " . $total_paginas . "<br>" . "<br>";
	
/*------------------------------------------------------*/

$conexion=$base->query("SELECT * FROM datos_usuarios LIMIT $empezar_desde,$registros_por_pagina"); /* EN CONEXION TENDGO UN RESULSET CON LOS REGISTROS ALMACENADOS*/
$registros=$conexion->fetchAll(PDO::FETCH_OBJ); /*TENGO EN $registros un array de objetos. Así podré acceder luego a las propiedades de los objetos */
	
/* las dos lineas anteriores se podrían haber puesto en una sola de esta forma:
$registros=$base->query("SELECT * FROM datos_usuarios")->fetchAll(PDO::FETCH_OBJ);*/

/*lo que tenemos que hacer es que las líneas de la tabla definidas por <tr></tr> se repitan tantas veces como filas haya */ 

?>

<h1>CRUD<span class="subtitulo">Create Read Update Delete</span></h1>
<form method="post" action="insertar.php">
  <table width="50%" border="0" align="center">
    <tr >
      <td class="primera_fila">Id</td>
      <td class="primera_fila">Nombre</td>
      <td class="primera_fila">Apellido</td>
      <td class="primera_fila">Dirección</td>
      <td class="sin">&nbsp;</td>
      <td class="sin">&nbsp;</td>
      <td class="sin">&nbsp;</td>
    </tr> 
   
	<?php
	foreach($registros as $persona):
	 ?>
		
   	<tr>
      <td><?php echo $persona->id;?></td>
      <td><?php echo $persona->Nombre;?></td>
      <td><?php echo $persona->Apellido;?></td>
      <td><?php echo $persona->Direccion;?></td>
 
      <td class="bot"><a href="borrar.php?Id=<?php echo $persona->id?>">
		  <input type='button' name='del' id='del' value='Borrar'>
		  			</a>
	  </td>
		
      <td class='bot'><a href="editar.php?Id=<?php echo $persona->id?> & nom=<?php echo $persona->Nombre?> & ape=<?php echo $persona->Apellido?> & dir=<?php echo $persona->Direccion?>">
		  <input type='button' name='up' id='up' value='Actualizar'>
	  				</a>
	  </td>
    </tr>   
	
	<?php
	endforeach;
	?>
	
	<tr>
	<td></td>
      <td><input type='text' name='Nom' size='10' class='centrado'></td>
      <td><input type='text' name='Ape' size='10' class='centrado'></td>
      <td><input type='text' name='Dir' size='10' class='centrado'></td>
      <td class='bot'><input type='submit' name='cr' id='cr' value='Insertar'></td></tr> 
	  
	<tr><td colspan="4">
		<?php
		/*-------------------------PAGINACION-----------------*/
			for ($i=1; $i<=$total_paginas; $i++){
				echo "<a href='index.php?pagina=" . $i . "'>" . $i . "</a>  ";
			}
		?>		 	 
	</td></tr>
	  
  </table>
</form>
<p>&nbsp;</p>


	
</body>
</html>