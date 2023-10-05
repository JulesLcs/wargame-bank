-- Création de la table "users"
CREATE TABLE users (
   id SERIAL PRIMARY KEY,
   nom VARCHAR(255),
   prenom VARCHAR(255),
   email VARCHAR(255) UNIQUE,
   pwd VARCHAR(255),
   solde DECIMAL(10, 2) DEFAULT 0.00
);

-- Création de la table "transferts"
CREATE TABLE transferts (
   id SERIAL PRIMARY KEY,
   sender_id INT REFERENCES users(id),
   reciever_id INT REFERENCES users(id),
   montant DECIMAL(10, 2) NOT NULL,
   date TIMESTAMP DEFAULT current_timestamp
);

INSERT INTO users (nom, prenom, email, pwd, solde)
VALUES
  ('Lucas', 'Jules', 'lucas.jules@isen.com', 'motdepasse1', 1000.00),
  ('Bouju', 'Guillaume', 'bouju.guillaume@isen.com', 'motdepasse2', 1500.00),
  ('Sicot', 'François', 'sicot.françois@isen.com', 'motdepasse3', 2000.00);

INSERT INTO transferts (sender_id, reciever_id, montant)
VALUES
  (1, 2, 100.00),
  (2, 1, 50.00),
  (2, 3, 75.00);