create database school;
use school;
CREATE TABLE users (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255),
        phone VARCHAR(255),
        address VARCHAR(255),
        gender VARCHAR (255),
        date DATE NOT NULL,
	email VARCHAR(255),
	password CHAR(32),
	UNIQUE (email)
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE pay (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	classid INT NOT NULL,
	name VARCHAR (255),
	amount DECIMAL(12,2),
	deleted INT NOT NULL

) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE term (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR (255)

) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE class (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR (255),
	deleted INT NOT NULL

) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;


CREATE TABLE session (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR (255)

) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE student (
       id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
       surname VARCHAR (255),
	   firstname VARCHAR (255),
	   othername VARCHAR (255),
	   regnumber VARCHAR (255),
	   parentnumber VARCHAR (255),
	   classid INT NOT NULL,
	   sessionid INT NOT NULL,
       termid INT NOT NULL,
       dob DATE NOT NULL,
	   date DATE NOT NULL,
	   deleted INT NOT NULL
	
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB; 


CREATE TABLE payment (
       id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
       studentid INT NOT NULL,
	   regnumber VARCHAR(255),
       payid INT NOT NULL,
	   classid INT NOT NULL,
       sessionid INT NOT NULL,
       termid INT NOT NULL,
       amount DECIMAL(12,2),
	   paymentid VARCHAR(255),
	   deleted INT NOT NULL,
       date DATE NOT NULL
  
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;


CREATE TABLE role (
	id VARCHAR(255) NOT NULL PRIMARY KEY,
	description VARCHAR(255)
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE userrole (
	userid INT NOT NULL,
	roleid VARCHAR(255) NOT NULL,
	PRIMARY KEY (userid, roleid)
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE subject (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255),
	deleted INT NOT NULL
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE studentsubject (
	studentid INT NOT NULL,
	regnumber VARCHAR(255),
	subjectid INT NOT NULL,
	sessionid INT NOT NULL,
	termid INT NOT NULL,
	classid INT NOT NULL,
	test1 INT NOT NULL,
	test2 INT NOT NULL,
	score INT NOT NULL,
	PRIMARY KEY (studentid, subjectid, sessionid, termid, classid)
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

# Sample data
# We specify the IDs so they are known when we add related entries

INSERT INTO users (id, name, phone, address, gender, date, email, password) VALUES
(1, 'Hammed Taofeek', '08035297428', 'no 5 oriire akure', 'Male', '2012-04-01','htolajide@yahoo.com', '29fb983fe703ab92c11ecb43879e5d45'
),
(2, 'Kareem Akeem', '08035297428', 'no 5 oriire lagos', 'Male', '2012-04-01','kareemakeem@yahoo.com',  '29fb983fe703ab92c11ecb43879e5d45'
);#password is olajide. MD fuction is giving error here.

INSERT INTO pay (id, classid, name, amount) VALUES
(1,  1, 'school fees', 25000 ),
(2, 1, 'uniform', 2500 );


INSERT INTO class (id, name) VALUES
(1, 'Kg 1'),
(2, 'kg 2');

INSERT INTO role (id, description) VALUES
('Admin Officer', 'Add, Remove, and Update User Information'),
('Class Teacher', 'Add, Remove and Update Student Information'),
('Secretary', 'Add, Remove, and Update Payments');

INSERT INTO userrole (userid, roleid) VALUES
(1, 'Admin Officer'),
(1, 'Class Teacher'),
(1, 'Secretary');