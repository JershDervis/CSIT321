/**
* CLEANUP
*/


-- CREATE DATABASE IF NOT EXISTS ds;

-- CREATE USER 'admin'@'localhost' IDENTIFIED BY 'abc123';

-- GRANT ALL PRIVILEGES ON * . * TO 'admin'@'localhost'; /* TODO: Assess privileges */

-- FLUSH PRIVILEGES;


CREATE TABLE IF NOT EXISTS users (
    id              INT(10)             AUTO_INCREMENT,
    email           VARCHAR(255)        NOT NULL,
    fullName        VARCHAR(100)        NOT NULL,
    password        VARCHAR(255)        NOT NULL,
    admin           TINYINT(1)          DEFAULT 0,
    active          VARCHAR(255)        NOT NULL,
    resetToken      VARCHAR(255)        DEFAULT NULL,
    resetComplete   VARCHAR(3)          DEFAULT 'No',
    dor             TIMESTAMP, /* dor = Date of Registration */
    PRIMARY KEY(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS unit (
    id      INT(10)         AUTO_INCREMENT,
    name    VARCHAR(100)    NOT NULL,
    PRIMARY KEY(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS quiz (
    id      INT(10)         AUTO_INCREMENT,
    unit_id INT(10)         NOT NULL,
    name    VARCHAR(100)    NOT NULL,
    size    INT(10)         DEFAULT (10),
    PRIMARY KEY(id),
    FOREIGN KEY (unit_id)   REFERENCES unit(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- /**
--  *  Questions for Quizes
--  *      Each questions belongs to a quiz
--  */
CREATE TABLE IF NOT EXISTS quiz_question (
    id          INT(10)         AUTO_INCREMENT,
    quiz_id     INT(10)         NOT NULL,
    question    VARCHAR(255)    NOT NULL,
    correct_answer      INT(10)         NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (quiz_id)   REFERENCES  quiz(id),
    FOREIGN KEY (correct_answer)    REFERENCES  quiz_answer(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- /**
--  *  Possible answers for a question
--  *      Stores a users answer to a question
--  */
CREATE TABLE IF NOT EXISTS quiz_answer (
    id  INT(10) AUTO_INCREMENT  NOT NULL,
    question_id INT(10)         NOT NULL,
    choice      VARCHAR(150)    NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (question_id)   REFERENCES  quiz_question(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE user_quiz_answers (
    id int(10)          AUTO_INCREMENT,
    user_id int(10)     NOT NULL,
    question_id int(10) NOT NULL,
    answer int(10)      NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)       REFERENCES  users(id),
    FOREIGN KEY (question_id)   REFERENCES  quiz_question(id),
    FOREIGN KEY (answer)        REFERENCES  quiz_answer(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;