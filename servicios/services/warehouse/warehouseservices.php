<?php
    include "daowarehouse.php"; 

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        $model = new WarehouseDao();

        $json = $model->getWarehouse();
        echo json_encode($json);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $ExistWarehouse = false;
        $type = $_SERVER['CONTENT_TYPE'];

        if($type != 'application/json'){
            header("http/1.1 500 no es Json");
        }
        $content = trim(file_get_contents("php://input"));
        $datos = json_decode($content,true);

        $model = new WarehouseDao();
        $json = $model->postWarehouse($datos);

        echo json_encode($json);
        
    }
    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        //Obtenemos el tipo de contenido del llamado del servicio
        $type = $_SERVER['CONTENT_TYPE'];

        //Siempre debe ser de tipo aplicación Json, de lo contrario enviamos error 
        if($type != 'application/json'){
            header("http/1.1 500 no es Json");
        }
        //Optenemos el Json y luego lo dejamos en un Array asociativo con la funcion json_decode...
        //está recibe como parametros el Json y (true o false) este ultimo es para que el array...
        //sea asociativo o no. 
        $content = trim(file_get_contents("php://input"));
        $datos = json_decode($content,true);

        $datosWareh = array(
            'IdWareHouse' => $datos['IdWareHouse'],
            'ReferenceWareHouse' => $datos['ReferenceWareHouse'],
            'NameWareHouse' => $datos['NameWareHouse'],
            'FKIdUserMan' => $datos['FKIdUserMan'],
            'StatusWareHouse' => $datos['StatusWareHouse'],
            'FKIdUser' => $datos['FKIdUser'],
            'Status' => $datos['Status'],
            'UpdateTimestamp' => $datos['UpdateTimestamp'],
        );
        $IdWareh = $datos['IdWareHouse'];
        $model = new WarehouseDao();
        $json = $model->updateWarehouse($datosWareh,$IdWareh,$datos);
        echo json_encode($json);
      
    }
    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

    }
?>