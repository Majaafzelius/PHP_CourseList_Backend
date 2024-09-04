create database if not exists rest;
use rest;

create table if not exists course (
id					int auto_increment primary key,
courseName			varchar(100),
courseCode			varchar(10),
courseProgression	varchar(2),
courseSyllabus		varchar(100)
);

select * from course;
drop table course;