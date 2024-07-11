<?php
namespace AccessLayerMdS;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

class ServiceGateway
{
    public $client;

    public function callApiGateway(string $remotePath, string $uri, string $httpMethod, string|array $params) : mixed {
        try
        {
            #echo 'callApiGateway init' . '<br />';

            $this->client = new Client([
                // Base URI is used with relative requests
                'base_uri' => $remotePath,
                // You can set any number of default request options.
                'timeout'  => 5.0
            ]);
            $headers = [
                'Cache-Control' => 'no-cache',
                'Content-Type' => 'application/json',
                'Connection' => 'keep-alive',
                'Accept' => '*/*',
                'Accept-encoding' => 'gzip, deflate, br'
            ];

            #echo '$httpMethod=' . $httpMethod . '<br />';
    
            if ($httpMethod == 'POST') {
                $request = new Request('POST', $uri, $headers, $params);
                $response = $this->client->send($request);
            } else {
                #echo '$httpMethod else' . '<br />';
                #var_dump($params);
                #echo '<br />';
                $response = $this->client->request('GET', $uri, ['query' => $params]);

                // $response = $this->client->send($request);
                #var_dump($response);
            }

            $code = $response->getStatusCode();
            #echo '$code=' . $code . '<br />';
            $status = "OK";

            if($code == 200) {
                #echo '$response->getBody()=' . $response->getBody() . '<br />';
                if ($body = $response->getBody()) {
                    #echo '$body=' . $body . '<br />';
                    if ($httpMethod == 'GET') {
                        $json = json_decode($body);
                        #echo '$json=' . $json . '<br />';
                        return $json;
                    }else{
                        #echo '$body->getContents()=' . $body->getContents() . '<br />';
                        $contents = $body->getContents();
                        #echo '$contents=' . $contents . '<br />';
                        $json = json_decode($contents);
                        #echo '$json=' . $json . '<br />';
                        return $json;
                    }
                } else {
                    #echo 'else $body' . '<br />';
                }
                return null;
            }else{
                #echo 'code <> 200' . '<br />';
            }
            return null;
        } catch(GuzzleException $e) {
            #var_dump('GUZZLE EXCEPTION: ' . $e);
            throw new Exception("callApiGateway : ". $e);
        }
    }
}
