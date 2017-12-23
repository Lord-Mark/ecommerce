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
}


?>