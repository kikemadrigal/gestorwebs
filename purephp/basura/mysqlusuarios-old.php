<?php
class mysqlusuarios{

	private $servidor;
	private $usuario;
	private $password;
	private $base_de_datos;
	private $resultado;
	public $enlace;

	public function __construct(){
		$this->servidor='db591401076.db.1and1.com';
		$this->usuario='dbo591401076';
		$this->password='41434143';
		$this->base_de_datos='db591401076';
		//$this->conectar_mysql();
	}
	/* Realliza la conexión a la base de datos */
	public function conectar_mysql(){
        	$this->enlace = mysql_connect($this->servidor, $this->usuario, $this->password) or die('No pudo conectarse : ' . mysql_error());
			if(! $this->enlace){
				echo "<p>Error al conectar con el servidor.</p>";//die (“ERROR AL CONECTAR MYSQL:”.mysql_error());
			}
			//Establecer la base de datos activa actual en el servidor asociado con el identificador de enlace especificado
        	$base_de_datos_conexion_ok = mysql_select_db($this->base_de_datos, $this->enlace);
         	if (! $base_de_datos_conexion_ok ){
				echo "<p>Error al intentar establecer conexion con la base de datos.</p>";
			}
			@mysql_query("SET NAMES 'utf8'");
	}

	/*metodo para ejecutar una secuencia sql*/
	public function ejecutar_sql($sql){
		//envía una única consulta a la base de datos actualmente activa en el servidor 
		$this->resultado=mysql_query($sql, $this->enlace) or die(mysql_error());
		if (! $this->resultado) {
			echo "<p>Error al ejecutar la consulta</p>";
		}
		return $this->resultado;
	}
	//Desconectar y liberar
	public function desconectar(){
		// Liberar resultados
		//mysql_free_result($this->resultado);
		// Cerrar la conexión
		mysql_close($this->enlace);
		
	}

}

?>