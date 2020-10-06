<?php
    include 'DaoGender.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $model = new GenderDao();
        $json = $model->getGender();

        echo json_encode($json);
    }
?>