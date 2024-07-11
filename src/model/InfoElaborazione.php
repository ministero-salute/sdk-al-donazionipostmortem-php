<?php
namespace AccessLayerMdS;

class InfoElaborazione
{
    public string $idTransazione;
    public string $idUpload;
    public string $idRun;
    public string $nomeFlusso;
    public string $timestampElaborazione;
    public string $version;
    public string $utenza;
    public string $esitoElaborazioneMds;
    public string $codiceErroreElaborazioneMds;
    public string $testoErroreElaborazioneMds;
    public string $validationPath;
    public string $statoDownloadFus;
    public string $esitoDownloadFus;
    public string $descrizioneErroreDownload;
    public string $codiceErroreDownloadFus;
}

class InfoElaborazioneCollection
{
    protected $_items=[];

    public function add($esito) {
        $this->_items[] = $esito;
    }

    public function first() {
        return $this->_items[0];
    }        
}
