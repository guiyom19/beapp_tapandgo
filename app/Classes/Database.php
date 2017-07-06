<?php

// Database Class

namespace App\Classes;

class Database
{

	private $container;
	private $pdo;

	public function __construct($container)
	{
		$this->container = $container;
		$this->pdo = $this->container->pdo;
	}


	// query function to add datas

	public function add($sql)
	{

		$req = $this->pdo->prepare($sql);
		$result = $req->execute();
		return $result;

	}

	// query function to select datas

	public function select($sql)
	{

		$req = $this->pdo->prepare($sql);
		$req->execute();

		return $req->fetchAll();

	}
}