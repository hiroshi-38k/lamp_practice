CREATE TABLE histories (
    history_id INT(11) AUTO_INCREMENT NOT NULL,
    user_id INT(11) NOT NULL,
    created DATETIME NOT NULL,
    primary key(history_id)
);
CREATE TABLE details (
    detail_id INT(11) AUTO_INCREMENT NOT NULL,
    history_id INT(11) NOT NULL,
    item_id INT(11) NOT NULL,
    price INT(11) NOT NULL,
    amount INT(11) NOT NULL,
    primary key(detail_id)
);