drop database if exists blog;

create database blog;

use blog;

create table `user` (
    id int primary key not null auto_increment,
    username varchar(25) unique not null,
    pw varchar(255) not null,
    picture varchar(100)
);

create table post (
    id int primary key not null auto_increment,
    user_id int not null,
    title varchar(150) not null,
    post text not null,
    created timestamp default current_timestamp not null,
    foreign key (user_id) references `user`(id)
);

create table `comment` (
    id int primary key not null auto_increment,
    post_id int not null,
    user_id int not null,
    comment text not null,
    created timestamp default current_timestamp not null,
    foreign key (post_id) references post(id),
    foreign key (user_id) references `user`(id)
);