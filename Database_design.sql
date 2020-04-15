create database class_arrangement;

use class_arrangement;
create table class_info(
CourseNo varchar(50),
Num_of_Day_to_meet int
);
create table class_Room(
roomNum varchar(15) primary key
);
create table classes
(
 
  CourseNo  varchar(50) primary key,
   HoursperWeek int
 
);
create table class_schedule
(
  MeetingID int primary key  AUTO_INCREMENT,
  Section   varchar(10),
  Classroom      varchar(15),
  StartTime int,
  EndTime   int,
  The_Date  varchar(10), 
  CourseNo     varchar(50),
  FOREIGN KEY (CourseNo) REFERENCES classes(CourseNo),
  FOREIGN KEY (Classroom) REFERENCES class_Room(roomNum)
);


insert into   classes value("CSC101",'4');
insert into   classes value("CSC110",'4');
insert into   classes value("CSC111",'5');
insert into   classes value("CSC210",'5');
insert into   classes value("CSC211",'5');
insert into   classes value("CSC215",'4');
insert into   classes value("CSC230",'6');
insert into   classes value("CSC231",'4');
insert into   classes value("CSC310",'4');
insert into   classes value("CSC330",'4');
insert into   classes value("CSC331",'5');
insert into   classes value("CSC350",'5');
insert into   classes value("CSC410",'4');
insert into   classes value("CSC430",'4');
insert into   classes value("CSC450",'4');
insert into   classes value("CSC470",'5');
insert into   classes value("CIS100",'4');
insert into   classes value("CIS115",'4');
insert into   classes value("CIS120",'3');
insert into   classes value("CIS140",'3');
insert into   classes value("CIS155",'5');
insert into   classes value("CIS160",'3');
insert into   classes value("CIS165",'4');
insert into   classes value("CIS180",'4');
insert into   classes value("CIS200",'4');
insert into   classes value("CIS207",'6');
insert into   classes value("CIS220",'4');
insert into   classes value("CIS235",'5');
insert into   classes value("CIS255",'6');
insert into   classes value("CIS280",'4');
insert into   classes value("CIS316",'4');
insert into   classes value("CIS317",'4');
insert into   classes value("CIS325",'4');
insert into   classes value("CIS335",'5');
insert into   classes value("CIS345",'5');
insert into   classes value("CIS359",'4');
insert into   classes value("CIS362",'4');
insert into   classes value("CIS364",'4');
insert into   classes value("CIS365",'5');
insert into   classes value("CIS370",'4');
insert into   classes value("CIS385",'4');
insert into   classes value("CIS390",'4');
insert into   classes value("CIS420",'5');
insert into   classes value("CIS440",'4');
insert into   classes value("CIS445",'5');
insert into   classes value("CIS455",'5');
insert into   classes value("CIS459",'5');
insert into   classes value("CIS465",'10');
insert into   classes value("CIS475",'5');
insert into   classes value("CIS480",'3');
insert into   classes value("CIS485",'4');
insert into   classes value("CIS490",'4');
insert into   classes value("CIS495",'4');








