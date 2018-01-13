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
    timestamp varchar(255) NOT NULL,
    validate_id int(11)
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
    title varchar(255),
    firstname varchar(255),
    middlename varchar(255),
    lastname varchar(255),
    partnertitle varchar(255),
    partnerfirstname varchar(255),
    partnerlastname varchar(255),
    partnermiddlename varchar(255),
    namestogether varchar(255),
    namesformal varchar(255),
    `namessuper-formal` varchar(255),
    namesfamily varchar(255),
    company varchar(255),
    address1 varchar(255),
    address2 varchar(255),
    city varchar(255),
    state varchar(255),
    postalcode varchar(255),
    country varchar(255),
    mainphone varchar(255),
    cellphone varchar(255),
    homephone varchar(255),
    email varchar(255),
    birthday varchar(255),
    partnerbirthday varchar(255),
    anniversary varchar(255),
    notes text,
    groups text,
    guest int(11),
    lastupdated varchar(255)
);

CREATE TABLE {{db_name}}.song_request
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    rsvp_id int(11) NOT NULL,
    song_title varchar(255) NOT NULL,
    song_artist varchar(255) NOT NULL
);

CREATE TABLE {{db_name}}.details_page_info
(
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  wedding_location_name varchar(255),
  wedding_town varchar(255),
  wedding_date varchar(255),
  wedding_time varchar(255),
  wedding_gmaps_link text,
  wedding_reception_same_location tinyint(1) DEFAULT '0',
  hotel_name varchar(255),
  hotel_location varchar(255),
  hotel_gmaps_link text,
  reception_name varchar(255),
  reception_town varchar(255),
  reception_date varchar(255),
  reception_time varchar(255),
  reception_gmaps_link text,
  wedding_attire varchar(255),
  reception_attire varchar(255),
  hotel_room_link text
);

CREATE TABLE {{db_name}}.wedding_story
(
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  story text
);

CREATE TABLE {{db_name}}.registry_links
(
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name varchar(255),
  url text,
  img_url text
);