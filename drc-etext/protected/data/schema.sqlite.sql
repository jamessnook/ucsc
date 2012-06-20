-- base app schema
drop table if exists 'tbl_user';
drop table if exists 'tbl_role';
drop table if exists 'tbl_user_role';
drop table if exists 'AuthAssignment';
drop table if exists 'AuthItemChild';
drop table if exists 'AuthItem';
drop table if exists user;
drop table if exists text;
drop table if exists file;
drop table if exists term;
drop table if exists course;
drop table if exists section;
drop table if exists section_text;
drop table if exists text_type;
drop table if exists file_type;
drop table if exists download;
drop table if exists book;
drop table if exists request;
drop table if exists book_request;

-- Auth tables from yii schema
-- modified from yii framework /web/auth
create table 'AuthItem'
(
   "name"                 varchar(64) not null,
   "type"                 integer not null,
   "description"          text,
   "bizrule"              text,
   "data"                 text,
   primary key ("name")
);
-- add in default roles, TYPE_ROLE=2
INSERT INTO AuthItem (name, type) VALUES ('admin', 2);
INSERT INTO AuthItem (name, type) VALUES ('maint', 2);
INSERT INTO AuthItem (name, type) VALUES ('student', 2);
INSERT INTO AuthItem (name, type) VALUES ('guest', 2);

create table 'AuthItemChild'
(
   "parent"               varchar(64) not null,
   "child"                varchar(64) not null,
   primary key ("parent","child"),
   foreign key ("parent") references 'AuthItem' ("name") on delete cascade on update cascade,
   foreign key ("child") references 'AuthItem' ("name") on delete cascade on update cascade
);

create table 'AuthAssignment'
(
   "itemname"             varchar(64) not null,
   "userid"               varchar(64) not null,
   "bizrule"              text,
   "data"                 text,
   primary key ("itemname","userid"),
   foreign key ("itemname") references 'AuthItem' ("name") on delete cascade on update cascade,
   foreign key ("userid") references 'user' ("username") on delete cascade on update cascade
);
-- assign admin role to admin user
INSERT INTO AuthAssignment (itemname, userid) VALUES ('admin', 'admin');

CREATE TABLE user (
    username     VARCHAR(64) NOT NULL PRIMARY KEY,   -- cruzid
    first_name   VARCHAR(64),
    last_name    VARCHAR(64),
    email        VARCHAR(128),
    phone        VARCHAR(32)
);
INSERT INTO user (username) VALUES ('admin');

CREATE TABLE file (
    id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name         VARCHAR(128) NOT NULL, -- name of file
    path         VARCHAR(256) NOT NULL DEFAULT '', -- path for file on server under file root
    caption      VARCHAR(512),  -- optional for display purposes
    parent_id    INTEGER,       -- optional parent object id, ie 'book' if files are chapters
    type_id      INTEGER,       -- file type (reduntant with extension on path?)
    order_num    INTEGER,       -- display or list order if member of a group (chapters in a book)
    post_date    DATE,          -- date uploaded
    poster_id 	 VARCHAR(64),   -- username who uploaded file
    foreign key (poster_id) references user ("username")
);

CREATE TABLE file_type (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name         VARCHAR(32),    -- file extension, 
    caption      VARCHAR(128)    -- optional for display 
);


CREATE TABLE request (  -- AIS feed
    id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    term_id VARCHAR(32) NOT NULL,       -- AIS: STRM
    class_id VARCHAR(32) NOT NULL,      -- AIS: CLASS_NBR
    department VARCHAR(128) NOT NULL,   -- AIS: SUBJECT?, for bookstore class books request
    course VARCHAR(32) NOT NULL,        -- AIS: COURSE_OFFER_NBR?, for bookstore class books request
    section VARCHAR(32) NOT NULL,       -- AIS: CLASS_SECTION?, for bookstore class books request
    instructor_id VARCHAR(32) NOT NULL, -- AIS: INSTRUCTOR_ID
    username     VARCHAR(64),           -- AIS: EMPLID, identifies student
    type_id     INTEGER,                -- AIS: ?, type of file for alternate text, might need translation table
    course_name    VARCHAR(256)  
);

CREATE TABLE book (                 -- books or other items in drc library
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,  -- drc library id
    global_id INTEGER NOT NULL,     -- most often isbn number
    id_type VARCHAR(32) NOT NULL,   -- most often isbn, also issn, aisn, etc
    title VARCHAR(512) NOT NULL, 
    author VARCHAR(128),
    edition VARCHAR(128),
    is_complete BOOLEAN DEFAULT 0,
    is_viewable BOOLEAN DEFAULT 0
);

CREATE TABLE book_request (         -- maps requests to specific books (may not be in drc or book table yet)
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,  -- drc library id
    request_id    INTEGER,          -- identifies request in AIS
    book_id    INTEGER,             -- optional, identifies book in drc library, once book is in library...
    global_id INTEGER,              -- most often isbn number
    id_type VARCHAR(32),            -- most often isbn, also issn, aisn, etc
    notes VARCHAR(1024),
    foreign key (request_id ) references request (id)
);

CREATE TABLE term(                 -- data for terms for display puposes
    id VARCHAR(32) NOT NULL PRIMARY KEY ,       -- AIS: STRM
    name VARCHAR(512) NOT NULL, 
    quarter VARCHAR(128),
    year INTEGER,
    begin_date DATE,
    end_date DATE
);

-- The tables below may or may not be needed depending on requirements

CREATE TABLE accommodation  (      -- AIS feed, may not need
    username     VARCHAR(64),      -- identifies student
    start_date    DATE,            -- start date for accommodation 
    end_date      DATE,            -- end date for accommodation 
    foreign key (username ) references user (username)
);

CREATE TABLE user_format (         -- AIS feed maps users to the file formats they get, may not need
    username      VARCHAR(64),     -- identifies student
    type_id     INTEGER,           -- type of file
    foreign key (username ) references user (username),
    foreign key (type_id ) references file_type (id)
);

-- active terms
-- downloads
-- waitlist



