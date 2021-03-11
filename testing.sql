-- SELECT qq.id AS qid, qq.question, qq.correct_answer, GROUP_CONCAT(qa.choice) AS choices, GROUP_CONCAT(qa.id) AS id_choices FROM quiz_question qq 
-- RIGHT JOIN quiz_answer qa ON qq.id=qa.question_id
-- LEFT JOIN quiz q ON qq.quiz_id=q.id
-- LEFT JOIN user_quiz_answers uqa ON qq.id=uqa.question_id
-- WHERE q.name='motorbike' AND qq.id NOT IN (SELECT user_quiz_answers.question_id FROM user_quiz_answers WHERE user_quiz_answers.user_id=1)
-- GROUP BY qid
-- LIMIT 0,1;


-- Get next question
SELECT qq.id AS qid, qq.question, qq.correct_answer FROM quiz_question qq 
LEFT JOIN quiz q ON qq.quiz_id=q.id
WHERE q.name= :quizName AND qq.id NOT IN (SELECT user_quiz_answers.question_id FROM user_quiz_answers WHERE user_quiz_answers.user_id= :userID )
GROUP BY qid
LIMIT 0,1;

--Get question options
SELECT qa.id, qa.choice FROM quiz_answer qa WHERE qa.question_id= :questionID;

-- Insert user answer for quiz
INSERT INTO user_quiz_answers (id, user_id, question_id, answer) 
VALUES (NULL, :userID , (SELECT quiz_answer.question_id FROM quiz_answer WHERE quiz_answer.id= :answerID ), :answerID);

-- Get the users position in a quiz (returns how many questions have been answered for the quiz)
SELECT COUNT(*) FROM user_quiz_answers uqa
LEFT JOIN quiz_question qq ON uqa.question_id=qq.id
LEFT JOIN quiz q ON qq.quiz_id=q.id
WHERE q.name='motorbike' AND uqa.user_id=1;


--TEST DATA
INSERT INTO `quiz`(`id`, `name`, `size`) VALUES (NULL,'motorbike',10);

INSERT INTO `quiz_question`(`id`, `quiz_id`, `question`, `correct_answer`) VALUES (NULL, 1,'Which of the following motorcycle parts require lubrication?',1);
INSERT INTO `quiz_question`(`id`, `quiz_id`, `question`, `correct_answer`) VALUES (NULL, 1,'What is the speed limit in an active school-zone?',5);
INSERT INTO `quiz_question`(`id`, `quiz_id`, `question`, `correct_answer`) VALUES (NULL, 1,'Are you required to wear a helmet at all times?',9);
INSERT INTO `quiz_question`(`id`, `quiz_id`, `question`, `correct_answer`) VALUES (NULL, 1,'How many passengers can a learner rider have?',10);
INSERT INTO `quiz_question`(`id`, `quiz_id`, `question`, `correct_answer`) VALUES (NULL, 1,'When approaching a roundabout which way must you give-way to?',14);
INSERT INTO `quiz_question`(`id`, `quiz_id`, `question`, `correct_answer`) VALUES (NULL, 1,'Can a P1 or P2 provisional driver legally instruct a learner driver?',16);
INSERT INTO `quiz_question`(`id`, `quiz_id`, `question`, `correct_answer`) VALUES (NULL, 1,'If there are no lanes marked on the road, you should drive..',20);
INSERT INTO `quiz_question`(`id`, `quiz_id`, `question`, `correct_answer`) VALUES (NULL, 1,'When reversing you should..',22);
INSERT INTO `quiz_question`(`id`, `quiz_id`, `question`, `correct_answer`) VALUES (NULL, 1,'Are you permitted to park on a median strip or traffic island?',27);
INSERT INTO `quiz_question`(`id`, `quiz_id`, `question`, `correct_answer`) VALUES (NULL, 1,'When driving at sunset or dawn on a dark day, what should you do?',29);


INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,1,'Chain');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,1,'Cylinder');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,1,'Tapet');

INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,2,'30 km/h');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,2,'40 km/h');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,2,'60 km/h');

INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,3,'Yes.. but only when going over 30 km/h');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,3,'No');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,3,'Yes');

INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,4,'None');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,4,'1');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,4,'2');

INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,5,'Left');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,5,'Right');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,5,'Both directions');

INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,6,'No');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,6,'Yes.. provided the provisional driver has held a P2 licence for more than 6 months');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,6,'Yes.. provided L and P1 or P2 plates are displayed');

INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,7,'Anywhere on your side of the road');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,7,'Near to the left-hand side of the road');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,7,'Along the middle of the road');

INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,8,'Take care and never reverse for a greater distance and time than is necessary');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,8,'Unbuckle your seat belt so you can reverse as quickly as possible');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,8,'Sound your horn to warn other drivers');

INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,9,'Yes.. provided no taxis are using the area');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,9,'Yes.. if you are carrying two or more passengers');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,9,'No.. not at any time');

INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,10,'Keep your sunglasses on to cut down headlight glare');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,10,'Turn on your lights on low beam');
INSERT INTO `quiz_answer`(`id`, `question_id`, `choice`) VALUES (NULL,10,'Turn on your hazard warning lights');