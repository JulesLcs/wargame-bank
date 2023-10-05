--DROP DATABASE IF EXISTS bank;
--CREATE DATABASE bank;
-- DROP TABLE transferts;
-- DROP TABLE users;
-- Creation de la table "users"
CREATE TABLE IF NOT EXISTS users (
   id SERIAL PRIMARY KEY,
   nom VARCHAR(255),
   prenom VARCHAR(255),
   mail VARCHAR(255) UNIQUE,
   pwd VARCHAR(255),
   solde DECIMAL(10, 2) DEFAULT 0.00
);

-- Creation de la table "transferts"
CREATE TABLE IF NOT EXISTS transferts (
   id SERIAL PRIMARY KEY,
   sender_id INT REFERENCES users(id),
   reciever_id INT REFERENCES users(id),
   montant DECIMAL(10, 2) NOT NULL,
   date TIMESTAMP DEFAULT current_timestamp
);

INSERT INTO users (nom, prenom, mail, pwd, solde)
VALUES
  ('Lucas', 'Jules', 'lucas.jules@isen.com', '$2y$10$MRhFYy2BYtfTOhMIj3F64uAV9ykFf6qAUOagLVsxmqmAq06WZLUCu', 1000.00),
  ('Bouju', 'Guillaume', 'bouju.guillaume@isen.com', '$2y$10$bcSZhuoKW5pwL0mzxazdoOvmnaSDvnoXbFkU7NjW.uMaA.UjpzkOq', 1500.00),
  ('Sicot', 'François', 'sicot.françois@isen.com', '$2y$10$qFyk/ksdSxMbaNjVtveMLOHJ2Ah4ejRfI23GS6keyym/vPgQQogGi', 2000.00);

INSERT INTO transferts (sender_id, reciever_id, montant)
VALUES
  (1, 2, 100.00),
  (2, 1, 50.00),
  (2, 3, 75.00);