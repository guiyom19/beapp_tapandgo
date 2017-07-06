<?php

namespace App\Controllers;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;

// Pages Controller extends the main Controller

class PagesController extends Controller
{

	// Render the home page
	
	public function home(RequestInterface $request, ResponseInterface $response)
	{
		$this->render($response, 'pages/home.twig');
	}


	// Render the cities page

	public function getCities(RequestInterface $request, ResponseInterface $response)
	{
		return $this->render($response, 'pages/cities.twig');
	}


	// Handle the city form posted values, check with Validator and redirect to the same page

	public function postCities(RequestInterface $request, ResponseInterface $response)
	{
		$errors = [];
		Validator::notEmpty()->validate($request->getParam('name')) || $errors['name'] = 'Vous devez rentrer un nom de ville';
		Validator::notEmpty()->validate($request->getParam('latitude')) || $errors['latitude'] = 'Vous devez rentrer une latitude';
		Validator::notEmpty()->validate($request->getParam('longitude')) || $errors['longitude'] = 'Vous devez rentrer une longitude';
		
		$add = $this->addCity($request);
		
		if(empty($errors) && $add)
		{
			$this->flash('Votre ville a bien été ajoutée');
			return $this->redirect($response, 'cities');
		}else
		{
			$this->flash('Certains champs n\'ont pas été remplis correctement', 'error');
			$this->flash($errors, 'errors');
			return $this->redirect($response, 'cities', 400);
		}
	}

	// Render the stations page

	public function getStations(RequestInterface $request, ResponseInterface $response)
	{
		return $this->render($response, 'pages/stations.twig');
	}

	// Handle the station form posted values, check with Validator and redirect to the same page

	public function postStations(RequestInterface $request, ResponseInterface $response)
	{
		$errors = [];
		Validator::notEmpty()->validate($request->getParam('name')) || $errors['name'] = 'Vous devez rentrer un nom de ville';
		Validator::notEmpty()->validate($request->getParam('address')) || $errors['address'] = 'Vous devez rentrer une addresse';
		Validator::notEmpty()->validate($request->getParam('bikescapacity')) || $errors['bikescapacity'] = 'Vous devez rentrer une capacité de vélos';
		Validator::notEmpty()->validate($request->getParam('bikesavailable')) || $errors['bikesavailable'] = 'Vous devez rentrer un nombre de vélos disponibles';
		Validator::notEmpty()->validate($request->getParam('latitude')) || $errors['latitude'] = 'Vous devez rentrer une latitude';
		Validator::notEmpty()->validate($request->getParam('longitude')) || $errors['longitude'] = 'Vous devez rentrer une longitude';
		
		$add = $this->addStation($request);
		
		if(empty($errors) && $add)
		{
			$this->flash('Votre station a bien été ajoutée');
			return $this->redirect($response, 'stations');
		}else
		{
			$this->flash('Certains champs n\'ont pas été remplis correctement', 'error');
			$this->flash($errors, 'errors');
			return $this->redirect($response, 'stations', 400);
		}
	}

	
	//api cities result displayer

	public function displayCities(RequestInterface $request, ResponseInterface $response, $args)
	{
		
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
		$limit = isset($_GET['limit']) ? $_GET['limit'] : 9999;
		$cities = $this->db->select('SELECT id, name, latitude, longitude FROM cities LIMIT '.$page.', '.$limit.'');

		echo (json_encode($cities));
	}


	//api stations result displayer

	public function displayStations(RequestInterface $request, ResponseInterface $response, $args)
	{
		
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
		$limit = isset($_GET['limit']) ? $_GET['limit'] : 9999;
		$id_city = $args['cityid'];

		$stations = $this->db->select('SELECT id, creationDate, lastUpdate, name, address, description, latitude, longitude, bikesCapacity, bikesAvailable FROM stations WHERE id_city = '.$id_city.' LIMIT '.$page.', '.$limit.'');

		echo (json_encode($stations));
	}

}
