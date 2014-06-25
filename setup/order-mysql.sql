drop table if exists `order`;
create table `order` (
  id int auto_increment primary key not null,
  user_id int not null,
  created_at int not null,
  key(user_id)
);
