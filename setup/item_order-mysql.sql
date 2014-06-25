drop table if exists item_order;
create table item_order (
  id integer auto_increment primary key not null,
  item_id integer not null,
  order_id integer not null,
  quantity integer not null,
  price real not null,
  key(order_id),
  key(item_id),
  unique(order_id,item_id)
);
