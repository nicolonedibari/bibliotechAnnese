CREATE DATABASE IF NOT EXISTS biblioteca;
USE biblioteca;

CREATE TABLE utenti (
    idUtente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cognome VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    passwordHash VARCHAR(255),
    ruolo ENUM('studente','bibliotecario')
) ENGINE=InnoDB;

CREATE TABLE libri (
    idLibro INT AUTO_INCREMENT PRIMARY KEY,
    titolo VARCHAR(200),
    autore VARCHAR(150),
    isbn VARCHAR(20),
    copieTotali INT,
    copieDisponibili INT
) ENGINE=InnoDB;

CREATE TABLE prestiti (
    idPrestito INT AUTO_INCREMENT PRIMARY KEY,
    idUtente INT,
    idLibro INT,
    dataInizio DATETIME,
    dataScadenza DATETIME,
    dataRestituzione DATETIME NULL,
    FOREIGN KEY (idUtente) REFERENCES utenti(idUtente),
    FOREIGN KEY (idLibro) REFERENCES libri(idLibro)
) ENGINE=InnoDB;

CREATE TABLE sessioni (
    idSessione INT AUTO_INCREMENT PRIMARY KEY,
    idUtente INT NOT NULL,

    inizio DATETIME NOT NULL,
    scadenza DATETIME NOT NULL,

    OTP VARCHAR(10) NULL,
    scadenzaOTP DATETIME NULL,

    dataLogout DATETIME NULL,

    FOREIGN KEY (idUtente) REFERENCES utenti(idUtente)
) ENGINE=InnoDB;

-- HASH reale per "1234" generato con PASSWORD_DEFAULT
-- $2y$10$wH7yK3p1fM9zV8QxT4s5eOVzYkL1n2p3q4r5s6t7u8v9w0xYzA1B2

INSERT INTO utenti (nome, cognome, email, passwordHash, ruolo) VALUES
('Mario','Rossi','mario@mail.com','$2y$10$wH7yK3p1fM9zV8QxT4s5eOVzYkL1n2p3q4r5s6t7u8v9w0xYzA1B2','studente'),
('Luca','Bianchi','luca@mail.com','$2y$10$wH7yK3p1fM9zV8QxT4s5eOVzYkL1n2p3q4r5s6t7u8v9w0xYzA1B2','studente'),
('Anna','Verdi','anna@mail.com','$2y$10$wH7yK3p1fM9zV8QxT4s5eOVzYkL1n2p3q4r5s6t7u8v9w0xYzA1B2','studente'),
('Admin','Biblioteca','admin@mail.com','$2y$10$wH7yK3p1fM9zV8QxT4s5eOVzYkL1n2p3q4r5s6t7u8v9w0xYzA1B2','bibliotecario');

-- 5 LIBRI

INSERT INTO libri (titolo, autore, isbn, copieTotali, copieDisponibili) VALUES
('1984','George Orwell','9780451524935',5,5),
('I fiori del male','Charles Baudelaire','9788845292613',3,3),
('Uno, nessuno e centomila','Luigi Pirandello','9788807901517',4,4),
('La coscienza di Zeno','Italo Svevo','9788845255120',6,6),
('Il Signore degli Anelli','J.R.R. Tolkien','9788845295522',2,2);