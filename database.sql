drop database if exists blog;

create database blog;

use blog;

create table `user` (
    id int primary key not null auto_increment,
    username varchar(25) unique not null,
    pw varchar(255) not null,
    picture varchar(100)
);

insert into `user` (username, pw, picture) values ("noora_admin", "abcde12345", "blank_pfp.png");

create table post (
    id int primary key not null auto_increment,
    user_id int not null,
    title varchar(150) not null,
    post text not null,
    created timestamp default current_timestamp not null,
    foreign key (user_id) references `user`(id)
);

insert into post (user_id, title, post) values (1, "Welcome to our blog!", "Hi everyone! I'm Noora, one of the admins. Hope you enjoy our blog :)");

create table `comment` (
    id int primary key not null auto_increment,
    post_id int not null,
    user_id int not null,
    comment text not null,
    created timestamp default current_timestamp not null,
    foreign key (post_id) references post(id),
    foreign key (user_id) references `user`(id)
);

insert into `comment` (post_id, user_id, comment) values (1, 1, "If you have any questions, leave a comment under this post!");