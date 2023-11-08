<?php

namespace Fh;

class Controller {    
    private $legalRequests = [
        'projects',
    ];

    public function toJson($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function runByRequest($request) {
        
        if (!in_array($request, $this->legalRequests)) {
            return $this->toJson(['error' => 'Illegal request']);
        }
        
        $api = new Api();        
        $response = $api->get($request);        
        echo $this->toJson($response);
    }
}