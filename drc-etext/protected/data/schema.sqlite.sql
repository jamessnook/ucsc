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
INSERT INTO AuthItem (name, type) VALUES ('god', 2);
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
   foreign key ("userid") references 'tbl_user' ("username") on delete cascade on update cascade
);
-- assign admin role to admin user
INSERT INTO AuthAssignment (itemname, userid) VALUES ('admin', 'admin');

CREATE TABLE user (
    username VARCHAR(64) NOT NULL PRIMARY KEY, --cruzid
    first_name VARCHAR(64),
    last_name VARCHAR(64),
    email VARCHAR(128),
    phone VARCHAR(32)
);
INSERT INTO user (username) VALUES ('admin');

CREATE TABLE file (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(128) NOT NULL, 
    path VARCHAR(256),
    caption VARCHAR(512),
    text_id INTEGER,
    format_id INTEGER,
    type_id INTEGER,
    order_num INTEGER,
    pages INTEGER,
    post_date DATE,
    voice VARCHAR(128),
    speed VARCHAR(128),
    source VARCHAR(128),
    notes VARCHAR(1000),
    foreign key (text_id) references text (id) on delete cascade on update cascade
);

CREATE TABLE text (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(512) NOT NULL, 
    author VARCHAR(128),
    edition VARCHAR(128),
    year_published INTEGER,
    poster_id INTEGER,
    post_date DATE,
    type_id INTEGER,
    is_complete BOOLEAN DEFAULT 0,
    is_viewable BOOLEAN DEFAULT 0,
    description VARCHAR(512),
    foreign key (poster_id ) references user (username) on delete cascade on update cascade,
    foreign key (type_id) references file_type (id) on delete cascade on update cascade
);

CREATE TABLE term(
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(512) NOT NULL, 
    quarter VARCHAR(128),
    year INTEGER,
    begin_date DATE,
    end_date DATE
);

CREATE TABLE course (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(512) NOT NULL, 
    major_code VARCHAR(32),
    class_id VARCHAR(32),
    course_number VARCHAR(32)
);
CREATE TABLE section (
    id VARCHAR(32) NOT NULL PRIMARY KEY,  -- from AIS?
    course_id INTEGER NOT NULL,
    term_id INTEGER NOT NULL,
    instructor_id VARCHAR(64),
    name VARCHAR(512) NOT NULL,
    foreign key (course_id) references course (id) on delete cascade on update cascade,
    foreign key (term_id) references term (id) on delete cascade on update cascade
);
CREATE TABLE section_text (
    section_id INTEGER,
    text_id INTEGER,
    primary key (section_id, text_id),
    foreign key (section_id) references section (id) on delete cascade on update cascade,
    foreign key (text_id) references text (id) on delete cascade on update cascade
);
CREATE TABLE format (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(512) NOT NULL, 
    shortName VARCHAR(128)
);
CREATE TABLE format_text (
    format_id INTEGER,
    text_id INTEGER,
    primary key (format_id, text_id),
    foreign key (format_id) references format (id) on delete cascade on update cascade,
    foreign key (text_id) references text (id) on delete cascade on update cascade
);
CREATE TABLE file_type (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(512) NOT NULL, 
    shortName VARCHAR(128)
);
CREATE TABLE download (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    file_id INTEGER,
    username VARCHAR(64), --cruzid
    date_time DATETIME
);

-- waitlist?


