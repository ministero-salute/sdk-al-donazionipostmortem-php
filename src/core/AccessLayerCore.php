<?php
namespace AccessLayerMdS;

use AccessLayerMdS\RequestFlux;
use AccessLayerMdS\RequestSingleRecord;
use AccessLayerMdS\ResponseFlux;
use AccessLayerMdS\ResponseGetInfo;
use AccessLayerMdS\ResponseSendFile;
use AccessLayerMdS\ResponseSingleRecord;
use AccessLayerMdS\ServiceGateway;
use Exception;

class AccessLayerCore extends Base
{

    private string $remotePath;
    private string $fluxName;
    private string $endpoint;

    public function Init(string $host)
    {
        $this->remotePath = $host;
    }

    public function SendFlux(int $idClient, string $path, string $mod, string $annoRiferimento, string $periodoRiferimento, string $codiceRegione) : ResponseFlux
    {
        try
        {
            $response = null;

            $vars = array('{endpoint}' => $this->endpoint, '{fluxName}' => $this->fluxName);
            $baseUri = strtr("{endpoint}/{fluxName}", $vars);

            $request = new RequestFlux();
            $request->idClient = $idClient;
            $request->nomeFile = $path;
            $request->modalitaOperativa = $mod;
            $request->annoRiferimento = $annoRiferimento;
            $request->periodoRiferimento = $periodoRiferimento;
            $request->codiceRegione = $codiceRegione;

            $jsonRequest = json_encode($request);

            $service = new ServiceGateway();
            $responseApi = $service->callApiGateway($this->remotePath, $baseUri, "POST", $jsonRequest);
            var_dump($responseApi);
            echo '<br />';

            if($responseApi != null) {
                $response = parent::cast("ResponseFlux", $responseApi);
                var_dump($response);
            } else {
                throw new Exception("${baseUri} - response error.");
            }
        }
        catch (Exception $e) {
            $response = new ResponseFlux();
            $response->descrizioneErrore = $e->getMessage();
            $response->idrun = -9679;
        }

        return $response;
    }

    public function SendSingleRecord(int $idClient, Record $record, string $mod, string $annoRiferimento, string $periodoRiferimento, string $codiceRegione) : ResponseSingleRecord
    {
        try 
        {
            $response = null;

            $vars = array('{endpoint}' => $this->endpoint, '{fluxName}' => $this->fluxName);
            $baseUri = strtr("{endpoint}/{fluxName}", $vars);

            $request = new RequestSingleRecord();
            $request->idClient = strval($idClient);
            $request->modalitaOperativa = $mod;
            $request->recordDto = $record;
            $request->annoRiferimento = $annoRiferimento;
            $request->periodoRiferimento = $periodoRiferimento;
            $request->codiceRegione = $codiceRegione;

            $jsonRequest = json_encode($request); 

            $service = new ServiceGateway($this->remotePath);
            $responseApi = $service->callApiGateway($this->remotePath, $baseUri . '/record', "POST", $jsonRequest);

            if($responseApi != null) {
                $response = parent::cast("ResponseSingleRecord", $responseApi);
                $response->isValidato = true;
            } else {
                throw new Exception("${baseUri} - response error.");
            }
        }
        catch (Exception $e) {
            $response = new ResponseSingleRecord();
            $response->isValidato = false;
        }

        return $response;
    }

    public function GetInfo(int $idClient, int $idRun) : ResponseGetInfo
    {             
        try 
        {
            #echo 'GetInfo init' . '<br />';
            $response = null;
            
            $vars = array('{endpoint}' => $this->endpoint, '{fluxName}' => $this->fluxName);
            $baseUri = strtr("{endpoint}/{fluxName}", $vars);
            #echo '$this->remotePath=' . $this->remotePath . '<br />';
            #echo '$baseUri=' . $baseUri . '<br />';

            if ($idClient == 0 && $idRun == 0) {
                throw new Exception("GetInfo not start");
            }

            $queryParams = [];    
            if ($idClient != 0) {
                $queryParams["idClient"] = $idClient; 
            } if ($idRun != 0) {
                $queryParams["idRun"] = $idRun; 
            }
            #var_dump($queryParams);
            
            $service = new ServiceGateway($this->remotePath);
            #echo 'ServiceGateway::callApiGateway init' . '<br />';
            $responseApi = $service->callApiGateway($this->remotePath, $baseUri . '/info', "GET", $queryParams);
            var_dump($responseApi);
            echo '<br />';
            #echo 'ServiceGateway::callApiGateway end' . '<br />';

            if ($responseApi != null) {
                #echo '$responseApi != null' . '<br />';
                $response = parent::cast("ResponseGetInfo", $responseApi);
                var_dump($response);
            } else {
                throw new Exception("${baseUri} - response error.");
            }

            #echo 'GetInfo out' . '<br />';
        }
        catch (Exception $e) {
            $response = new ResponseGetInfo();
        }
        
        return $response;
    }

    public function getRemotePath() {
        return $this->remotePath;
    }

    /**
     * Set the value of RemotePath
     *
     * @return  self
     */ 
    public function setRemotePath($remotePath) {
        $this->remotePath = $remotePath;#->getParametersString();
        return $this;
    }

    public function getFluxName() {
        return $this->fluxName;
    }

    /**
     * Set the value of fluxName
     *
     * @return  self
     */ 
    public function setFluxName($fluxName) {
        $this->fluxName = $fluxName;#->getParametersString();
        return $this;
    }

    public function getEndpoint(){
        return $this->endpoint;
    }

    /**
     * Set the value of endpoint
     *
     * @return  self
     */ 
    public function setEndpoint($endpoint){
        $this->endpoint = $endpoint;#->getParametersString();
        return $this;
    }
}
