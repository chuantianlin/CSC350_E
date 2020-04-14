create database class_arrangement;

use class_arrangement;

create table class_Room(
roomNum varchar(15) primary key
);
create table classes
(
  HoursperWeek int,
  CourseNo  varchar(50) primary key
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
create table class_info(
CourseNo varchar(50),
Num_of_Day_to_meet int,
FOREIGN KEY (CourseNo) REFERENCES classes(CourseNo),
FOREIGN KEY (CourseNo) REFERENCES class_schedule(CourseNo)
);











