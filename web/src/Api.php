<?php
namespace Fh;
class Api {
    
    private $apiRootUrl = apiRootUrl; // todo May be need to implement dependency injection 
    public function get($request):string
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
    
    public function getAllProjects($pages = 2) {
        $projects = [];
        $loadedIds = [];
        foreach (range(1, $pages) as $page) {            
            $loadedProjects = $this->getCached('projects?page[number]=' . $page, 600)['data'];
            foreach ($loadedProjects as $project) {
                if (isset($loadedIds[$project['id']])) {
                    continue;
                }
                $loadedIds[$project['id']] = true;
                $projects[] = $project;   
            }            
        }
        return $projects;
    }
    
    // todo May be need to create an individual caching class  
    public function getCached ($request, $cacheTime = 300) {
        $cacheFile = __DIR__ . '/../cache/' . md5($request) . '.json';
        if (file_exists($cacheFile) and (time() - filemtime($cacheFile) < $cacheTime)) {
            return json_decode(file_get_contents($cacheFile), true);
        }
        $response = $this->get($request);
        file_put_contents($cacheFile, $response);
        return json_decode($response, true);
    }
}