
-- GET NEXT QUESTION QUERY:
SELECT 
	quiz_question.question,
    quiz_question.correct_answer
FROM quiz_question 
LEFT JOIN quiz ON quiz_question.quiz_id=quiz.id
LEFT JOIN user_quiz_answers ON quiz_question.id=user_quiz_answers.question_id
WHERE 
	quiz.name='motorbike'
    AND quiz_question.id NOT IN (SELECT user_quiz_answers.question_id FROM user_quiz_answers)
LIMIT 0,1;



-- Get next question and answers
SELECT quiz_question.id AS qid, quiz_question.question, quiz_question.correct_answer, GROUP_CONCAT(quiz_answer.choice) AS choices, GROUP_CONCAT(quiz_answer.id) AS id_choices FROM quiz_question 
RIGHT JOIN quiz_answer ON quiz_question.id=quiz_answer.question_id
LEFT JOIN quiz ON quiz_question.quiz_id=quiz.id
LEFT JOIN user_quiz_answers ON quiz_question.id=user_quiz_answers.question_id
WHERE quiz.name='motorbike' AND quiz_question.id NOT IN (SELECT user_quiz_answers.question_id FROM user_quiz_answers)
GROUP BY qid
LIMIT 0,1;