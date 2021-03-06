<?php 

	require_once "conexion.php";
	

	class ModeloFormularios{
		#registro
			static public function mdlRegistro($tabla,$datos){

				#statement-declaracion
				$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (token, nombre, email, password) VALUES (:token, :nombre, :email, :password)");

				#bindParam vincula parametros a variables->envitar injeciones SQL
				$stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);
				$stmt->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
				$stmt->bindParam(":email",$datos["email"],PDO::PARAM_STR);
				$stmt->bindParam(":password",$datos["password"],PDO::PARAM_STR);
				#ejecutar la sentencia
				if ($stmt->execute()) {
					return "ok";
				} else {
					print_r(Conexion::conectar()->errorInfo());
				}

				$stmt->close();
				$stmt = null;

			}


		#Seleccionar Registros
		static public function mdlSeleccionarRegistro($tabla,$item,$valor){

				if ($item == null && $valor == null) {
					#traer todos los registros
						$stmt = Conexion::conectar()->prepare("SELECT *,date_format(fecha,'%d/%m/%Y') AS fecha FROM $tabla ORDER BY id DESC");
						$stmt->execute();

					return $stmt->fetchAll();

				} else {
					#traer 1 solo registro:
					$stmt = Conexion::conectar()->prepare("SELECT *,date_format(fecha,'%d/%m/%Y') AS fecha FROM $tabla WHERE $item = :$item");

				$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);

					$stmt->execute();
					return $stmt->fetch();
				}
				

			$stmt->close();
			$stmt = null;
		}

		#Actualizar registros
			static public function mdlActualizar($tabla,$datos){
				#statement-declaracion
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre=:nombre,email=:email,password=:password WHERE token = :token");

				$stmt->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
				$stmt->bindParam(":email",$datos["email"],PDO::PARAM_STR);
				$stmt->bindParam(":password",$datos["password"],PDO::PARAM_STR);
				$stmt->bindParam(":token",$datos["token"],PDO::PARAM_STR);

				#ejecutar la sentencia
				if ($stmt->execute()) {
					return "ok";
				} else {
					print_r(Conexion::conectar()->errorInfo());
				}

				$stmt->close();
				$stmt = null;

			}

		#Eliminar Registro:
			
			static public function mdleliminarRegistro($tabla,$valor){
				#statement-declaracion
				$stmt = Conexion::conectar()->prepare("DELETE from $tabla WHERE token = :token");

				$stmt->bindParam(":token",$valor,PDO::PARAM_STR);

				#ejecutar la sentencia
				if ($stmt->execute()) {
					return "ok";
				} else {
					print_r(Conexion::conectar()->errorInfo());
				}

				$stmt->close();
				$stmt = null;

			}


		#Actualizar intentos Fallidos de ingreso:
			static public function mdlActualizarIntentosFallidos($tabla,$valor,$token){
				#statement-declaracion
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET intentos_fallidos = :intentos_fallidos WHERE token = :token");

				$stmt->bindParam(":intentos_fallidos",$valor,PDO::PARAM_INT);
				$stmt->bindParam(":token",$token,PDO::PARAM_STR);

				#ejecutar la sentencia
				if ($stmt->execute()) {
					return "ok";
				} else {
					print_r(Conexion::conectar()->errorInfo());
				}

				$stmt->close();
				$stmt = null;

			}


	}

?>