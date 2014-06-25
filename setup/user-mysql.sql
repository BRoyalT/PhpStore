drop table if exists user;
create table user (
  id integer auto_increment primary key not null,
  name varchar(255) unique not null,
  email varchar(255) not null,
  password char(40) not null,
  level int not null default 0
);
