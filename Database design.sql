create database if not exists  bmcc;
use bmcc;
create table class_schedule
(
  MeetingID int primary key  AUTO_INCREMENT,
  Section   varchar(10),
  Room      varchar(15),
  StartTime int,
  EndTime   int,
  The_Date  varchar(10), 
  Course_title     varchar(15)
);

create table classes
(
  HoursperWeek int,
  Course_Title  varchar(15)
);

create table class_Room(
roomNum varchar(15) primary key
);


