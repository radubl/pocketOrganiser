-- drop table USERS;
-- CREATE TABLE USERS(userid INTEGER(3), fullname varchar(40), username varchar(25), hashedpassword text, email varchar(50), datejoined datetime);
-- 
-- drop table LISTS;
-- CREATE TABLE LISTS(userid INTEGER(3), listid INTEGER(3), listname varchar(30), category varchar(25), description text, status varchar(15));
-- 
-- drop table LISTITEMS;
-- CREATE TABLE LISTITEMS(itemcontent text, listid INTEGER(3), completed boolean, duedate datetime);
-- 
-- drop table CATEGORIES;
-- CREATE TABLE CATEGORIES(category varchar(25), description text);
-- 
-- drop table FRIENDS;
-- CREATE TABLE FRIENDS(userid0 INTEGER(3), userid1 INTEGER(3));

-- select * from listitems inner join lists on listitems.listid=lists.listid where (lists.listid=00);

INSERT INTO USERS VALUES(0, "Radu Blana", "radubl", "qwerty", "qwerty", "asdasd@aasd.co.uk", 1900-01-01);
INSERT INTO USERS VALUES(1, "Adam Potter", "apot", "qwerty", "qwerty", "asdasd@aasd.co.uk", 1912-01-01);
INSERT INTO USERS VALUES(2, "Corney Blah", "coblah", "qwerty", "qwerty", "asdasd@aasd.co.uk", 1919-01-01);

INSERT INTO LISTS VALUES(0, 00, "Groceries", "Homelists", "ok");
INSERT INTO LISTS VALUES(0, 01, "For Pete", "Homelists", "ok");
INSERT INTO LISTS VALUES(0, 02, "Plants", "Worklists", "ok");

INSERT INTO LISTS VALUES(1, 10, "Groceries1", "Homelists","ok");
INSERT INTO LISTS VALUES(1, 11, "For Pete1", "Homelists","ok");
INSERT INTO LISTS VALUES(1, 12, "Plants1", "Worklists", "ok");

INSERT INTO LISTS VALUES(2, 20, "Groceries1", "Homelists", "ok");
INSERT INTO LISTS VALUES(2, 21, "For Pete1", "Homelists", "ok");
INSERT INTO LISTS VALUES(2, 22, "Plants1", "Worklists", "ok");

INSERT INTO LISTITEMS VALUES("Do this", 00, 1 ,2012-01-01);
INSERT INTO LISTITEMS VALUES("Do this", 00, 0 ,2012-01-01);
INSERT INTO LISTITEMS VALUES("Do this", 00, 0 ,2012-01-01);

INSERT INTO LISTITEMS VALUES("Do this", 21, 1 ,2012-01-01);
INSERT INTO LISTITEMS VALUES("Do that", 21, 0 ,2012-01-01);
INSERT INTO LISTITEMS VALUES("Do not", 21, 0 ,2012-01-01);

INSERT INTO LISTITEMS VALUES("Do those", 12, 0 ,2012-01-01);
INSERT INTO LISTITEMS VALUES("Do not", 12, 1 ,2012-01-01);
INSERT INTO LISTITEMS VALUES("Do that", 12, 0 ,2012-01-01);

INSERT INTO CATEGORIES VALUES("Homelists", "this category is for home related lists");
INSERT INTO CATEGORIES VALUES("Worklists", "this category is for work related lists");

