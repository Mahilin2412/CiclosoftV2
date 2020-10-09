<?php
    class Providers{
        public $NumIdentification;
        public $FKIdTypeDoc;
        public $FirstNameProvider;
        public $SecondNameProvider;
        public $FirstLastNameProvider;
        public $SecondLastNameProvider;
        public $NameComplete;
        public $StatusProvider;
        public $FKIdUser;
        public $Status;
        public $UpdateTimestamp;
        public $IdResponse;
        public $Response;

        function __construct($Id,$fkidtyp,$fnam,$snam,$flnam,$slnam,$namcom,$statprov,$user,$stat,$updateT){
            $this->NumIdentification = $Id;
            $this->FKIdTypeDoc = $fkidtyp;
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