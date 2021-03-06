<?php

namespace Website\Model;
use \Website\DB\Sql;
use \Website\Model;

class User extends Model
{
	const SESSION = "User";

	public static function login($login, $password)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN" => $login
		));

		if (!count($results)) {

			throw new \Exception("Usuário inexistente ou senha inválida");

		}

		$data = $results[0];

		if ( password_verify($password, $data["despassword"]) ) {
			
			$user = new User();

			$user->setData($data);

			$_SESSION[ User::SESSION ] = $user->getData();
		} else {
			
			throw new \Exception("Usuário inexistente ou senha inválida");
		
		}
	}

	public static function verifyLogin()
	{
		if (
			!isset($_SESSION[User::SESSION])
			||
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]["iduser"] //em caso de estar vazio == 0 || == false
			||
			!(bool)$_SESSION[User::SESSION]["inadmin"] // true para admins, false para normal users*/
		) {
			header("Location: /admin/login");
			exit;
		}
	}

	public static function logout()
	{

		$_SESSION[User::SESSION] = null;

	}

	public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");
	}

	public function insert()
	{
		$sql = new Sql();

		$results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":desperson" 	=> $this->desperson, // valores buscados da classe Model, através do magic method __get()
			":deslogin" 	=> $this->deslogin,
			":despassword" 	=> $this->despassword,
			":desemail" 	=> $this->desemail,
			":nrphone" 		=> $this->nrphone,
			":inadmin" 		=> $this->inadmin
		));

		$this->setData($results[0]);
	}


	public function get($iduser)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser", array(
			":iduser" => $iduser
		));

		$this->setData($results[0]);

	}

	public function update($iduser)
	{
		$sql = new Sql();

		$results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":iduser" 		=> $iduser,
			":desperson" 	=> $this->desperson, // valores buscados da classe Model, através do magic method __get()
			":deslogin" 	=> $this->deslogin,
			":despassword" 	=> $this->despassword,
			":desemail" 	=> $this->desemail,
			":nrphone" 		=> $this->nrphone,
			":inadmin" 		=> $this->inadmin
		));

		$this->setData($results[0]);
	}

	public function delete()
	{
		$sql = new Sql();

		$sql->query("CALL sp_users_delete(:iduser)", array(
			":iduser"	=> $this->iduser
		));
	}

}


?>