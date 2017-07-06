<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;

class Controller
{
	private $container;

	public function __construct($container)
	{
		$this->container = $container;
	}



	// render the twig templates

	public function render(ResponseInterface $response, $file, $params = [])
	{
		$this->container->view->render($response, $file, $params);
	}
	
	//redirect to a specific location with a status

	public function redirect($response, $name, $status = 302)
	{
		return $response->withStatus($status)->withHeader('Location', $this->router->pathFor($name));
	}

	// stock session flash error message into the session

	public function flash($message, $type = 'success')
	{
		if(!isset($_SESSION['flash']))
		{
			$_SESSION['flash'] = [];
		}

		return $_SESSION['flash'][$type] = $message;
	}

	// add a city to the database

	public function addCity($request)
	{
		$query = 	"INSERT INTO `tapandgo`.`cities` (`id`, `name`, `latitude`, `longitude`, `activated`) 
					VALUES (NULL, '".$request->getParam('name')."', 
					'".$request->getParam('latitude')."', 
					'".$request->getParam('longitude')."',
					'1')";

		$add = $this->db->add($query);
		return $add;
	}

	// add a station to the database

	public function addStation($request)
	{

		$query = 	"INSERT INTO `tapandgo`.`stations` (`id`, `id_city`, `creationDate`, `lastUpdate`, `name`, `address`, `description`, `latitude`, `longitude`, `bikesCapacity`, `bikesAvailable`, `activated`) 
					VALUES (NULL, 
					'".$request->getParam('city')."',
					CURRENT_TIME(), CURRENT_TIME(),
					'".$request->getParam('name')."',
					'".str_replace("'", "&#039;", $request->getParam('address'))."',
					'".str_replace("'", "&#039;", $request->getParam('description'))."',
					'".$request->getParam('latitude')."',
					'".$request->getParam('longitude')."',
					'".$request->getParam('bikescapacity')."',
					'".$request->getParam('bikesavailable')."',
					'1')";

		$add = $this->db->add($query);
		return $add;
	}

	

	public function __get($name)
	{
		return $this->container->get($name);
	}


}