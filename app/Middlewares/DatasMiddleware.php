<?php

/*  Middleware to get all cities and stations before rendering the twig template */

namespace App\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;

class DatasMiddleware
{

	private $twig;
	private $db;

	public function __construct(\Twig_Environment $twig, \App\Classes\Database $db)
	{
		$this->twig = $twig;
		$this->db = $db;
	}

	public function __invoke(Request $request, Response $response, $next)
	{
		$cities = $this->db->select('SELECT * FROM cities');
		$this->twig->addGlobal('cities', $cities);

		$stations = $this->db->select('SELECT * FROM stations');
		$this->twig->addGlobal('stations', $stations);
		
		return $next($request, $response);
	}
}