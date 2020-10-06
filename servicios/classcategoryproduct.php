<?php
    class categoryProduct{
        public $IdTypeProduct ;
        public $ReferenceType;
        public $NameCategory;
        public $FKIdUser;
        public $Status;
        public $UpdateTimestamp;
        public $IdResponse;
        public $Response;
        
        function  __construct($Id,$refer,$name,$fkidu,$stat,$updateT){
            $this->IdTypeProduct = $Id;
            $this->ReferenceType = $refer;
            $this->NameCategory = $name;
            $this->FKIdUser = $fkidu;
            $this->Status = $stat;
            $this->UpdateTimestamp = $updateT;


        }
    }
?>