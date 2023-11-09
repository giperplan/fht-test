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

    public function runAction($request) {
        $out = [];        
        
        if ($request === 'projects') {                         
            $out = (new Api())->getAllProjects(10);
        }
        
        if (!$out) {
            $out= ['error' => 'Illegal request'];
        }
        
        return $this->toJson($out);
    }
}