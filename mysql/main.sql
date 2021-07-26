BEGIN
CREATE TABLE app_users (
		id int auto_increment not null primary key,
		username varchar(100) not null,
		email varchar(255) not null unique,
		first_name varchar(50) not null,
		last_name varchar(50) not null,
		access_key varchar(40) not null,
		token varchar(20) not null,
		avatar varchar(50) default 'default.jpg',
		last_login datetime,
		status char(1) default 'A',
		date_add datetime default current_timestamp,
		user_update varchar(50),
		date_update datetime
);

INSERT INTO `heroku_1f3b85700f04a12`.`app_users`
(
`username`,
`email`,
`first_name`,
`last_name`,
'access_key',
`token`,
`user_update`
)
VALUES
(

);

END

BEGIN
CREATE TABLE app_institute (
		id int auto_increment primary key,
        name varchar(30) not null,
		status char(1) default 'A',
		user_add varchar(50) not null,
		date_add datetime default current_timestamp,
		user_update varchar(50),
		date_update datetime
);
END

BEGIN
CREATE TABLE app_tcc (
		id int auto_increment primary key,
        name varchar(100) not null,
        category varchar(30) not null,
        ended bool,
		status char(1) default 'A',
		user_add varchar(50) not null,
		date_add datetime default current_timestamp,
		user_update varchar(50),
		date_update datetime
);
END