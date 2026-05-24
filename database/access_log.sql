CREATE TABLE access_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    code_scanned VARCHAR(255) NOT NULL,
    success TINYINT(1) NOT NULL DEFAULT 0,
    method VARCHAR(100) NOT NULL,
    failure_reason TEXT DEFAULT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_accesslog_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE SET NULL
);