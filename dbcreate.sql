create database madlibs;
use madlibs;
create table entry( 
  id INT(11) NOT NULL AUTO_INCREMENT,
  phrase VARCHAR(200) NOT NULL,
  rank INT(11) NOT NULL, 
  note text,
  PRIMARY KEY (id)
);
