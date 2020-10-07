<?php
    include "DaoTypeDocument.php"; 


    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $model = new TypeDocDao();

        $json = $model->getTypeDoc();
        echo json_encode($json);
    }
?>