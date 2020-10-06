<?php
    class Providers{
        public $NumIdentification;
        public $FKIdTypeDoc;
        public $FirstNameProvider;
        public $SecondNameProvider;
        public $FirstLastNameProvider;
        public $SecondLastNameProvider;
        public $NameComplete
        public $StatusProvider;
        public $FKIdUser;
        public $Status;
        public $UpdateTimestamp;
        public $IdResponse;
        public $Response;

        function  __construct($Id,fkidtype,$fnam,$snam,$flnam,$slnam,$namcom,$statprov,$user,$stat,$updateT){
            $this->NumIdentification = $Id;
            $this->FKIdTypeDoc = $fkidtype;
            $this->FirstNameProvider = $fnam;
            $this->SecondNameProvider = $snam;
            $this->FirstLastNameProvider = $flnam;
            $this->SecondLastNameProvider = $slnam;
            $this->NameComplete = $namcom;
            $this->StatusProvider = $statprov;
            $this->FKIdUser = $user;
            $this->Status = $stat;
            $this->UpdateTimestamp = $updateT;
        }
    }
?>