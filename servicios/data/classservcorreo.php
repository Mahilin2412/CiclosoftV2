<?php
    class sercorreo{
        public $IdSerCorreo;
        public $IpServidorCorreo;
        public $Port;
        
        function  __construct($IdSerCor,$IdServ,$Port){
            $this->IdSerCorreo = $IdSerCor;
            $this->IpServidorCorreo = $IdServ;
            $this->Port = $Port;
        }
    }

?>