create database social;

use social;

create table users
(
    id            int unsigned auto_increment primary key,
    name          varchar(128) not null,
    gender        boolean,
    date_of_birth datetime,
    last_visit    datetime,
    is_online     boolean      not null default false
);

create table friends
(
    id            int unsigned auto_increment primary key,
    user_from_id  int unsigned      not null,
    user_to_id    int unsigned      not null,
    friend_status smallint unsigned not null,
    send_date     datetime          not null,
    foreign key (user_from_id)
        references users (id)
        on delete cascade,
    foreign key (user_to_id)
        references users (id)
        on delete cascade
);

create table posts
(
    id        int unsigned auto_increment primary key,
    author_id int unsigned not null,
    send_date datetime     not null,
    text      text,
    foreign key (author_id)
        references users (id)
        on delete cascade
);

create table likes
(
    id      int unsigned auto_increment primary key,
    user_id int unsigned not null,
    post_id int unsigned not null,
    foreign key (user_id)
        references users (id)
        on delete cascade,
    foreign key (post_id)
        references posts (id)
        on delete cascade
);
