CREATE TABLE app_users (
		id int auto_increment not null primary key,
		username varchar(100) not null,
		email varchar(255) not null unique,
		first_name varchar(50) not null,
		last_name varchar(50) not null,
		token int not null,
		avatar varchar(50) default 'default.jpg',
		last_login datetime,
		status char(1) default 'A',
		date_add datetime default current_timestamp,
		user_update varchar(50),
		date_update datetime
);
