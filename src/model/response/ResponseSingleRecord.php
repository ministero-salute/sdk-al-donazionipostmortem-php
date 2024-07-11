<?php
namespace AccessLayerMdS;

use AccessLayerMdS\EsitiValidazione as ModelEsitiValidazione;

class ResponseSingleRecord
{
    public bool $isValidato;
    public ModelEsitiValidazione $esitiValidazione;
    public string $nomeTracciato;
    public string $idRun;
    public string $idClient;
}
