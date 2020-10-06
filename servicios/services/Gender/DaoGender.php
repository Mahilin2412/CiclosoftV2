<?php
    include "../../Conexion.php";
    include '../../config.php';
    class GenderDao extends Conexiondb{
        private $conexion;
        public function __construct(){
            $this->conexion = Conexiondb::conectar();
        }

        public function getGender(){
            $sentencia = $this->conexion->prepare("SELECT * FROM Gender;");
            $sentencia->execute();
            header("http/1.1 200 ok");
            $sentencia->setFetchMode(PDO::FETCH_ASSOC);
            $sentencia = $sentencia->fetchAll();
            //echo json_encode($sentencia->fetch(PDO::FETCH_ASSOC)); solo un registro
            //echo json_encode($sentencia);
            return $sentencia;
        }
    }
?>