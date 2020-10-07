<?php
    include '../Conexion.php';
    include '../config.php';
    include '../classproduct.php';
    //include 'user.php';
    //include 'categoryproduct.php';
    $conn = conectar($bd);

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        
        $sentencia = $conn->prepare("SELECT A.*,B.CantidadItems FROM products A,(SELECT COUNT(*) AS CantidadItems FROM products WHERE StatusProduct = 1) B WHERE StatusProduct = 1;");
        try{
            $sql->execute();
        }catch(PDOException $e){
            echo json_encode($e->getMessage());
            return;
        }
        
        header("http/1.1 200 ok");
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia = $sentencia->fetchAll();
        //print_r($sentencia);
        echo json_encode($sentencia);
    }

    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $content = trim(file_get_contents("php://input"));
        $datos = json_decode($content,true);
        $imagen = $datos['imageProduct'];
        echo json_encode($imagen);
        $sentencia = $conn->prepare("UPDATE products SET imageProduct = '$imagen' WHERE IdProduct = 1");
        //$sentencia->bindValue(':imageProduct',$imagen,PARAM_STR);
        try{
            $sql->execute();
            $product->Response = "Ok";
        }catch(Exeption $e){
            echo json_encode("Error en el SQL $e->getMessage()");
            exit();
        }
        
        echo json_encode("Registro actualizado exitosamente");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $datos = $_POST;

        $product = new Products($datos['IdProduct'], $datos['NameProduct'], $datos['Reference'], $datos['ManIva'], 
                                $datos['PorIva'], $datos['Price'], $datos['StatusProduct'], $datos['Description'], 
                                $datos['imageProduct'], $datos['Clasification'], $datos['FKIdTypeProduct'], $datos['FKIdUser'],
                                $datos['Status'], $datos['UpdateTimestamp']);
        $sql = $conn->prepare("INSERT INTO Products(IdProduct,NameProduct,Reference,ManIva,PorIva,Price,StatusProduct,Description,
                                    imageProduct,Clasification,FKIdTypeProduct,FKIdUser,Status,UpdateTimestamp)
                                    VALUES($product->IdProduct,'$product->NameProduct','$product->Reference',
                                    $product->ManIva,$product->PorIva,$product->Price,$product->StatusProduct,
                                    '$product->Description','$product->imageProduct','$product->Clasification',$product->FKIdTypeProduct,
                                    $product->FKIdUser, '$product->Status', '$product->UpdateTimestamp')");
        try{
            $sql->execute();
        }catch(Exeption $e){
            echo json_encode("Error en el SQL $e->getMessage()");
            exit();
        }
        $imagen = base64_decode($imagen);
        echo json_encode($imagen);
    }  
?>