<?php
    class Customers{
        public $NumIdentification;
        public $FirstNameCustomer;
        public $SecondNameCustomer;
        public $FirstLastNameCustomer;
        public $SecondLastNameCustomer;
        public $Password;
        public $Mail;
        public $Address;
        public $AddressEntry;
        public $NumberPhone;
        public $FKIdTypeDoc;
        public $FKIdUser;
        public $Status;
        public $UpdateTimeStamp;
        public $IdGender;
        public $name;
        public $IdResponse;
        public $Response;

        function  __construct($Id,$fnam,$snam,$flnam,$slnam,$pass,$mail,$Addres,$addressEntr,$numphone,$fkidtype,$user,$stat,$updateT,$Idgen,$Nam){
            $this->NumIdentification = $Id;
            $this->FirstNameCustomer = $fnam;
            $this->SecondNameCustomer = $snam;
            $this->FirstLastNameCustomer = $flnam;
            $this->SecondLastNameCustomer = $slnam;
            $this->Password = $pass;
            $this->Mail = $mail;
            $this->Address = $Addres;
            $this->AddressEntry = $addressEntr;
            $this->NumberPhone = $numphone;
            $this->FKIdTypeDoc = $fkidtype;
            $this->FKIdUser = $user;
            $this->Status = $stat;
            $this->UpdateTimeStamp = $updateT;
            $this->IdGender = $Idgen;
            $this->name = $Nam;

        }
    }
?>