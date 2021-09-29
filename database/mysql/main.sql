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
CREATE TABLE app_advisors (
	id int auto_increment primary key,
    id_user int not null,
    FOREIGN KEY FK_App_advisors_users (id_user) REFERENCES app_users(id) ON UPDATE NO ACTION ON DELETE NO ACTION
);
END

BEGIN
CREATE TABLE app_tcc (
		id int auto_increment primary key,
        id_user int not null,
        id_advisor int not null,
        id_category int not null,
        name varchar(100) not null,
        area varchar(100) not null,
        description text not null,
        logo text not null,
        ended bool,
		status char(1) default 'A',
		user_add varchar(50) not null,
		date_add datetime default current_timestamp,
		user_update varchar(50),
		date_update datetime,
        FOREIGN KEY FK_App_tcc_users (id_user) REFERENCES app_users(id) ON UPDATE NO ACTION ON DELETE NO ACTION,
        FOREIGN KEY FK_App_tcc_advisors (id_advisor) REFERENCES app_advisors (id) ON UPDATE NO ACTION ON DELETE NO ACTION,
        FOREIGN KEY FK_App_tcc_category (id_category) REFERENCES app_categories(id) ON UPDATE NO ACTION ON DELETE NO ACTION
);
END

BEGIN
CREATE TABLE app_categories (
		id int auto_increment primary key,
        name varchar(100) not null,
        status char(1) default 'A',
        user_add varchar(50) not null,
		date_add datetime default current_timestamp,
		user_update varchar(50),
		date_update datetime
);
END

BEGIN
CREATE TABLE app_etapas (
	id int auto_increment primary key,
    nome varchar(50) not null,
    id_tcc int  not null,
    FOREIGN KEY FK_App_etapas_tcc (id_tcc) REFERENCES app_tcc (id) ON UPDATE NO ACTION ON DELETE NO ACTION
);
END

BEGIN
CREATE TABLE app_status_tasks (
		id int auto_increment primary key,
        nome varchar(20) not null
);
END

BEGIN
INSERT INTO app_status_tasks (id, nome) VALUES (1, 'Pendentes'), (2, 'Em Progresso'), (3, 'Finalizados');
END

BEGIN
CREATE TABLE app_tasks (
	id int auto_increment primary key,
    id_etapa int not null,
    id_status int default 1 not null,
    nome varchar(50) not null,
    descricao text,
    FOREIGN KEY FK_App_tasks_etapas (id_etapa) REFERENCES app_etapas (id) ON UPDATE NO ACTION ON DELETE NO ACTION,
    FOREIGN KEY FK_App_tasks_status (id_status) REFERENCES app_status_tasks (id) ON UPDATE NO ACTION ON DELETE NO ACTION
);
END
