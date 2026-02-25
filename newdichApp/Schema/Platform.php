<?php
namespace NewdichSchema;

class Platform{
    public const USERS ="users";
    public const USERS_COLUMNS =[
        "users_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "email VARCHAR(255) NOT NULL",
        "fullname VARCHAR(255)",
        "password VARCHAR(255) NOT NULL",
        "country VARCHAR(255)",
        "region VARCHAR(255)",
        "city VARCHAR(255)",
        "address VARCHAR(255)",
        "zip_code VARCHAR(255)",
        "phone VARCHAR(255)",
        "date_created VARCHAR(255)", 
        "last_seen VARCHAR(255)",
        "picture TEXT",
        "username VARCHAR(255)",
        "account_type VARCHAR(255)",
        "nin VARCHAR(255)",
        "bvn VARCHAR(255)",
        "tax_id VARCHAR(255)"
    ];

    public const ADMINS ="admins";
    public const ADMINS_COLUMNS =[
        "admins_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "email VARCHAR(255) NOT NULL",
        "fullname VARCHAR(255) NOT NULL",
        "password VARCHAR(255) NOT NULL",
        "country VARCHAR(255) NOT NULL",
        "region VARCHAR(255)",
        "city VARCHAR(255)",
        "address VARCHAR(255)",
        "zip_code VARCHAR(255)",
        "phone VARCHAR(255)",
        "date_created VARCHAR(255)", 
        "last_seen VARCHAR(255)",
        "picture TEXT",
        "username VARCHAR(255)",
        "role VARCHAR(255) NOT NULL"
    ];

    //you can have as many tables as you want
}
?>