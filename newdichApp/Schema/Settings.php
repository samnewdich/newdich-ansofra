<?php
namespace NewdichSchema;

class Settings{
    public const ROOT_DIRECTORY = ROOT_DIRECTORY;
    public const APP_VERSION = APP_VERSION;
    public const APP_NAME = APP_NAME;
    public const APP_TITLE = APP_TITLE;
    public const APP_DESCRIPTION = APP_DESCRIPTION;
    public const APP_SMTP = APP_SMTP;
    public const APP_PORT = APP_PORT;
    public const APP_OTP_EMAIL = APP_OTP_EMAIL;
    public const APP_OTP_EMAIL_PASSWORD = APP_OTP_EMAIL_PASSWORD;
    public const APP_SENDING_EMAIL = APP_SENDING_EMAIL;
    public const APP_SENDING_EMAIL_PASSWORD = APP_SENDING_EMAIL_PASSWORD;
    
    //FOR MAILING VIA SENDGRID
    public const SENDGRID_API_KEY = SENDGRID_API_KEY;
    public const SENDGRID_CUSTOMIZED_DOMAIN_EMAIL = SENDGRID_CUSTOMIZED_DOMAIN_EMAIL;
    public const SENDGRID_MAILING_ENDPOINT = SENDGRID_MAILING_ENDPOINT;

    //FOR MAILING VIA MAILGUN
    public const MAILGUN_API_KEY = MAILGUN_API_KEY;
    public const MAILGUN_CUSTOMIZED_DOMAIN_EMAIL = MAILGUN_CUSTOMIZED_DOMAIN_EMAIL;
    public const MAILGUN_VERIFIED_DOMAIN = MAILGUN_VERIFIED_DOMAIN;
    public const MAILGUN_MAILING_ENDPOINT = MAILGUN_MAILING_ENDPOINT;

    //for annotations
    public const APP_ANNOTATION_TITLE = APP_ANNOTATION_TITLE;
    public const SRC_ANNOTATION_TITLE = SRC_ANNOTATION_TITLE;

    //set server configuration
    public const SERVER = SERVER;
    public const SERVER_USER = SERVER_USER;
    public const SERVER_DB = SERVER_DB;
    public const SERVER_PASS = SERVER_PASS;

    //other configuration
    public const DOMAIN_NAME = DOMAIN_NAME;
    public const AUTH_KEY = AUTH_KEY;

    //for redis caching
    public const REDIS_SERVER_IP = REDIS_SERVER_IP;
    public const REDIS_SERVER_PORT = REDIS_SERVER_PORT;
    public const REDIS_AUTH_PASSWORD = REDIS_AUTH_PASSWORD;

    //for file and uploading
    public const UPLOAD_DIRECTIORY = UPLOAD_DIRECTIORY;

    //You can then put your table here
    //Examples
    public const USERS_TABLE ="users";
    public const ADMIN_TABLE ="admins";
}
?>