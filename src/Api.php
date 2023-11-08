<?php
namespace Fh;
class Api {
    
    private $apiRootUrl = apiRootUrl; // todo May be need to implement dependency injection 
    public function get($request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiRootUrl.$request,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . token // todo May be need to implement dependency injection  
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return Controller::toJson($response);
    }

}