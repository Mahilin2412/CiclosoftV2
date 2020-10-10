<?php
    class User{
        public $IdUser;
        public $FirstName;
        public $SecondName;
        public $FirstLastName;
        public $SecondLastName;
        public $PerModProduct;
        public $PerOrder;
        public $PerInvoice;
        public $PerEntry;
        public $CodeUser;
        public $Password;
        public $RolUser;
        public $StatusUser;
        public $Status;
        public $UpdateTimeStamp;


        function  __construct($Id,$fnam,$snam,$flnam,$slnam,$pmprod,$pord,$pinvoice,$pentry,$cuser,$pass,$ruser,$suser,$stat,$updateT){
            $this->IdUser = $Id;
            $this->FirstName = $fnam;
            $this->SecondName = $snam;
            $this->FirstLastName = $flnam;
            $this->SecondLastName = $slnam;
            $this->PerModProduct = $pmprod;
            $this->PerOrder = $pord;
            $this->PerInvoice = $pinvoice;
            $this->PerEntry = $pentry;
            $this->CodeUser = $cuser;
            $this->Password = $pass;
            $this->RolUser = $ruser;
            $this->StatusUser = $suser;
            $this->Status = $stat;
            $this->UpdateTimeStamp = $updateT;

        }
    }
?>