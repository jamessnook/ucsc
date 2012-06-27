-- drc-etext app schema

-- Auth tables from yii schema
-- modified from yii framework /web/auth
drop table if exists 'AuthItemChild';
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

drop table if exists 'AuthItemChild';
create table 'AuthItemChild'
(
   "parent"               varchar(64) not null,
   "child"                varchar(64) not null,
   primary key ("parent","child"),
   foreign key ("parent") references 'AuthItem' ("name") on delete cascade on update cascade,
   foreign key ("child") references 'AuthItem' ("name") on delete cascade on update cascade
);

drop table if exists 'AuthAssignment';
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

drop table if exists user;
CREATE TABLE user (
    username     VARCHAR(64) NOT NULL PRIMARY KEY,   -- cruzid
    first_name   VARCHAR(64),
    last_name    VARCHAR(64),
    email        VARCHAR(128),
    phone        VARCHAR(32)
);
INSERT INTO user (username) VALUES ('admin');

drop table if exists file;
CREATE TABLE file (
    id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name         VARCHAR(128) NOT NULL, -- name of file
    path         VARCHAR(256) NOT NULL DEFAULT '', -- path for file on server under file root
    caption      VARCHAR(512),  -- optional for display purposes
    parent_id    INTEGER,       -- optional parent object id, ie 'book' if files are chapters
    type_id      INTEGER,       -- file type (redundant with extension on path?)
    order_num    INTEGER,       -- display or list order if member of a group (chapters in a book)
    post_date    DATE,          -- date uploaded
    poster_id 	 VARCHAR(64),   -- username who uploaded file
    foreign key (poster_id) references user ("username")
);

drop table if exists file_type;
CREATE TABLE file_type (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name         VARCHAR(32),    -- file extension, 
    accom_type   VARCHAR(16),    -- identifies accommodation type in AIS
    caption      VARCHAR(128)    -- optional for display 
);


drop table if exists request;
drop table if exists service_request;
CREATE TABLE service_request (  -- AIS feed
    id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    term_id VARCHAR(32) NOT NULL,       -- AIS: STRM
    class_id VARCHAR(32) NOT NULL,      -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    course VARCHAR(32) NOT NULL,        -- AIS: COURSE_OFFER_NBR?, for bookstore class books request
    section VARCHAR(32) NOT NULL,       -- AIS: CLASS_SECTION?, for bookstore class books request
    course_id INTEGER,        			-- AIS: CRSE_ID, may not need
    session_code INTEGER,               -- AIS: SESSION_CODE, may not need
    course_name VARCHAR(64),            -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.DESCR
    subject VARCHAR(64),                -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.SUBJECT, is this department for bookstore class books request
    catalog_nbr VARCHAR(64),            -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CATALOG_NBR
    instructor_id VARCHAR(32) NOT NULL, -- AIS: INSTRUCTOR_ID
    student_id     VARCHAR(64),         -- AIS: EMPLID, identifies student, 7 digit number not cruzid
    username     VARCHAR(64),           -- cruzid needed to match to logged on user
    type      VARCHAR(32),              -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.ACCOMODATION_TYPE, also ACCOMOD.ACCOMODATION_TYPE, six letter code
    type_name     VARCHAR(32),          -- AIS: SYSADMIN.PS_SCR_DRC_ACCSETP.DESCR^) or , six letter code
    foreign key (username ) references user (username)
);

drop table if exists book;
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

drop table if exists book_accom_type;
CREATE TABLE book_accom_type (      -- one to many associates a book with the accomodation types it is available in or other items in drc library
    book_id INTEGER NOT NULL,  	    -- drc library id for book
    accom_type VARCHAR(16) NOT NULL,     -- AIS accommodation type
    is_complete BOOLEAN DEFAULT 0,
    is_viewable BOOLEAN DEFAULT 0
    primary key (accom_type, book_id),
    foreign key (book_id ) references book (id),
    foreign key (accom_type ) references file_type (accom_type)
);

drop table if exists book_request;
CREATE TABLE book_request (         -- maps requests to specific books (may not be in drc library and book table yet)
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,  -- drc library id
    request_id    INTEGER,          -- drc-etext id, identifies request that came from AIS
    username     VARCHAR(64),       -- cruz id identifies user, also in request but this book request could exist first...
    book_id    INTEGER,             -- optional, identifies book in drc library, once book is in library...
    global_id INTEGER,              -- most often isbn number
    id_type VARCHAR(32),            -- most often isbn, also issn, aisn, etc
    title VARCHAR(512) NOT NULL, 
    author VARCHAR(128),
    edition VARCHAR(128),
    notes VARCHAR(1024),
    foreign key (request_id ) references request (id),
    foreign key (book_id ) references book (id)
    foreign key (global_id ) references book (global_id)
    foreign key (id_type ) references book (id_type)
);

drop table if exists term;
CREATE TABLE term(                 -- data for terms for display puposes
    id VARCHAR(32) NOT NULL PRIMARY KEY ,       -- AIS: STRM
    name VARCHAR(512) NOT NULL, 
    quarter VARCHAR(128),
    year INTEGER,
    begin_date DATE,
    end_date DATE
);

-- The tables below may or may not be needed depending on requirements


drop table if exists accommodation;
CREATE TABLE accommodation  (      -- AIS feed, may not need
    username     VARCHAR(64),      -- identifies student
    start_date    DATE,            -- AIS: SYSADMIN.PS_SCR_DRC_ACCOMOD.START_DATE,
    end_date      DATE,            -- AIS: SYSADMIN.PS_SCR_DRC_ACCOMOD.END_DATE, end date for accommodation 
    type      VARCHAR(32),         -- AIS: SYSADMIN.PS_SCR_DRC_ACCOMOD.ACCOMODATION_TYPE, six letter code
    foreign key (username ) references user (username)
);

drop table if exists accom_file_type;
CREATE TABLE accom_file_type  (      -- mapping accompdation type to file  type since not always a one to one
    accommodation_type     VARCHAR(16),      -- identifies accommodation type in AIS
    file_type     VARCHAR(16),     -- identifies file_type
    primary key (accommodation_type,file_type),
    foreign key (file_type ) references file_type (id)
);

drop table if exists user_format;
CREATE TABLE user_format (         -- AIS feed maps users to the file formats they get, may not need
    username      VARCHAR(64),     -- identifies student
    type_id     INTEGER,           -- type of file
    foreign key (username ) references user (username),
    foreign key (type_id ) references file_type (id)
);

-- active terms
-- downloads
-- waitlist



