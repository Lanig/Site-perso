<?php

namespace Core\Service;

use Core\Service\Log;

/**
* db
*/
class db extends \PDO
{
	public function __construct($host, $database, $user, $password = null, $debug = false)
	{
		if(!$debug) parent::__construct('mysql:host='.$host.';dbname='.$database.';charset=utf8', $user, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
		else parent::__construct('mysql:host='.$host.';dbname='.$database.';charset=utf8', $user, $password);
	}

	public function query($sql, $params = [])
	{
		try {
			$q = $this->prepare($sql);
			$q->execute($params);
			return $q;
		} catch (\PDOException $e) {
		    Log::error("database", "[PDOException] {$e->getMessage()}");
		    return false;
		}
	}
}