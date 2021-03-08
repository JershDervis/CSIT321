<?php
class User {
	
    private $_db;
    
    function __construct($db){
    	$this->_db = $db;
    }
    
	private function get_user_hash($email){
		try {
			$stmt = $this->_db->prepare('SELECT password, email, id FROM ' . DB_DATABASE . ' .users WHERE email = :email AND active="Yes"');
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
		session_unset();
		session_destroy();
	}
	
	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}

	public function sendDashboard() {
		header('Location: user.php'); 
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

	public function quizExists($quizName) {
		try {
			$stmt = $this->_db->prepare('SELECT COUNT(1) FROM quiz WHERE quiz.name = :quizName');
			$stmt->execute(array('quizName' => $quizName));
			return $stmt->fetch()[0] == '0' ? false : true;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	

	/**
	 * Returns the size of a quiz
	 */
	public function getQuizSize($quizName) {
		try {
			$stmt = $this->_db->prepare('SELECT size FROM quiz WHERE quiz.name = :quizName');
			$stmt->execute(array('quizName' => $quizName));
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
	public function getNextQuestion($quizName) {
		try {
			$stmt = $this->_db->prepare(
				'SELECT quiz_question.id AS qid, quiz_question.question, quiz_question.correct_answer, GROUP_CONCAT(quiz_answer.choice) AS choices, GROUP_CONCAT(quiz_answer.id) AS id_choices FROM quiz_question 
				RIGHT JOIN quiz_answer ON quiz_question.id=quiz_answer.question_id
				LEFT JOIN quiz ON quiz_question.quiz_id=quiz.id
				LEFT JOIN user_quiz_answers ON quiz_question.id=user_quiz_answers.question_id
				WHERE quiz.name = :quizName AND quiz_question.id NOT IN (SELECT user_quiz_answers.question_id FROM user_quiz_answers)
				GROUP BY qid
				LIMIT 0,1;'
			);
			$stmt->execute(array('quizName' => $quizName));
			return $stmt->fetch();
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

	public function getAnsweredAmnt($quizName) {
		try {
			$stmt = $this->_db->prepare(
				'SELECT COUNT(*) FROM user_quiz_answers uqa
				LEFT JOIN quiz_question qq ON uqa.question_id=qq.id
				LEFT JOIN quiz q ON qq.quiz_id=q.id
				WHERE q.name= :quizName ;'
			);
			$stmt->execute(array('quizName' => $quizName));
			return $stmt->fetch()[0];
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
}
?>