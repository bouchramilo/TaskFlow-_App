-- Active: 1733819346903@@127.0.0.1@3306@taskflow_db

CREATE DATABASE TaskFlow_DB ;

use TaskFlow_DB;

--  creation des tableaux : +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

CREATE TABLE User (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255)
);


CREATE TABLE Task (
    id_task INT AUTO_INCREMENT PRIMARY KEY,
    date_create DATETIME DEFAULT CURRENT_TIMESTAMP ,
    date_fin DATETIME DEFAULT NULL,
    description VARCHAR(255),
    id_user_assignee INT,
    id_user_create INT,
    status ENUM('A faire', 'En cours', 'Fini'),
    title VARCHAR(255),
    FOREIGN KEY (id_user_assignee) REFERENCES User(id_user) ON DELETE SET NULL,
    FOREIGN KEY (id_user_create) REFERENCES User(id_user) ON DELETE CASCADE
);


CREATE TABLE Task_feature (
    id_feature INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_task INT,
    priority enum ('faible', 'moyenne', 'elevee'),
    FOREIGN KEY (id_task) REFERENCES Task(id_task) ON DELETE CASCADE
);


CREATE TABLE Task_bug (
    id_bug INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_task INT,
    gravite ENUM('nonUrgent', 'moyen', 'urgent'),
    FOREIGN KEY (id_task) REFERENCES Task(id_task) ON DELETE CASCADE
);


-- Gestion des tables : Les requêtes : +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++



SELECT 
                    t.*,  -- Toutes les colonnes de la table Task
                    tf.priority, -- La priorité si c'est une feature
                    tb.gravite  -- La gravité si c'est un bug
                FROM Task t
                LEFT JOIN Task_feature tf ON t.id_task = tf.id_task
                LEFT JOIN Task_bug tb ON t.id_task = tb.id_task
                WHERE t.id_task = 20;





SELECT 
                t.*,
                tf.priority,
                tb.gravite,
                concat(uc.first_name , ' ' , uc.last_name) AS creator_name,
                concat(ua.first_name , ' ' , ua.last_name) AS assignee_name
            FROM Task t
            LEFT JOIN Task_feature tf ON t.id_task = tf.id_task
            LEFT JOIN Task_bug tb ON t.id_task = tb.id_task
            LEFT JOIN User uc ON t.id_user_create = uc.id_user
            LEFT JOIN User ua ON t.id_user_assignee = ua.id_user;

-- les procedures : +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
delimiter $$
create procedure afficherTable()
begin
    select * from User ;
    select * from Task ;
    select * from Task_feature ;
    select * from Task_bug ;
end $$
delimiter ;

call afficherTable();

    select * from User ;
    select * from Task ;
    select * from Task_feature ;
    select * from Task_bug ;



-- suppression des donnees ;
-- drop table Task_bug; 
-- drop table Task_feature; 
-- drop table Task; 
-- drop table User; 