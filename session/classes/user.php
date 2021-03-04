<?php
class User {
	
    private $_db;
    
    function __construct($db){
    	$this->_db = $db;
    }
    
	private function get_user_hash($email){
		try {
			$stmt = $this->_db->prepare('SELECT password, email, id FROM ' . DB_DATABASE . ' .accounts WHERE email = :email AND active="Yes"');
			$stmt->execute(array('email' => $email));
			return $stmt->fetch();
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	}
	
	public function login($email,$password){
		$row = $this->get_user_hash($email);
		if(password_verify($password,$row['password']) == 1){
		    $_SESSION['loggedin'] = true;
		    $_SESSION['email'] = $row['email'];
		    $_SESSION['id'] = $row['id'];
		    return true;
		}
	}
	
	public function logout(){
		session_destroy();
	}
	
	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}
}
?>