<?php
    include "../../Conexion.php";
    include '../../config.php';
    class TypeDocDao extends Conexiondb{
        private $conexion;
        public function __construct(){
            $this->conexion = Conexiondb::conectar();
        }

        public function getTypeDoc(){
            $sentencia = $this->conexion->prepare("SELECT * FROM typedocument;");
            try{
                $sentencia->execute();
            }catch(PDOException $e){
                print json_encode($e->getMessage());
            }
        
            header("http/1.1 200 ok");
            $sentencia->setFetchMode(PDO::FETCH_ASSOC);
            $sentencia = $sentencia->fetchAll();
            //echo json_encode($sentencia);
            return $sentencia;
        }
    }
?>