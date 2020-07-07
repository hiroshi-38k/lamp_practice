CREATE TABLE histories (
    history_id INT(11) AUTO_INCREMENT NOT NULL,
    user_id INT(11) NOT NULL,
    created DATETIME NOT NULL,
    primary key(history_id)
)