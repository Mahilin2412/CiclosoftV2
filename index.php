<?php
    
    


       
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_GET['apicall'])){
            switch($_GET['apicall']){
                case 'productService':
                    include "servicios/services/Products/DaoProduct.php";
                    $model = new ProductDao();

                    $json = $model->getProduct();
                    echo json_encode($json);
                break;
                case 'categoryProduct':
                    include "servicios/services/CategoryProduct/DaoCategoryProduct.php";
                    $model = new CategoryProdDao();

                    $json = $model->getCategoryProduct();
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