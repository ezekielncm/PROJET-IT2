<?php
namespace model;

class typepaiement{

private string $type_Paiement;

public function __construct(string $type_Paiement){
    $this->type_Paiement =  $type_Paiement;
}

public function getType_Paiement(): string{
    return $this->type_Paiement;
}
    
}