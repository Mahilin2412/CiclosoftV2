<?php
    class typedocument{
        public $IdTypeDoc;
        public $NameTypeDoc;
        public $AcroTypeDoc;
        public $FKIdUser;
        public $Status;
        public $UpdateTimestamp;

        function  __construct($Idtydoc,$nametydoc,$acrotydoc,$fkidus,$stat,$updateT){
            $this->IdTypeDoc = $Idtydoc;
            $this->NameTypeDoc = $nametydoc;
            $this->AcroTypeDoc = $acrotydoc;
            $this->FKIdUser = $fkidus;
            $this->Status = $stat;
            $this->UpdateTimestamp = $updateT;

        }
    }
?>