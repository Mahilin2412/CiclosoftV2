<?php
    class warehouse{
        public $IdWareHouse;
        public $ReferenceWareHouse;
        public $NameWareHouse;
        public $FKIdUserMan;
        public $StatusWareHouse;
        public $FKIdUser;
        public $Status;
        public $UpdateTimestamp;
        public $IdResponse;
        public $Response;
        
        function  __construct($Id,$refer,$name,$fkidusm,$statware,$fkidu,$stat,$updateT){
            $this->IdWareHouse = $Id;
            $this->ReferenceWareHouse = $refer;
            $this->NameWareHouse = $name;
            $this->FKIdUserMan = $fkidusm;
            $this->StatusWareHouse = $statware;
            $this->FKIdUser = $fkidu;
            $this->Status = $stat;
            $this->UpdateTimestamp = $updateT;
        }
    }
?>