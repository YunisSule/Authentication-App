CREATE TABLE IF NOT EXISTS `users`
(
    username    varchar(25) NOT NULL,
    password    varchar(255) NOT NULL,
    PRIMARY KEY (username)
);

CREATE TABLE IF NOT EXISTS `user_data`
(
    username    varchar(50) NOT NULL,
    firstname   varchar(50) NOT NULL,
    lastname    varchar(50) NOT NULL,
    email       varchar(50) NOT NULL,
    address     varchar(50) NOT NULL,
    city        varchar(50) NOT NULL,
    postal_code varchar(50) NOT NULL,
    PRIMARY KEY (username),
    FOREIGN KEY (username) REFERENCES `users` (username) ON DELETE CASCADE
);
