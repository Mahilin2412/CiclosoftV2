<?php
    include '../Conexion.php';
    include '../config.php';
    include '../classcategoryproduct.php';
    //include 'user.php';
    $conn = conectar($bd);

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        /*$IdProd = $_GET['IdProduct']; // Se obtiene el producto para la consulta 
        $FKIdTypeProd = $_GET['FKIdTypeProduct']; // Se obtiene la categoria del producto para la consulta 
        $FKIdUs = $_GET['FKIdUser'];*/

        $sql = $conn->prepare("SELECT * FROM categoryproduct"); // WHERE FKIdUser = 20;");
        /*$sentencia->bindParam(':Idprod',$IdProd, PDO::PARAM_INT);
        $sentencia->bindParam(':FKIdtypepr',$FKIdTypeProd, PDO::PARAM_INT);
        $sentencia->bindParam(':FKIdus',$FKIdUs, PDO::PARAM_INT);*/
        try{
            $sql->execute();
        }catch(PDOException $e){
            echo json_encode($e->getMessage());
            return;
        }
        
        header("http/1.1 200 ok");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql = $sql->fetchAll();
    
        echo json_encode($sql);

    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $datos = $_POST;
        //$ExistProduct = false;
       // $type = $_SERVER['CONTENT_TYPE'];

        //if($type != 'application/json'){
           // header("http/1.1 500 no es Json");
        //}
        //$content = trim(file_get_contents("php://input"));
        //$datos = json_decode($content,true);

        

        $categoryProduct = new Categoryproduct($datos['IdTypeProduct'], $datos['ReferenceType'], $datos['NameCategory'], $datos['FKIdUser'], 
                            $datos['Status'], $datos['UpdateTimestamp']);

        $sql = $conn->prepare("INSERT INTO categoryproduct(IdTypeProduct,ReferenceType,NameCategory,FKIdUser,Status,UpdateTimestamp) 
                               VALUES($product->IdTypeProduct,'$product->ReferenceType','$product->NameCategory',
                                $product->FKIdUser, '$product->Status', '$product->UpdateTimestamp')");

        try{
            $sql->execute();
            if(!$sql){
                throw new Exeption($sql->error);
            }
            $product->IdResponse = 0;
            $product->Response = "Registro exitoso";
            echo json_encode($product);
            return;
        }catch(Exeption $e){
            echo json_encode("Error en el SQL $e->getMessage()");
            return;
        }
        
        echo json_encode($product);
        return;
    }

    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
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
        
        echo json_encode("Registro eliminado exitosamente");
        exit();
    }
?>