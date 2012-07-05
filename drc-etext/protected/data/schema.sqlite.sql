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
    type         VARCHAR(32),       -- file type (redundant with extension on path?)
    order_num    INTEGER,       -- display or list order if member of a group (chapters in a book)
    post_date    DATE,          -- date uploaded
    poster_id 	 VARCHAR(64),   -- username who uploaded file
    foreign key (poster_id) references user ("username")
);

drop table if exists file_type;
CREATE TABLE file_type (
    name         VARCHAR(32) NOT NULL,    -- file extension, 
    accom_type   VARCHAR(16),    -- identifies accommodation type in AIS
    caption      VARCHAR(128),    -- optional for display 
    primary key (name)
);
INSERT INTO file_type (name) VALUES ('docx');
INSERT INTO file_type (name) VALUES ('doc');
INSERT INTO file_type (name) VALUES ('pdf');
INSERT INTO file_type (name) VALUES ('txt');


drop table if exists request;
drop table if exists service_request;
CREATE TABLE service_request (  -- AIS feed
    id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,  -- (local, not from AIS)
    term_id INTEGER NOT NULL,       -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_number INTEGER,               -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    class_section VARCHAR(32),          -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.CLASS_SECTION?, for bookstore class books request
    session_code VARCHAR(32),           -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.SESSION_CODE, may not need
    course_offer_number INTEGER,        -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.COURSE_OFFER_NBR?, for bookstore class books request
    course_id VARCHAR(32),              -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.CRSE_ID, may not need
    course_name VARCHAR(64),            -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.DESCR
    subject VARCHAR(64),                -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.SUBJECT, is this department for bookstore class books request
    catalog_nbr VARCHAR(64),            -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CATALOG_NBR
    instructor_id VARCHAR(32),          -- AIS: INSTRUCTOR_ID, optional
    instructor_cruzid VARCHAR(32),      -- AIS: instructor cruzid, used to build e-mail address
    student_id     VARCHAR(64),         -- AIS: EMPLID, identifies student, 7 digit number not cruzid
    username     VARCHAR(64),           -- AIS: student cruzid needed to match to logged on user
    accommodation_type  VARCHAR(32),    -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.ACCOMMODATION_TYPE, also ACCOMOD.ACCOMODATION_TYPE, six letter code
    type_name     VARCHAR(32),          -- AIS: SYSADMIN.PS_SCR_DRC_ACCSETP.DESCR) or , six letter code
    effective_date DATE,                -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.EFFDT_FROM)
    created    DATETIME,                -- when imported or requested (local, not from AIS)
    last_changed    DATETIME,           -- date and time of last change (local, not from AIS)
    last_changed_by    VARCHAR(32),     -- username of user who made last change (local, not from AIS)
    foreign key (username ) references user (username)
);

drop table if exists id_type;
CREATE TABLE id_type (                  -- for drop down list of id types for book ids 
    name     VARCHAR(64) NOT NULL,      -- book id type
    primary key (name)
);
INSERT INTO id_type (name) VALUES ('isbn');
INSERT INTO id_type (name) VALUES ('other');
INSERT INTO id_type (name) VALUES ('unknown');
INSERT INTO id_type (name) VALUES ('none');

drop table if exists book_request;
CREATE TABLE book_request (         -- maps requests to specific books (may not be in drc library and book table yet)
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,  -- drc library id
    request_id    INTEGER,          -- drc-etext id, identifies request that came from AIS
    global_id INTEGER,              -- most often isbn number
    id_type VARCHAR(32),            -- most often isbn, also issn, aisn, etc
    title VARCHAR(512) NOT NULL, 
    author VARCHAR(128),
    edition VARCHAR(128),
    created    DATETIME,            -- when requested
    last_changed    DATETIME,       -- date and time of last change
    last_changed_by    VARCHAR(32), -- username of user who made last change 
    notes VARCHAR(1024),
    is_complete BOOLEAN DEFAULT 0,
    has_zip_file BOOLEAN DEFAULT 0,
    foreign key (request_id ) references service_request (id),
    foreign key (id_type ) references id_type (name)
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
INSERT INTO term (id, name) VALUES ('2124', 'Summer 2012');
INSERT INTO term (id, name) VALUES ('2128', 'Fall 2012');
INSERT INTO term (id, name) VALUES ('2130', 'Winter 2013');
INSERT INTO term (id, name) VALUES ('2132', 'Spring 2013');

-- The tables below may or may not be needed depending on requirements

drop table if exists book;
CREATE TABLE book (                    -- books or other items in drc library
    id         INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,  -- drc library id
    global_id  INTEGER NOT NULL,       -- most often isbn number
    id_type    VARCHAR(32) NOT NULL,   -- most often isbn, also issn, aisn, etc
    title      VARCHAR(512) NOT NULL, 
    author     VARCHAR(128),
    edition    VARCHAR(128),
    foreign key (id_type ) references id_type (name)
);

drop table if exists book_type;
CREATE TABLE book_type (            -- one to many associates a book with the file and accomodation types it is available in
    book_id     INTEGER NOT NULL,   -- drc library id for book
    type        VARCHAR(32),         -- identifies file or other type
    is_complete BOOLEAN DEFAULT 0,
    is_viewable BOOLEAN DEFAULT 0,
    primary key (type, book_id),
    foreign key (book_id) references book (id),
    foreign key (type) references file_type (name)
);


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



