<?php

return [
    'up' => "
        CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(100),
            password VARCHAR(255)
        )
    ",
    'down' => "DROP TABLE users"
];
