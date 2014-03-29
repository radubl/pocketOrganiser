

drop table USERS;
CREATE TABLE USERS(userid INTEGER(6), fullname varchar(40), username varchar(25), hashedpassword text, salt text, email varchar(50), datejoined datetime);


-- ================================================================= LISTS ===============================================================


drop table LISTS;
CREATE TABLE LISTS(userid INTEGER(6), listid INTEGER(6), listname varchar(30), category varchar(25), status varchar(15), duedate varchar(20));

drop table LISTITEMS;
CREATE TABLE LISTITEMS(itemcontent text, userid INTEGER(6), listid INTEGER(6), completed boolean);

drop table CATEGORIES;
CREATE TABLE CATEGORIES(category varchar(25), description text);


-- ================================================================ SPLITS ===============================================================


drop table FRIENDS;
CREATE TABLE FRIENDS(userid0 INTEGER(6), userid1 INTEGER(6), balance INTEGER(9));

drop table GROUPS;
CREATE TABLE GROUPS(groupid INTEGER(6), groupname varchar(25), userid INTEGER(6), description text, usercolor varchar(7));

drop table UPDATES;
CREATE TABLE UPDATES(message text, groupname varchar(25), userid INTEGER(6), datecreated varchar(40));

drop table BILLS;
CREATE TABLE BILLS(billid INTEGER(6), billname varchar(20), 
groupname varchar(25), splitmode varchar(50), amount integer(9), duedate varchar(20), datecreated varchar(40), description text);

drop table USERUPDATES;
CREATE TABLE USERUPDATES(message text, userid INTEGER(6), datecreated varchar(40));

drop table MESSAGES;
CREATE TABLE MESSAGES(userid0 INTEGER(6), userid1 INTEGER(6), feed text);
