<?php
class Conexiondb{
    function conectar(){
        $DB = [
            'host'=>'bkgubwdskdrkm1z90qyz-mysql.services.clever-cloud.com',
            'username' => 'utje1ar6rtkwdjmy',
            'password' => 'kjXbGTm0fqSNOl6Z9HYK',
            'db' => 'bkgubwdskdrkm1z90qyz'
        ];
        try{
            $con = new PDO("mysql:host={$DB['host']};dbname={$DB['db']}",$DB['username'],$DB['password']);

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $con;
        }catch(PDOExecption $e){
            die("Error: "+$e->getMessage());
        }
    }
}   
?>