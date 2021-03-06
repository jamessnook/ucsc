-- drc-etext app schema

-- Auth tables from yii schema
-- modified from yii framework /web/auth
drop table if exists 'AuthItem';
create table authItem
(
   name                 varchar(64) not null,
   type                 integer not null,
   description          text,
   bizrule              text,
   data                 text,
   primary key (name)
);
-- add in default roles, TYPE_ROLE=2
INSERT INTO AuthItem (name, type) VALUES ('admin', 2);
INSERT INTO AuthItem (name, type) VALUES ('maint', 2);
INSERT INTO AuthItem (name, type) VALUES ('student', 2);
INSERT INTO AuthItem (name, type) VALUES ('guest', 2);
INSERT INTO AuthItem (name, type) VALUES ('teacher', 2);

drop table if exists AuthItemChild;
create table authItemChild
(
   parent               varchar(64) not null,
   child                varchar(64) not null,
   primary key (parent, child),
   foreign key (parent) references AuthItem (name) on delete cascade on update cascade,
   foreign key (child) references AuthItem (name) on delete cascade on update cascade
);

drop table if exists authAssignment;
create table authAssignment
(
   itemname             varchar(64) not null,
   userid               varchar(64) not null,
   bizrule              text,
   data                 text,
   primary key (itemname, userid),
   foreign key (itemname) references authItem (name) on delete cascade on update cascade,
   foreign key (userid) references user (username) on delete cascade on update cascade
);
-- assign admin role to admin user
INSERT INTO AuthAssignment (itemname, userid) VALUES ('admin', 'admin');

drop table if exists user;
CREATE TABLE user (    -- AIS feed and creation by admins
    username     VARCHAR(64) NOT NULL PRIMARY KEY,   -- cruzid
    emplId       VARCHAR(64),  -- AIS user id
    first_name   VARCHAR(64),
    last_name    VARCHAR(64),
    email        VARCHAR(128),
    phone        VARCHAR(32)
);
INSERT INTO user (username) VALUES ('admin');

drop table if exists file_type;
CREATE TABLE file_type (    -- AIS feed
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name         VARCHAR(32) NOT NULL,    -- file extension, AIS accomodation Type
    accommodation_type   VARCHAR(16),    -- identifies accommodation type in AIS
    caption      VARCHAR(128)   -- optional for display 
);
-- INSERT INTO file_type (name) VALUES ('docx');
-- INSERT INTO file_type (name) VALUES ('doc');
-- INSERT INTO file_type (name) VALUES ('pdf');
-- INSERT INTO file_type (name) VALUES ('txt');


drop table if exists drc_request;
CREATE TABLE drc_request (  -- AIS feed
    id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,  -- (local, not from AIS)
    term_code INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_number INTEGER,               -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    emplId     VARCHAR(32),             -- AIS: EMPLID, identifies student, 7 digit number not cruzid
    username     VARCHAR(64),           -- AIS: student cruzid needed to match to logged on user
    accommodation_type  VARCHAR(32),    -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.ACCOMMODATION_TYPE, also ACCOMOD.ACCOMODATION_TYPE, six letter code
    effective_date DATE,                -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.EFFDT_FROM)
    created    DATETIME,                -- when imported from AIS
    foreign key (username ) references user (username)
 );

drop table if exists accomodation;
CREATE TABLE accomodation (  -- AIS feed  May not need
    id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,  -- (local, not from AIS)
    emplId     VARCHAR(32),             -- AIS: EMPLID, identifies student, 7 digit number not cruzid
    username     VARCHAR(64),           -- AIS: student cruzid needed to match to logged on user
    accommodation_type  VARCHAR(32),    -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.ACCOMMODATION_TYPE, also ACCOMOD.ACCOMODATION_TYPE, six letter code
    start_date DATE,                    -- AIS
    end_date DATE,                      -- AIS
    created    DATETIME,                -- when imported from AIS
    primary key (emplId, accomodation_type )
);

drop table if exists course;
CREATE TABLE course (  -- AIS feed
    term_code INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_number INTEGER,               -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    section VARCHAR(32),                -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.CLASS_SECTION?, for bookstore class books request
    course_id VARCHAR(32),              -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.CRSE_ID, may not need
    subject VARCHAR(64),                -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.SUBJECT, is this department for bookstore class books request
    description VARCHAR(512),           -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.DESC
    title VARCHAR(128),                 -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.TITLE
    catalog_nbr VARCHAR(64),            -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CATALOG_NBR
    created    DATETIME,                -- when imported or requested (local, not from AIS)
    primary key (term_code, class_number )
 );

drop table if exists courseInstructor;
CREATE TABLE courseInstructor (         -- AIS feed, one to many association possible
    term_code INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_number INTEGER,               -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    emplId     VARCHAR(32),             -- AIS: EMPLID, identifies instructor 7 digit number not cruzid
    primary key (emplId, term_code, class_number )
);

drop table if exists term;
CREATE TABLE term(                 --  AIS feed, data for terms for display puposes
    term_code VARCHAR(32) NOT NULL PRIMARY KEY ,       -- AIS: STRM
    description VARCHAR(512) NOT NULL, 
    start_date DATE,
    end_date DATE
);
-- INSERT INTO term (id, name) VALUES ('2124', 'Summer 2012');
-- INSERT INTO term (id, name) VALUES ('2128', 'Fall 2012');

drop table if exists file;
CREATE TABLE file (
    id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name         VARCHAR(128) NOT NULL, -- name of file
    path         VARCHAR(256) NOT NULL DEFAULT '', -- path for file on server under file root
    caption      VARCHAR(512),  -- optional for display purposes
    parent_id    INTEGER,       -- optional parent object id, ie 'assignment' 
    type_id      INTEGER,       -- file type (redundant with extension on path?)
    order_num    INTEGER,       -- display or list order if member of a group (chapters in a book)
    created      DATETIME,      -- when requested
    modified     DATETIME,      -- date and time of last change
    modified_by   VARCHAR(32),  -- username of user who made last change 
    foreign key (modified_by) references user ("username")
    foreign key (parent_id) references book_request ("id")
    foreign key (type_id) references file_type ("id")
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

drop table if exists assignment;
CREATE TABLE assignment (               -- maps books and files to a course
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,  -- drc library id
    term_code INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_number INTEGER NOT NULL,      -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    book_id     INTEGER,                -- drc library id for book
    created    DATETIME,                -- when requested
    modified    DATETIME,               -- date and time of last change
    modified_by    VARCHAR(32),         -- username of user who made last change 
    notes VARCHAR(1024),
    is_complete BOOLEAN DEFAULT 0,      -- not needed if tracked by type instead
    has_zip_file BOOLEAN DEFAULT 0,
    foreign key (term_code ) references term (term_code),
    foreign key (class_number ) references course (class_number),
    foreign key (modified_by) references user ("username")
);

drop table if exists assignment_type;
CREATE TABLE assignment_type (          -- tracks if assignment complete for this file type
    assignment_id INTEGER,  -- drc library id
    accommodation_type  VARCHAR(32),    -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.ACCOMMODATION_TYPE, also ACCOMOD.ACCOMODATION_TYPE, six letter code
    is_complete BOOLEAN DEFAULT 0,
    foreign key (assignment_id ) references assignment (id),
    foreign key (accommodation_type ) references drc_request (accommodation_type),
    primary key (assignment_id, accommodation_type)
);

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

drop table if exists book_purchase;
CREATE TABLE book_purchase (          -- one to many associates a book with the file and accomodation types it is available in
    book_id     INTEGER NOT NULL,     -- drc library id for book
    username    VARCHAR(64),          -- identifies file or other type
    start_date DATE,
    end_date DATE,
    primary key (book_id, username),
    foreign key (book_id) references book (id),
    foreign key (username) references user (username)
);

drop table if exists instructor_files;
CREATE TABLE instructor_files (              -- identifies files that are uploaded by instructor
    file_id     INTEGER NOT NULL,   -- 
    term_code   INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_number INTEGER,               -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    emplId      VARCHAR(32),             -- AIS: EMPLID, identifies instructor 7 digit number not cruzid
    notes       VARCHAR(512),         -- information about what assignmetn the file is for
    is_syllabus BOOLEAN DEFAULT 0,
    primary key (file_id),
    foreign key (file_id) references file (id),
    foreign key (term_code ) references term (term_code),
    foreign key (class_number ) references course (class_number),
    foreign key (emplId) references user ("emplId")
);




