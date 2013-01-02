-- base app schema
drop table if exists 'tbl_user';
drop table if exists 'tbl_role';
drop table if exists 'tbl_user_role';
drop table if exists 'AuthAssignment';
drop table if exists 'AuthItemChild';
drop table if exists 'AuthItem';

<<<<<<< HEAD
CREATE TABLE tbl_user (
    username VARCHAR(128) NOT NULL PRIMARY KEY, --cruzid
    email VARCHAR(128)
=======
CREATE TABLE 'AuthAssignment'
(
   "itemname"             varchar(64) not null,
   "userid"               varchar(64) not null,
   "bizrule"              text,
   "data"                 text,
   primary key ("itemname","userid"),
   foreign key ("itemname") references 'AuthItem' ("name") on delete cascade on update cascade
   foreign key ("userid") references 'tbl_user' ("name") on delete cascade on update cascade
);
CREATE TABLE 'AuthItem'
(
   "name"                 varchar(64) not null,
   "type"                 integer not null,
   "description"          text,
   "bizrule"              text,
   "data"                 text,
   primary key ("name")
);
CREATE TABLE 'AuthItemChild'
(
   "parent"               varchar(64) not null,
   "child"                varchar(64) not null,
   primary key ("parent","child"),
   foreign key ("parent") references 'AuthItem' ("name") on delete cascade on update cascade,
   foreign key ("child") references 'AuthItem' ("name") on delete cascade on update cascade
);
CREATE TABLE user (
    username VARCHAR(128) NOT NULL PRIMARY KEY, --cruzid
    email VARCHAR(128),
    phone VARCHAR(32)
>>>>>>> origin/master
);

<<<<<<< HEAD
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
   foreign key ("itemname") references 'AuthItem' ("name") on delete cascade on update cascade
   foreign key ("userid") references 'tbl_user' ("name") on delete cascade on update cascade
);
-- assign admin role to admin user
INSERT INTO AuthAssignment (itemname, userid) VALUES ('admin', 'admin');
=======
CREATE TABLE file (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL, 
    path VARCHAR(256),
    caption VARCHAR(512)'
    text_id INTEGER
    type_id INTEGER,
    order INTEGER,
    chapter INTEGER,
    post_date DATE,
    voice VARCHAR(128),
    speed VARCHAR(128),
    source VARCHAR(128),
);

CREATE TABLE text (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(512) NOT NULL, 
    author VARCHAR(128),
    edition VARCHAR(128),
    year_published INTEGER,
    poster_id INTEGER,
    post_date DATE,
    type_id INTEGER,
    is_complete BOOLEAN DEFAULT=0,
    is_viewable BOOLEAN DEFAULT=0,
    description VARCHAR(512)
);

term
file_type
section
section_text
course
	: major(code), coursenumber, classId, title(name)
download 

-- waitlist?
>>>>>>> origin/master
