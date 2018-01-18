<?php
namespace Core\Modele;

/**
* Modele
*/
abstract class Modele
{
	public function __call($name, $args = [])
	{
		if (preg_match("/^get([\w]+)$/", $name, $res)) {
			$var = strtolower($res[1]);
			if (isSet($this->$var)) {
				return $this->$var;
			}
		} elseif (preg_match("/^set([\w]+)$/", $name, $res)) {
			$var = strtolower($res[1]);
			if (isSet($this->$var) && isSet($args[0])) {
				$this->$var = $args[0];
			}
		}
		return false;
	}

	public static function find($id)
	{
		global $db;

		$sql = "SELECT * FROM ".static::$table." WHERE id = :id LIMIT 1";

		$query = $db->query($sql, array('id' => $id));

			$query->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
			$result = $query->fetch(\PDO::FETCH_CLASS);
			$query->closeCursor();

		return $result;
	}

	public static function findBy($search = array())
	{
		global $db;

		$sql = "SELECT * FROM ".static::$table." WHERE 1";

			foreach ($search as $key => $value) {
				$sql .= " AND {$key} = :{$key}";
			}

		$query = $db->query($sql, $search);

			$result = $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
			$query->closeCursor();

		return $result;
	}

	public static function findOneBy($search = array())
	{
		global $db;

		$sql = "SELECT * FROM ".static::$table." WHERE 1";

			foreach ($search as $key => $value) {
				$sql .= " AND {$key} = :{$key}";
			}

		$sql .= " LIMIT 1";

		$query = $db->query($sql, $search);

			$query->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
			$result = $query->fetch(\PDO::FETCH_CLASS);
			$query->closeCursor();

		return $result;

	}
}