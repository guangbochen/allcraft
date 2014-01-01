DROP DATABASE allcraftDB;
CREATE DATABASE IF NOT EXISTS allcraftDB;
USE allcraftDB;

CREATE TABLE IF NOT EXISTS users(
    id        INTEGER NOT NULL AUTO_INCREMENT,
    firstName VARCHAR(200) NOT NULL,
    lastName  VARCHAR(200) NOT NULL,
    userName  VARCHAR(200) NOT NULL,
    password  VARCHAR(200) NOT NULL,
    email     VARCHAR(200) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS messages(
    id          INTEGER NOT NULL AUTO_INCREMENT,
    username    VARCHAR(200) NOT NULL,
    is_creator  BOOLEAN NOT NULL,
    description VARCHAR(255) NOT NULL,
    created_at  TIMESTAMP NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS subscribers(
    id          INTEGER NOT NULL AUTO_INCREMENT,
    message_id  INTEGER NOT NULL,
    assigned_user    VARCHAR(255) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (message_id) REFERENCES messages(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS statuses(
    id          INTEGER NOT NULL AUTO_INCREMENT,
    status      VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS orders(
    id                INTEGER NOT NULL AUTO_INCREMENT,
    status            VARCHAR(255) NULL,
    order_number      VARCHAR(255) NULL,
    job               VARCHAR(255) NULL,
    customer          VARCHAR(255) NULL,
    job_title         VARCHAR(255) NULL,
    qty               VARCHAR(255) NULL,
    size              VARCHAR(255) NULL,
    pp                VARCHAR(255) NULL,
    stock             VARCHAR(255) NULL,
    gsm               VARCHAR(255) NULL,
    print_slide_one   VARCHAR(255) NULL,
    print_slide_two   VARCHAR(255) NULL,
    date_in           VARCHAR(255) NULL,
    date_approved     VARCHAR(255) NULL,
    date_required     VARCHAR(255) NULL,
    job_note          VARCHAR(255) NULL,
    inv_number        VARCHAR(255) NULL,
    production_number VARCHAR(255) NULL,
    ok                VARCHAR(255) NULL,
    despatch_by       VARCHAR(255) NULL,
    address           VARCHAR(255) NULL,
    booking           VARCHAR(255) NULL,
    created_at        TIMESTAMP NOT NULL,
    updated_at        TIMESTAMP NOT NULL,
    PRIMARY KEY(id)
);

insert into statuses(status, description) values ( 'a' , 'Manager');
insert into statuses(status, description) values ( 'b' , 'Sells Man');
insert into statuses(status, description) values ( 'c' , 'Customer Service');

insert into users(id, firstName, lastName, userName, password, email) values (1, 'hook', 'creative', 'admin', 'admin', 'me.admin@email.com');
insert into users(id, firstName, lastName, userName, password, email) values (2, 'hook', 'creative', 'user1', 'password', 'me.user1@email.com');
insert into users(id, firstName, lastName, userName, password, email) values (3, 'hook', 'creative', 'user2', 'password', 'me.user2@email.com');
insert into users(id, firstName, lastName, userName, password, email) values (4, 'hook', 'creative', 'user3', 'password', 'me.user3@email.com');

INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('AC00001', 'c', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00');

/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'c', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'b', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'c', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'c', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'b', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'c', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'c', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'a', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'b', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'c', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'b', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'a', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'a', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'a', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'a', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */

/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'b', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-12 11:30:00','2013-12-12 11:30:00'); */

/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'b', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-13 11:30:00','2013-12-13 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order5', 'c', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-13 11:30:00','2013-12-13 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'b', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-13 11:30:00','2013-12-13 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'b', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-13 11:30:00','2013-12-13 11:30:00'); */
/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'a', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-13 11:30:00','2013-12-13 11:30:00'); */

/* INSERT INTO orders (order_number, status,job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order1', 'b', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', '2013-12-16 11:30:00','2013-12-12 11:30:00'); */

/* INSERT INTO orders (order_number, status, job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order2', 'b', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', NOW(), NOW()); */

/* INSERT INTO orders (order_number, status, job,customer,job_title,qty,size,pp,stock,gsm,print_slide_one,print_slide_two,date_in,date_approved,date_required,job_note,inv_number,production_number,ok,despatch_by,address,booking, created_at, updated_at) VALUES ('order2', 'c', 'neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu','Abbot','sit amet nulla. Donec non justo.','ac facilisis facilisis, magna tellus faucibus leo, in','elit elit fermentum risus, at fringilla purus','Nam ligula elit,','turpis. In condimentum. Donec at arcu. Vestibulum','mi. Duis risus odio, auctor vitae,','laoreet','Morbi non sapien molestie orci tincidunt adipiscing.','purus','amet ornare lectus justo eu arcu. Morbi sit amet','quis diam. Pellentesque habitant morbi tristique','Vivamus sit amet risus.','ac, fermentum vel, mauris. Integer sem elit,','congue, elit sed consequat auctor,','mi lacinia mattis. Integer eu lacus. Quisque imperdiet,','parturient montes, nascetur ridiculus mus. Proin vel arcu','placerat. Cras dictum ultricies ligula.','at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et', NOW(), NOW()); */
