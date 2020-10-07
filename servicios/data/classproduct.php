<?php
    class Products{
        public $IdProduct;
        public $NameProduct;
        public $Reference;
        public $ManIva;
        public $PorIva;
        public $Price;
        public $StatusProduct;
        public $Description;
        public $imageProduct;
        public $Clasification;
        public $FKIdTypeProduct;
        public $FKIdUser;
        public $Status;
        public $UpdateTimestamp;
        public $IdResponse;
        public $Response;
        
        function  __construct($Id,$namep,$refer,$mani,$pori,$pric,$statusp,$descr,$image,$clasif,$fkidtypep,$fkidu,$stat,$updateT){
            $this->IdProduct = $Id;
            $this->NameProduct = $namep;
            $this->Reference = $refer;
            $this->ManIva = $mani;
            $this->PorIva = $pori;
            $this->Price = $pric;
            $this->StatusProduct = $statusp;
            $this->Description = $descr;
            $this->imageProduct = $image;
            $this->Clasification = $clasif;
            $this->FKIdTypeProduct = $fkidtypep;
            $this->FKIdUser = $fkidu;
            $this->Status = $stat;
            $this->UpdateTimestamp = $updateT;


        }
    }
?>