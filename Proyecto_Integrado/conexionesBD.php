<?php
	
	function conectarBD()
	{
	    	$servername = "localhost";
	        $database = "bd_papeleria_integrado";
	        $username = "root";
	        $password = "sextemas_uwu";

			try
			{
	        $conexion = mysqli_connect($servername, $username, $password, $database);
			}
			catch(mysqli_sql_exception $e)
			{
				die("Error en la conexion: " . $e->getMessage());
			}
		return $conexion;
	    }
?>