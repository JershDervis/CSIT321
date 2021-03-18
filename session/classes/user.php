<?php
class User {
	
    private $_db;
    
    function __construct($db){
    	$this->_db = $db;
    }
    
	private function get_user_hash($email){
		try {
			$stmt = $this->_db->prepare('SELECT password, email, id, admin, fullName FROM ' . DB_DATABASE . ' .users WHERE email = :email AND active="Yes"');
			$stmt->execute(array('email' => $email));
			return $stmt->fetch();
		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	}
	
	public function login($email,$password){
		$row = $this->get_user_hash($email);
		if($row) {
			if(password_verify($password,$row['password']) == 1){
				$_SESSION['loggedin'] = true;
				$_SESSION['email'] = $row['email'];
				$_SESSION['name'] = $row['fullName'];
				$_SESSION['id'] = $row['id'];
				return true;
			}
		}
	}
	
	public function logout(){
		session_unset();
		session_destroy();
	}
	
	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}

	public function sendDashboard() {
		header('Location: lessons.php'); 
	}

	public function sessionValidate() {
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
			session_unset();
			session_destroy(); 
			return false;
		}
		$_SESSION['LAST_ACTIVITY'] = time();
		return true;
		if (!isset($_SESSION['CREATED'])) {
			$_SESSION['CREATED'] = time();
		} else if (time() - $_SESSION['CREATED'] > 1800) {
			session_regenerate_id(true);
			$_SESSION['CREATED'] = time();
		}
	}

	public function unitExists($unitName) {
		try {
			$stmt = $this->_db->prepare('SELECT COUNT(1) FROM unit WHERE unit.name = :unitName ;');
			$stmt->execute(array('unitName' => $unitName));
			return $stmt->fetch()[0] == '0' ? false : true;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getUnitID($unitName) {
		try {
			$stmt = $this->_db->prepare('SELECT u.id FROM unit u WHERE u.name= :unitName ;');
			$stmt->execute(array('unitName' => $unitName));
			return intval($stmt->fetch()[0]);
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getUnitQuizes($unitID) {
		try {
			$stmt = $this->_db->prepare('SELECT q.id, q.name, q.size FROM quiz q WHERE q.unit_id= :unitID ;');
			$stmt->execute(array('unitID'	=>	$unitID));
			return $stmt->fetchAll();
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function quizExists($quizID) {
		try {
			$stmt = $this->_db->prepare('SELECT COUNT(1) FROM quiz WHERE quiz.id = :quizID ;');
			$stmt->execute(array('quizID' => $quizID));
			return $stmt->fetch()[0] == '0' ? false : true;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getUserQuizScore($quizID) {
		try {
			$stmt = $this->_db->prepare(
				"SELECT round(((COUNT(uqa.id) / q.size) * 100 ),0) as score FROM user_quiz_answers uqa 
				LEFT JOIN quiz_question qq ON uqa.question_id=qq.id 
				LEFT JOIN quiz q ON qq.quiz_id=q.id 
				WHERE q.id= :quizID AND uqa.user_id= :userID AND qq.correct_answer=uqa.answer");
				$stmt->execute(array(
					'quizID'	=>	$quizID,
					'userID'	=>	$_SESSION['id']
				));
				return $stmt->fetch()[0];
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	

	/**
	 * Returns the size of a quiz
	 */
	public function getQuizSize($quizID) {
		try {
			$stmt = $this->_db->prepare('SELECT size FROM quiz WHERE quiz.id = :quizID ;');
			$stmt->execute(array('quizID' => $quizID));
			return $stmt->fetch()[0];
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Find the next available question in the database
	 * Also pulls the options available with this question
	 * Also pulls the correct answer
	 */
	public function getNextQuestion($quizID) {
		try {
			$stmt = $this->_db->prepare(
				'SELECT qq.id AS qid, qq.question, qq.correct_answer FROM quiz_question qq 
				LEFT JOIN quiz q ON qq.quiz_id=q.id
				WHERE q.id= :quizID AND qq.id NOT IN (SELECT user_quiz_answers.question_id FROM user_quiz_answers WHERE user_quiz_answers.user_id= :userID )
				GROUP BY qid
				LIMIT 0,1;'
			);
			$stmt->execute(array(
				'quizID'	=>	$quizID,
				'userID'	=>	$_SESSION['id']
			));
			return $stmt->fetch();
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function isQuizComplete($quizID) {
		try {
			$stmt = $this->_db->prepare(
				'SELECT IF(COUNT(*) >= (SELECT q.size FROM quiz q WHERE q.id= :quizID ), "TRUE", "FALSE") FROM user_quiz_answers uqa 
				LEFT JOIN quiz_question qq ON uqa.question_id=qq.id
				WHERE qq.quiz_id= :quizID AND uqa.user_id= :userID ;'
			);
			$stmt->execute(array(
				'quizID'	=>	$quizID,
				'userID'	=>	$_SESSION['id']
			));
			return ($stmt->fetch()[0] == "TRUE") ? true : false;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getQuestionOptions($questionID) {
		try {
			$stmt = $this->_db->prepare(
				'SELECT qa.id, qa.choice FROM quiz_answer qa WHERE qa.question_id= :questionID ;'
			);
			$stmt->execute(array(
				'questionID'	=>	$questionID,
			));
			return $stmt->fetchAll();
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function submitAnswer($answerID) {
		try {
			$stmt = $this->_db->prepare(
				'INSERT INTO user_quiz_answers (id, user_id, question_id, answer) 
				 VALUES (NULL, :userID , (SELECT quiz_answer.question_id FROM quiz_answer WHERE quiz_answer.id= :answerID ), :answerID );'
			);
			$stmt->execute(array(
				'userID' => $_SESSION['id'],
				'answerID' => $answerID
			));
			return $stmt->fetchAll();
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getAnsweredAmnt($quizID) {
		try {
			$stmt = $this->_db->prepare(
				'SELECT COUNT(*) FROM user_quiz_answers uqa
				LEFT JOIN quiz_question qq ON uqa.question_id=qq.id
				LEFT JOIN quiz q ON qq.quiz_id=q.id
				WHERE q.id= :quizID AND uqa.user_id= :userID ;'
			);
			$stmt->execute(array(
				'quizID'	=>	$quizID,
				'userID'	=>	$_SESSION['id']
			));
			return $stmt->fetch()[0];
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getAmntCorrect($quizID) {
		try {
			$stmt = $this->_db->prepare(
				'SELECT COUNT(*) FROM user_quiz_answers uqa
				LEFT JOIN quiz_question qq ON uqa.question_id=qq.id
				LEFT JOIN quiz q ON qq.quiz_id=q.id
				WHERE q.id= :quizID AND uqa.user_id= :userID AND uqa.answer=qq.correct_answer;'
			);
			$stmt->execute(array(
				'quizID'	=>	$quizID,
				'userID'	=>	$_SESSION['id']
			));
			return $stmt->fetch()[0];
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
}
?>