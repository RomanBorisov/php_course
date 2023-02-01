create database music;

use music;

create table albums
(
    id    int unsigned auto_increment primary key,
    date  timestamp    null,
    title varchar(255) not null
);

create table songs
(
    id       int unsigned auto_increment primary key,
    album_id int unsigned not null,
    title    varchar(255),
    duration time         not null,
    foreign key (album_id)
        references albums (id)
        on delete cascade
);