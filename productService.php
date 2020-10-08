<?php
    include "servicios/services/products/daoproduct.php";
    
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $model = new ProductDao();

        $json = $model->getProduct();
        echo json_encode($json);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $ExisteProduct = false;
        $type = $_SERVER['CONTENT_TYPE'];

        if($type != 'application/json'){
            header("http/1.1 500 no es Json");
        }
        $content = trim(file_get_contents("php://input"));
        $datos = json_decode($content,true);

        $model = new ProductDao();
        $json = $model->PostProduct($datos);

        echo json_encode($json);
        
    }
    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        //Optenemos el tipo de contenido del llamado del servicio
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

        $datosProduct = array(
            'IdProduct' => $datos['IdProduct'],
            'NameProduct' => $datos['NameProduct'],
            'Reference' => $datos['Reference'],
            'ManIva' => $datos['ManIva'],
            'PorIva' => $datos['PorIva'],
            'Price' => $datos['Price'],
            'StatusProduct' => $datos['StatusProduct'],
            'Description' => $datos['Description'],
            'imageProduct' => $datos['imageProduct'],
            'Clasification' => $datos['Clasification'],
            'FKIdTypeProduct' => $datos['FKIdTypeProduct'],
            'FKIdUser' => $datos['FKIdUser'],
            'Status' => $datos['Status'],
            'UpdateTimestamp' => $datos['UpdateTimestamp'],
        );
        $IdProd = $datos['IdProduct'];

        $model = new ProductDao();
        $json = $model->UpdateProduct($datosProduct,$IdProd,$datos);
        echo json_encode($json);
    }
    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $type = $_SERVER['CONTENT_TYPE'];

        if($type != 'application/json'){
            header("http/1.1 500 no es Json");
        }
        $content = trim(file_get_contents("php://input"));
        $datos = json_decode($content,true);

        $model = new ProductDao();
        $json = $model->deleteProduct($datos);

        echo json_encode($json);
    }
?>