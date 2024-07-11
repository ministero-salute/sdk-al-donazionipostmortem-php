<?php
namespace AccessLayerMdS;

class Esito
{
    public string $campo;
    public bool $valoreEsito;
    public array $erroriValidazione;
}

class EsitoCollection
{
    protected $_items=[];

    public function add($esito) {
        $this->_items[] = $esito;
    }

    public function first() {
        return $this->_items[0];
    }        
}
