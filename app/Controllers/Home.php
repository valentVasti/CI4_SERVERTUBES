<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $response = [
            'status' => 200,
            'error' => "false",
            'message' => '',
            'data' => 'ppekkkkkkkkkkkkkkkkkkkk',
        ];

        return $this->response->setJSON($response);
    }
}
