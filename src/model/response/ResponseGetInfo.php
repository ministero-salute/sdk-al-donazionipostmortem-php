<?php
namespace AccessLayerMdS;

use DateTime;

class ResponseGetInfo
{
    public string $idRun;
    public string $idClient;
    public array $idUploads;
    public string $tipoElaborazione;
    public string $modOperativa;
    public string $dataInizioEsecuzione;
    public string $dataFineEsecuzione;
    public string $statoEsecuzione;
    public string $fineAssociatiRun;
    public string $nomeFlusso;
    public int $numeroRecord;
    public int $numeroRecordAccettati;
    public int $numeroRecordScartati;
    public string $version;
    public string $timestampCreazione;
    public string $utenza;
    public string $api;
    public string $identificativoSoggettoAlimentante;
    public string $tipoAtto;
    public string $numeroAtto;
    public string $tipoEsitoMds;
    public string $dataRicevutaMds;
    public string $codiceRegione;
    public string $annoRiferimento;
    public string $periodoRiferimento;
    public string $nomeFileOutputMds;
    public string $esitoAcquisizioneFlusso;
    public string $codiceErroreInvioFlusso;
    public string $testoErroreInvioFlusso;
} 
