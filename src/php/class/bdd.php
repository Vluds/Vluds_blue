<?php
class BDD
{
	private $bdd;

	private $host = "127.0.0.1";
	private $user = "root";
	private $password = "";
	private $bdname = "vluds_bdd";

	public function __construct()
	{
		$bddCon = mysqli_connect($this->host, $this->user, $this->password, $this->bdname);
		if(!$bddCon)
		{
            die("Nous sommes d&eacutesol&eacute : La connexion &agrave la base de donn&eacutees &agrave &eacutechou&eacutee ..."); 
        }
        else
        {
        	$this->bdd = $bddCon;
        }
	}

	public function select($id, $table, $options="")
	{
		return $this->bdd->query("SELECT ".$id." FROM ".$table." ".$options."");
	}

	public function insert($table, $id, $value)
	{
		return $this->bdd->query("INSERT INTO ".$table." (".$id.") VALUES (".$value.")");
	}

	public function update($table, $idValue, $options="")
	{
		return $this->bdd->query("UPDATE ".$table." SET ".$idValue." ".$options."");
	}

	public function delete($table, $idValue, $options="")
	{
		return $this->bdd->query("DELETE FROM ".$table." WHERE ".$idValue." ".$options."");
	}

	public function fetch_array($content)
	{
		return mysqli_fetch_array($content);
	}

	public function num_rows($content)
	{
		return mysqli_num_rows($content);
	}

	public function real_escape_string($content)
	{
		return mysqli_real_escape_string($this->bdd, $content);
	}
}
?>