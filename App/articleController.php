<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class articleController
{
	public function articlesList(Request $request, Response $response)
    {
        return ['msg'=>'success'];
    }
}