create database `{{db_name}}`;

use {{db_name}};

CREATE TABLE {{db_name}}.guestbook
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    time varchar(255) NOT NULL,
    message text NOT NULL
);

CREATE TABLE {{db_name}}.rsvp_confirmed
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    guest tinyint(4) DEFAULT '0' NOT NULL,
    attending varchar(3) DEFAULT 'no' NOT NULL,
    food_allergies text,
    comment text,
    timestamp varchar(255) NOT NULL
);

CREATE TABLE {{db_name}}.rsvp_guests
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    rsvp_id int(11) NOT NULL,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL
);

CREATE TABLE {{db_name}}.rsvp_validate
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    guest tinyint(4) DEFAULT '0' NOT NULL,
    address1 varchar(255),
    address2 varchar(255),
    city varchar(255),
    state varchar(255),
    zip varchar(255),
    phone varchar(255),
    email varchar(255)
);

CREATE TABLE {{db_name}}.song_request
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    rsvp_id int(11) NOT NULL,
    song_title varchar(255) NOT NULL,
    song_artist varchar(255) NOT NULL
);