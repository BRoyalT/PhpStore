drop table if exists item;
create table item (
  id int auto_increment primary key not null,
  name varchar(255) unique not null,
  category varchar(255) not null,
  price real not null default 0,
  description text not null,
  image varchar(255) not null default ''
);
