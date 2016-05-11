
create table ids_log(
ids_id int(10) primary key,
time timestamp not null default CURRENT_TIMESTAMP
);
	
create table process(
ids_id int(10) not null,
user varchar(32) not null,
pid int(8) not null,
cpu varchar(10),
mem varchar(10),
process varchar(512) not null,
mark int(3) default 3,
foreign key(ids_id) references ids_log(ids_id)
)DEFAULT CHARSET=utf8;

create table port(
ids_id int(10) not null,
proto varchar(10) not null,
process varchar(64) not null,
listen varchar(32) not null,
mark int(3) default 3,
foreign key(ids_id) references ids_log(ids_id)
)DEFAULT CHARSET=utf8;

create table firewall(
ids_id int(10) not null,
status_md5 varchar(32) not null,
firewall_detail varchar(20480) not null,
mark int(3) default 3,
foreign key(ids_id) references ids_log(ids_id)
)DEFAULT CHARSET=utf8;

create table ethernet(
ids_id int(10) not null,
status_md5 varchar(32) not null,
ethernet_detail varchar(20480) not null,
mark int(3) default 3,
foreign key(ids_id) references ids_log(ids_id)
)DEFAULT CHARSET=utf8;

create table website(
ids_id int(10) not null,
file varchar(512) not null,
father_path varchar(10240) not null,
file_mtime timestamp not null,
file_md5 varchar(32) not null,
mark int(10) default 3
foreign key(ids_id) references ids_log(ids_id)
)DEFAULT CHARSET=utf8;


create table file(
ids_id int(10) not null,
file varchar(512) not null,
father_path varchar(10240) not null,
mtime timestamp not null,
size int(20) not null,
permission varchar(3) not null,
uid int(5) not null,
gid int(5) not null,
stat_md5 varchar(32) primary key,
mark int(10) default 3,
foreign key(ids_id) references ids_log(ids_id)
)DEFAULT CHARSET=utf8;
