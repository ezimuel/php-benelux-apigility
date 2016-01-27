SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS oauth_clients;
CREATE TABLE oauth_clients (
    client_id VARCHAR(80) NOT NULL,
    client_secret VARCHAR(80) NOT NULL,
    redirect_uri VARCHAR(2000) NOT NULL,
    grant_types VARCHAR(80),
    scope VARCHAR(2000),
    user_id VARCHAR(255),
    CONSTRAINT clients_client_id_pk PRIMARY KEY (client_id)
);
DROP TABLE IF EXISTS oauth_access_tokens;
CREATE TABLE oauth_access_tokens (
    access_token VARCHAR(40) NOT NULL,
    client_id VARCHAR(80) NOT NULL,
    user_id VARCHAR(255),
    expires TIMESTAMP NOT NULL,
    scope VARCHAR(2000),
    CONSTRAINT access_token_pk PRIMARY KEY (access_token)
);
DROP TABLE IF EXISTS oauth_authorization_codes;
CREATE TABLE oauth_authorization_codes (
    authorization_code VARCHAR(40) NOT NULL,
    client_id VARCHAR(80) NOT NULL,
    user_id VARCHAR(255),
    redirect_uri VARCHAR(2000),
    expires TIMESTAMP NOT NULL,
    scope VARCHAR(2000),
    id_token VARCHAR(2000),
    CONSTRAINT auth_code_pk PRIMARY KEY (authorization_code)
);
DROP TABLE IF EXISTS oauth_refresh_tokens;
CREATE TABLE oauth_refresh_tokens (
    refresh_token VARCHAR(40) NOT NULL,
    client_id VARCHAR(80) NOT NULL,
    user_id VARCHAR(255),
    expires TIMESTAMP NOT NULL,
    scope VARCHAR(2000),
    CONSTRAINT refresh_token_pk PRIMARY KEY (refresh_token)
);
DROP TABLE IF EXISTS oauth_users;
CREATE TABLE oauth_users (
    username VARCHAR(255) NOT NULL,
    password VARCHAR(2000),
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    CONSTRAINT username_pk PRIMARY KEY (username)
);
DROP TABLE IF EXISTS oauth_scopes;
CREATE TABLE oauth_scopes (
    type VARCHAR(255) NOT NULL DEFAULT "supported",
    scope VARCHAR(2000),
    client_id VARCHAR (80),
    is_default SMALLINT DEFAULT NULL
);
DROP TABLE IF EXISTS oauth_jwt;
CREATE TABLE oauth_jwt (
    client_id VARCHAR(80) NOT NULL,
    subject VARCHAR(80),
    public_key VARCHAR(2000),
    CONSTRAINT jwt_client_id_pk PRIMARY KEY (client_id)
);

# Add a test user (testuser/testpass)
INSERT INTO oauth_users
  (username, password)
VALUES
  ('testuser', '$2y$10$0PLA0gpbGw5PTnll/UVr4.QqYFJ6rfoDak4XkJDWhOuQlR1QB4pDe');

# Add a test client (testclient/testpass)
INSERT INTO oauth_clients
  (client_id, client_secret, redirect_uri)
VALUES
  ('testclient', '$2y$10$cwjpmicvjN3Lph8DIiQnWesRTg261lFBM3sThxl9UDqlvSjG2Ii46', '/oauth/receivecode'),
  ('testpublic', NULL, '/oauth/receivecode');


SET FOREIGN_KEY_CHECKS=1;
