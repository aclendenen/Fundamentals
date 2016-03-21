<?php

require_once('dbconfig.php');

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function register($fname,$lname,$pos,$email,$pass)
	{
		$pos = strtolower($pos);
		$email_code = md5( rand(0,1000) );
		try
		{
			$new_password = password_hash($pass, PASSWORD_DEFAULT);
			$stmt = $this->conn->prepare("INSERT INTO users(first_name,last_name,position,email,password,email_code) 
		                                               VALUES(:fname,:lname,:pos,:email, :pass,:email_code)");
			//$stmt = $this->conn->prepare("INSERT INTO users(first_name,last_name,position,email,password) 
		     //                                          VALUES(:fname,:lname,:pos,:email, :pass)");
												  
			$stmt->bindparam(":fname", $fname);
			$stmt->bindparam(":lname", $lname);
			$stmt->bindparam(":pos", $pos);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":pass", $new_password);
			$stmt->bindparam(":email_code", $email_code);										  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	
	public function login_user($email,$pass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email ");
			//$stmt = $this->conn->prepare("SELECT user_id,first_name,last_name,position,email, password FROM users WHERE email=:email ");
			$stmt->execute(array(':email'=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($pass, $userRow['password']) && $userRow['email_verify'])
				{
					$_SESSION['user_session'] = $userRow['user_id'];
					$_SESSION['first_name'] = $userRow['first_name'];
					$_SESSION['last_name'] = $userRow['last_name'];
					$_SESSION['position'] = $userRow['position'];
					$_SESSION['email'] = $userRow['email'];
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function redirect_with_flash($url, $msg)
	{
		header("Location: $url?flash_msg=$msg");
	}
	
	public function logout_user()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		unset($_SESSION['first_name']);
		unset($_SESSION['last_name']);
		unset($_SESSION['position']);
		unset($_SESSION['email']);
		return true;
	}
	
	public function pos_code_check($pos, $pos_code)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM positions WHERE position_code=:pos_code");
			$stmt->execute(array(':pos_code'=> $pos_code));
			$posRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if($posRow['position_type'] == strtolower($pos))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	
	public function verify_email($email, $email_code)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email AND email_code=:email_code");
			$stmt->execute(array(':email'=> $email, ':email_code' => $email_code));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				$stmt = $this->conn->prepare("UPDATE users SET email_verify='1' WHERE email=:email AND email_code=:email_code");
				$stmt->execute(array(':email'=> $email, ':email_code' => $email_code));
				return true;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	public function get_email_code($email)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email");
			$stmt->execute(array(':email'=> $email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				return $userRow['email_code'];

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
}
?>