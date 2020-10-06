<?php
    class Thirds{
        public $NumIdentification;
        public $FKIdTypeDoc;
        public $FirstNameThird;
        public $SecondNameThird;
        public $LastNameThird;
        public $SecondLastNameThird;
        public $FKIdGender;
        public $FKIdUser;
        public $Status;
        public $UpdateTimestamp;

        function  __construct($Id,$fnam,$snam,$flnam,$slnam,$gen,$fkidtype,$user,$stat,$updateT){
            $this->NumIdentification = $Id;
            $this->FirstNameThird = $fnam;
            $this->SecondNameThird = $snam;
            $this->LastNameThird = $flnam;
            $this->SecondLastNameThird = $slnam;
            $this->FKIdGender = $gen;
            $this->FKIdTypeDoc = $fkidtype;
            $this->FKIdUser = $user;
            $this->Status = $stat;
            $this->UpdateTimestamp = $updateT;
        }
    }
?>