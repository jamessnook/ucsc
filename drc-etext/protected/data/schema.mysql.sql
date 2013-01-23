-- drc-etext app schema

-- Auth tables from yii schema
-- modified from yii framework /web/auth
drop table if exists AuthItem;
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
INSERT INTO AuthItem (name, type) VALUES ('staff', 2);
INSERT INTO AuthItem (name, type) VALUES ('faculty', 2);

drop table if exists AuthItemChild;
create table authItemChild
(
   parent               varchar(64) not null,
   child                varchar(64) not null,
   primary key (parent, child)
   -- foreign key (parent) references AuthItem (name) on delete cascade on update cascade,
   -- foreign key (child) references AuthItem (name) on delete cascade on update cascade
);

drop table if exists authAssignment;
create table authAssignment
(
   itemname             varchar(64) not null,
   userid               varchar(64) not null,
   bizrule              text,
   data                 text,
   primary key (itemname, userid)
   -- foreign key (itemname) references authItem (name) on delete cascade on update cascade,
   -- foreign key (userid) references user (username) on delete cascade on update cascade
);
-- assign admin role to admin user
INSERT INTO AuthAssignment (itemname, userid) VALUES ('admin', 'admin');
-- drc-etext app schema

drop table if exists user;
CREATE TABLE user (    -- AIS feed and creation by admins
    count INTEGER,  -- drc library id
    username     VARCHAR(64) PRIMARY KEY NOT NULL,   --  cruzid if available
    emplid       VARCHAR(64),     -- AIS user id
    first_name   VARCHAR(64),
    middle_name   VARCHAR(64),
    last_name    VARCHAR(64),
    email        VARCHAR(128),
    phone        VARCHAR(32),
    created      DATETIME,                -- when imported from AIS
    modified     DATETIME,                -- when updated from AIS
    password     VARCHAR(128),            -- optional for local login
    salt         VARCHAR(128),            -- optional for local login
    modified_by  VARCHAR(64)              -- when updated from AIS
);
Alter table user add index (emplid);

-- INSERT INTO user (username) VALUES ('admin');

-- Update user set first_name = (Select first_name from user t1 where user.username != t1.username order by RANDOM() limit 1);
-- Update user set middle_name = (Select middle_name from user t1 where user.username != t1.username order by RANDOM() limit 1);
-- Update user set last_name = (Select first_name from user t1 where user.username != t1.username order by RANDOM() limit 1);
-- Update user set username = (Select username from user t1 where user.emplid != t1.emplid order by RANDOM() limit 1);
-- Update user set username = hex(randomblob(8));
-- Update user set email = 'test@ucsc.edu';
-- Update user set phone = '555-123-4567';

drop table if exists file_type;
CREATE TABLE file_type (    -- AIS feed
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name         VARCHAR(32) NOT NULL,    -- file extension, AIS accomodation Type
    description      VARCHAR(128)   -- optional for display 
);
Alter table file_type add index (name);

INSERT INTO file_type (name) VALUES ('docx');
INSERT INTO file_type (name) VALUES ('doc');
INSERT INTO file_type (name) VALUES ('pdf');
INSERT INTO file_type (name) VALUES ('txt');
INSERT INTO file_type (name) VALUES ('gif');

drop table if exists term;
CREATE TABLE term(                 --  AIS feed, data for terms for display puposes
    term_code INTEGER NOT NULL PRIMARY KEY ,       -- AIS: STRM
    description VARCHAR(512) NOT NULL, 
    start_date DATE,
    end_date DATE
);
-- INSERT INTO term (term_code, description) VALUES ('2124', 'Summer 2012');
-- INSERT INTO term (term_code, description) VALUES ('2128', 'Fall 2012');

drop table if exists course;
CREATE TABLE course (  -- AIS feed
    term_code INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_num INTEGER,                  -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    section VARCHAR(32),                -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.CLASS_SECTION?, for bookstore class books request
    course_id VARCHAR(32),              -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.CRSE_ID, may not need
    subject VARCHAR(64),                -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.SUBJECT, is this department for bookstore class books request
    description VARCHAR(512),           -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.DESC
    title VARCHAR(128),                 -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.TITLE
    catalog_num VARCHAR(64),            -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CATALOG_NBR
    schedule VARCHAR(128),              -- AIS: ?
    room VARCHAR(128),                  -- AIS: ?
    dates VARCHAR(128),                 -- AIS: ?
    created    DATETIME,                -- when imported or requested (local, not from AIS)
    modified    DATETIME,               -- when updated from AIS
    primary key (term_code, class_num )
	-- foreign key (term_code) references term (term_code)
 );
 
drop table if exists id_type;
CREATE TABLE id_type (                  -- for drop down list of id types for book ids 
    name     VARCHAR(64) NOT NULL,      -- book id type
    primary key (name)
);
INSERT INTO id_type (name) VALUES ('ISBN');
INSERT INTO id_type (name) VALUES ('SBN');
INSERT INTO id_type (name) VALUES ('pISSN');
INSERT INTO id_type (name) VALUES ('e-ISSN');
INSERT INTO id_type (name) VALUES ('other');
INSERT INTO id_type (name) VALUES ('unknown');
INSERT INTO id_type (name) VALUES ('none');

drop table if exists drc_request;
CREATE TABLE drc_request (  -- AIS feed associates student and course approved for services
    term_code INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_num INTEGER,                  -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    course_id VARCHAR(32),              -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.CRSE_ID, may not need
    emplid     VARCHAR(32),             -- AIS: EMPLID, identifies student, 7 digit number not cruzid
    type  VARCHAR(32),                  -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.ACCOMMODATION_TYPE, also ACCOMOD.ACCOMODATION_TYPE, six letter code
    created    DATETIME,                -- when imported from AIS
    modified    DATETIME,               -- when updated from AIS
    primary key (emplid, term_code, class_num ),
    foreign key (type) references file_type (name),
    foreign key (emplid) references user (emplid),
    foreign key (term_code, class_num) references course (term_code, class_num),
    foreign key (term_code) references term (term_code)
 );

drop table if exists drc_accommodation;
CREATE TABLE drc_accommodation (  -- AIS feed  May not need
    emplid     VARCHAR(32),             -- AIS: EMPLID, identifies student, 7 digit number not cruzid
    type  VARCHAR(32),                  -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.ACCOMMODATION_TYPE, also ACCOMOD.ACCOMODATION_TYPE, six letter code
    start_date DATE,                    -- AIS
    end_date DATE,                      -- AIS
    created    DATETIME,                -- when imported from AIS
    modified    DATETIME,               -- when updated from AIS
    primary key (emplId, type ),
    foreign key (emplid) references user (emplid)
);

 
-- INSERT INTO course SELECT term_code, class_num, section, course_id, subject, description, title, catalog_num, schedule, room, dates, created, modified FROM ctemp;
 
-- ALTER TABLE course ADD COLUMN room VARCHAR(128);

-- ALTER TABLE course_instructor RENAME TO temp;

drop table if exists course_instructor;
CREATE TABLE course_instructor (         -- AIS feed, one to many association possible
    term_code INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_num INTEGER,               -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    emplid     VARCHAR(32),             -- AIS: EMPLID, identifies instructor 7 digit number not cruzid
    primary key (emplid, term_code, class_num )
    -- foreign key (emplid) references user (emplid),
    -- foreign key (term_code, class_num) references course (term_code, class_num)
);

-- INSERT INTO course_instructor SELECT * FROM temp;

-- INSERT OR IGNORE INTO user (username, emplid, first_name, last_name) 
--   SELECT 'em'||emplid, emplid, 'FN'||emplid, 'LN'||emplid
--   FROM course_instructor;

drop table if exists file;
CREATE TABLE file (
    id           INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name         VARCHAR(128) NOT NULL, -- name of file
    path         VARCHAR(256) NOT NULL DEFAULT '', -- path for file on server under file root
    description  VARCHAR(512),  -- optional for display purposes
    parent_id    INTEGER,       -- optional parent object id, ie 'assignment' 
    type_id      INTEGER,       -- file type (redundant with extension on path?) not needed, use type
    order_num    INTEGER,       -- display or list order if member of a group (chapters in a book)
    created      DATETIME,      -- when requested
    modified     DATETIME,      -- date and time of last change
    modified_by   VARCHAR(64)   -- username of user who made last change 
    -- foreign key (modified_by) references user (username),
    -- foreign key (type_id) references file_type (id)
);

-- ALTER TABLE file ADD COLUMN type VARCHAR(32);

drop table if exists book;
CREATE TABLE book (                    -- books or other items in drc library
    id         INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,  -- drc library id
    global_id  VARCHAR(64) NOT NULL,       -- most often isbn number
    id_type    VARCHAR(32) NOT NULL,   -- most often isbn, also issn, aisn, etc
    title      VARCHAR(512) NOT NULL, 
    author     VARCHAR(128),
    publisher  VARCHAR(128),
    edition    VARCHAR(128),
    year       INTEGER,
    created      DATETIME,      -- when requested
    modified     DATETIME,      -- date and time of last change
    modified_by   VARCHAR(64)   -- username of user who made last change 
    -- foreign key (modified_by) references user (username),
    -- foreign key (id_type ) references id_type (name)
);


drop table if exists assignment;
CREATE TABLE assignment (               -- maps books and files to a course
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,  -- drc library id
    term_code INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_num INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    book_id     INTEGER,                -- drc library id for book
    description VARCHAR(512),           -- 
    title VARCHAR(128),                 -- 
    due_date DATE,                      -- 
    created    DATETIME,                -- when requested
    modified    DATETIME,               -- date and time of last change
    modified_by    VARCHAR(64),         -- username of user who made last change 
    notes VARCHAR(1024),
    is_complete BOOLEAN DEFAULT 0,      -- not needed if tracked by type instead
    has_zip_file BOOLEAN DEFAULT 0
    -- foreign key (modified_by) references user (username),
    -- foreign key (term_code ) references term (term_code),
    -- foreign key (book_id ) references book (id),
    -- foreign key (term_code, class_num) references course (term_code, class_num)
);

drop table if exists assignment_type;
CREATE TABLE assignment_type (          -- tracks if assignment complete for this file type, not currently used
    assignment_id INTEGER,  -- drc library id
    type  VARCHAR(32),    -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.ACCOMMODATION_TYPE, also ACCOMOD.ACCOMODATION_TYPE, six letter code
    is_complete BOOLEAN DEFAULT 0,
    -- foreign key (assignment_id ) references assignment (id),
    -- foreign key (type ) references drc_request (type),
    primary key (assignment_id, type)
);

drop table if exists assignment_file;
drop table if exists file_association;
CREATE TABLE file_association (         -- maps other models to files
    file_id INTEGER NOT NULL,           --  
    model_id INTEGER NOT NULL,         -- 
    model_name VARCHAR(63) NOT NULL,         -- 
    primary key (file_id, model_id, model_name)
    -- foreign key (file_id) references file (id)
);

drop table if exists book_purchase;
drop table if exists book_user;
CREATE TABLE book_user (          -- one to many associates a book with the file and accomodation types it is available in
    book_id     INTEGER NOT NULL,     -- drc library id for book
    username    VARCHAR(64),          -- identifies user
    purchased   BOOLEAN DEFAULT 0,
    start_date  DATE,
    end_date    DATE,
    created      DATETIME,      -- when requested
    modified     DATETIME,      -- date and time of last change
    modified_by   VARCHAR(64),  -- username of user who made last change 
    primary key (book_id, username)
    -- foreign key (book_id) references book (id),
    -- foreign key (username) references user (username),
    -- foreign key (modified_by) references user (username)
);

drop table if exists instructor_files;
CREATE TABLE instructor_files (              -- identifies files that are uploaded by instructor
    file_id     INTEGER NOT NULL,   -- 
    term_code   INTEGER NOT NULL,         -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_num   INTEGER,               -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    emplId      VARCHAR(32),             -- AIS: EMPLID, identifies instructor 7 digit number not cruzid
    notes       VARCHAR(512),         -- information about what assignmetn the file is for
    is_syllabus BOOLEAN DEFAULT 0,
    created    DATETIME,                -- when requested
    primary key (file_id)
    -- foreign key (file_id) references file (id),
    -- foreign key (term_code ) references term (term_code),
    -- foreign key (term_code, class_num) references course (term_code, class_num),
    -- foreign key (emplId) references user (emplId)
);

drop table if exists email_type;
CREATE TABLE email_type (                  -- for drop down list of email types for email messages 
    name     VARCHAR(63) NOT NULL,      -- email id type
    sequence   INTEGER,               -- 
    tone     VARCHAR(64),           -- 
    primary key (name)
);
INSERT INTO email_type (name, sequence, tone) VALUES ('First', 1, 'Nice');
INSERT INTO email_type (name, sequence, tone) VALUES ('Second', 2, 'Firm');
INSERT INTO email_type (name, sequence, tone) VALUES ('Third', 3, 'Pleading');
INSERT INTO email_type (name, sequence, tone) VALUES ('Fourth', 4, 'Desperate');
INSERT INTO email_type (name, sequence, tone) VALUES ('Other', 9, 'Other');

drop table if exists email;
CREATE TABLE email (               -- maps books and files to a course
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,  -- drc library id
    message VARCHAR(1000),           -- 
    subject VARCHAR(250),           -- 
    type VARCHAR(63),           -- 
    enabled BOOLEAN DEFAULT 1,
    created    DATETIME,                -- when requested
    modified    DATETIME,               -- date and time of last change
    modified_by    VARCHAR(64)          -- username of user who made last change 
    -- foreign key (modified_by) references user (username),
    -- foreign key (type) references email_type (name)
);

drop table if exists email_sent;
CREATE TABLE email_sent (               -- maps books and files to a course
    email_id     INTEGER NOT NULL,     -- drc library id for book
    username    VARCHAR(64),          -- identifies who sent to
    term_code   INTEGER NOT NULL,       -- AIS: SYSADMIN.PS_SCR_DRC_CLCLSV.STRM
    class_num   INTEGER,               -- AIS: SYSADMIN.PS_SCR_DRC_CNTCLS.CLASS_NBR, 
    created    DATETIME,                -- when sent
    modified    DATETIME,               -- date and time of last change
    modified_by    VARCHAR(64)         -- username of user who sent it
    -- foreign key (username) references user (username),
    -- foreign key (email_id) references email (id),
    -- foreign key (term_code ) references term (term_code),
    -- foreign key (term_code, class_num) references course (term_code, class_num),
    -- foreign key (modified_by) references user (username)
);


LOAD DATA INFILE 'c:/users/jim/documents/vase/wordBank/mathWords.txt' INTO TABLE inputWords
LINES TERMINATED BY '\r\n' (word, isPubWord, pos, definition, defSource, senseNum, senseText, notes)
SET subjectId=1;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/user.txt' 
  INTO TABLE user LINES TERMINATED BY '\n' ;
  
LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/term.txt' 
  INTO TABLE term LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/file_type.txt' 
  INTO TABLE file_type LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/id_type.txt' 
  INTO TABLE id_type LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/authitem.txt' 
  INTO TABLE authitem LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/authassignment.txt' 
  INTO TABLE authassignment LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/authitemchild.txt' 
  INTO TABLE authitemchild LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/book.txt' 
  INTO TABLE book LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/book_user.txt' 
  INTO TABLE book_user LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/course.txt' 
  INTO TABLE course LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/assignment.txt' 
  INTO TABLE assignment LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/assignment_type.txt' 
  INTO TABLE assignment_type LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/drc_accommodation.txt' 
  INTO TABLE drc_accommodation LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/drc_request.txt' 
  INTO TABLE drc_request LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/email.txt' 
  INTO TABLE email LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/email_sent.txt' 
  INTO TABLE email_sent LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/email_type.txt' 
  INTO TABLE email_type LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/file.txt' 
  INTO TABLE file LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/file_association.txt' 
  INTO TABLE file_association LINES TERMINATED BY '\n' ;

LOAD DATA INFILE 'c:/users/jim/phpFog/ucsc/drc-etext/protected/data/instructor_files.txt' 
  INTO TABLE instructor_files LINES TERMINATED BY '\n' ;

ALTER TABLE drc_request ADD CONSTRAINT

ALTER TABLE drc_request ADD CONSTRAINT drt foreign key (type) references file_type (name);
ALTER TABLE drc_request ADD CONSTRAINT dreu foreign key (emplid) references user (emplid);
ALTER TABLE drc_request ADD CONSTRAINT drctccn foreign key (term_code, class_num) references course (term_code, class_num);
ALTER TABLE drc_request ADD CONSTRAINT drttc foreign key (term_code) references term (term_code);


