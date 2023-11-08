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
        return $response;
    }
    // todo May be need to create an individual caching class  
    public function getCached ($request, $cacheTime = 300) {
        $cacheFile = __DIR__ . '/../cache/' . md5($request) . '.json';
        if (file_exists($cacheFile) and (time() - filemtime($cacheFile) < $cacheTime)) {
            return file_get_contents($cacheFile);
        }
        $response = $this->get($request);
        file_put_contents($cacheFile, $response);
        return $response;
    }
}