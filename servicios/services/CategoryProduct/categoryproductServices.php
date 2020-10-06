<?php
    include "DaoCategoryProduct.php"; 

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        //$IdTypeProd = $_GET['IdTypeProduct']; // Se obiene el id del tipo de producto para la consulta 
        ///$Reference = $_GET['ReferenceType']; // se obtiene el tipo de documento de identificación para la consulta

        $model = new CategoryProdDao();

        $json = $model->getCategoryProduct();
        echo json_encode($json);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $ExisteCategoryproduct = false;
        $type = $_SERVER['CONTENT_TYPE'];

        if($type != 'application/json'){
            header("http/1.1 500 no es Json");
        }
        $content = trim(file_get_contents("php://input"));
        $datos = json_decode($content,true);

        $model = new CategoryProdDao();
        $json = $model->postCategoryProduct($datos);

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

        $datosCategProd = array(
            'IdTypeProduct' => $datos['IdTypeProduct'],
            'ReferenceType' => $datos['ReferenceType'],
            'NameCategory' => $datos['NameCategory'],
            'FKIdUser' => $datos['FKIdUser'],
            'Status' => $datos['Status'],
            'UpdateTimestamp' => $datos['UpdateTimestamp'],
        );
        $IdTypeProd = $datos['IdTypeProduct'];
        $model = new CategoryProdDao();
        $json = $model->updateCategoryProduct($datosCategProd,$IdTypeProd,$datos);
        echo json_encode($json);
    }
    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

    }
?>