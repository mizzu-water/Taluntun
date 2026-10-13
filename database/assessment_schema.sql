CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trait VARCHAR(1) NOT NULL COMMENT 'R, I, A, S, E, C',
    question_text TEXT NOT NULL,
    test_set VARCHAR(10) NOT NULL COMMENT 'standard (1-60) or extended (61-120)',
    is_reverse_coded TINYINT(1) DEFAULT 0 COMMENT '1 if reverse coded, 0 otherwise'
);

CREATE TABLE IF NOT EXISTS user_assessments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    test_type INT NOT NULL COMMENT '60 or 120',
    status VARCHAR(20) DEFAULT 'in_progress' COMMENT 'in_progress, completed',
    current_question_index INT DEFAULT 0,
    answers JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
