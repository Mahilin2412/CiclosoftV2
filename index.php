<?php
    include "servicios/services/Products/DaoProduct.php";
    include "servicios/services/Products/DaoProduct.php";
    include "servicios/services/Products/DaoProduct.php";
    include "servicios/services/Products/DaoProduct.php";
    include "servicios/services/Products/DaoProduct.php";
    include "servicios/services/Products/DaoProduct.php";

       
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_GET['apicall'])){
            switch(isset($_GET['apicall'])){
                case 'productService':
                    $model = new ProductDao();

                    $json = $model->getProduct();
                    echo json_encode($json);
                break;
            }

        }
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    }
    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    }
    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    }
?>