<?php
namespace AccessLayerMdS;

class ResponseSendFile
{
    /*
    esempio response:
    $responseApi=object(stdClass)#37 (4) { ["descrizioneErrore"]=> string(0) "" ["idClient"]=> string(4) "1662" ["isIniziato"]=> bool(true) ["idrun"]=> string(3) "197" } 
     */
    public string $descrizioneErrore;
    public string $idClient;
    public bool $isIniziato;
    public string $idrun;
}
