<?php
namespace AccessLayerMdS;

require 'loader.php';

use AccessLayerMdS\AccessLayerCore;
use Exception;

class AccessLayer extends AccessLayerCore
{
    function __construct()
    {
        parent::setRemotePath("http://localhost:8080");
        parent::setEndpoint("v1/flusso");
        parent::setFluxName("FLUSSO_DPM");
    }

    public function SendFile(string $idClient, string $nomeFile) : ResponseSendFile
    {
        try
        {
            $response = null;

            $endpoint = "/v1/flusso/" . parent::getFluxName(); # . "/record";

            $vars = array('{endpoint}' => $endpoint);
            $baseUri = strtr("{endpoint}", $vars);

            $request = new RequestSendFile();
            $request->idClient = $idClient;
            $request->nomeFile = $nomeFile;

            $jsonRequest = json_encode($request);

            $service = new ServiceGateway();
            $responseApi = $service->callApiGateway($this->getRemotePath(), $baseUri, "POST", $jsonRequest);
            echo '$responseApi='; var_dump($responseApi);
            echo '<br />';

            if($responseApi != null) {
                echo 'pre cast' . '<br />';
                $response = parent::cast("ResponseSendFile", $responseApi);
                var_dump($response);
            } else {
                throw new Exception("${baseUri} - response error.");
            }
        }
        catch (Exception $e) {
            #var_dump($e);
            $response = new ResponseSendFile();
            $response->success = false;
            $response->message = $e->getMessage();
        }

        return $response;
    }

    public function StateVerify(string $identificativoSoggettoAlimentante,
                                string $regioneSoggettoAlimentante,
                                string $cap,
                                string $codiceSoggettoAlimentante,
                                string $indirizzo)
    {
        try
        {
            $response = null;

            $endpoint = "/v1/flusso/" . parent::getFluxName() . "/stato/" . $identificativoSoggettoAlimentante;
             echo $endpoint . '<br />';

            $vars = array('{endpoint}' => $endpoint);
            $baseUri = strtr("{endpoint}", $vars);
             echo $baseUri . '<br />';

            $queryParams = [];    
            if ($regioneSoggettoAlimentante != null)
            {
               $queryParams["regioneSoggettoAlimentante"] = $regioneSoggettoAlimentante; 
            }
            if ($cap != null)
            {
                $queryParams["cap"] = $cap; 
            }
            if ($codiceSoggettoAlimentante != null)
            {
               $queryParams["codiceSoggettoAlimentante"] = $codiceSoggettoAlimentante; 
            }
            if ($indirizzo != null)
            {
                $queryParams["indirizzo"] = $indirizzo; 
            }
                
            $service = new ServiceGateway();
            echo 'pre gateway'. '<br />';
            $responseApi = $service->callApiGateway($this->getRemotePath(), $baseUri, "GET", $queryParams);
            var_dump($responseApi);
            echo '<br />';

            if($responseApi != null) {
                echo 'pre cast'. '<br />';
                $response = parent::cast("ResponseStateVerify", $responseApi);
                var_dump($response);
            } else {
                throw new Exception("${baseUri} - response error.");
            }
        }
        catch (Exception $e) {
            var_dump($e);
            $response = new ResponseStateVerify();
            $response->message = $e->getMessage();
        }

        return $response;
    }
}