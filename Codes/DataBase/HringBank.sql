CREATE DATABASE IF NOT EXISTS HringBank;
USE HringBank;

CREATE TABLE IF NOT EXISTS Address (
    AddressID INT AUTO_INCREMENT PRIMARY KEY,
    Street VARCHAR(255) NOT NULL,
    City VARCHAR(255) NOT NULL,
    State VARCHAR(255) NOT NULL,
    ZipCode INT(9) NOT NULL,
    Country VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS AccountTypes (
    AccountTypeID INT AUTO_INCREMENT PRIMARY KEY,
    Type VARCHAR(255) NOT NULL
);


CREATE TABLE IF NOT EXISTS Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(255) NOT NULL,
    LastName VARCHAR(255) NOT NULL,
    DateOfBirth DATETIME NOT NULL,
    AddressID INT NOT NULL,
    Email VARCHAR(255) NOT NULL,
    CPF CHAR(11) NOT NULL,
    UserPassword VARCHAR(255) NOT NULL,
    Gender INT NOT NULL,
    Balance FLOAT NOT NULL,
    AccountTypeID INT NOT NULL,
    FOREIGN KEY (AddressID) REFERENCES Address(AddressID),
    FOREIGN KEY (AccountTypeID) REFERENCES AccountTypes(AccountTypeID)
);

CREATE TABLE IF NOT EXISTS Transactions (
    TransactionID INT AUTO_INCREMENT PRIMARY KEY,
    Amount FLOAT NOT NULL,
    TransactionDate DATE,
    SenderID INT NOT NULL,
    ReceiverID INT NOT NULL, 
    FOREIGN KEY (SenderID) REFERENCES Users(UserID), 
    FOREIGN KEY (ReceiverID) REFERENCES Users(UserID)
);


CREATE TABLE IF NOT EXISTS UserTransactions (
    UserID INT NOT NULL,
    TransactionID INT NOT NULL,
    PRIMARY KEY (UserID, TransactionID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (TransactionID) REFERENCES Transactions(TransactionID)
);

CREATE TABLE IF NOT EXISTS LoanRequests (
    LoanRequestID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    Amount FLOAT NOT NULL,
    RequestDate DATE NOT NULL,
    RequestStatus VARCHAR(45),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE IF NOT EXISTS TransactionType (
    TransactionTypeID INT AUTO_INCREMENT PRIMARY KEY,
    TypeName VARCHAR(45) NOT NULL
);

-- Populando a tabela Address
INSERT INTO Address (Street, City, State, ZipCode, Country)
VALUES 
    ('Rua A', 'Cidade A', 'Estado A', '12345678', 'País A'),
    ('Rua B', 'Cidade B', 'Estado B', '87654321', 'País B'),
    ('Rua C', 'Cidade C', 'Estado C', '13579246', 'País C');

-- Populando a tabela AccountTypes
INSERT INTO AccountTypes (Type)
VALUES 
    ('Conta Corrente'),
    ('Conta Poupança');

-- Populando a tabela Users
INSERT INTO Users (FirstName, LastName, DateOfBirth, AddressID, Email, CPF, UserPassword, Gender, Balance, AccountTypeID)
VALUES 
    ('João', 'Silva', '1990-01-15', 1, 'joao@example.com', '12345678901', 'senha123', 1, 1000.00, 1),
    ('Maria', 'Souza', '1985-05-20', 2, 'maria@example.com', '98765432109', 'senha456', 2, 1500.00, 2),
    ('Pedro', 'Ferreira', '1992-09-10', 3, 'pedro@example.com', '45678912305', 'senha789', 1, 800.00, 1);

-- Populando a tabela Transactions
INSERT INTO Transactions (Amount, TransactionDate, SenderID, ReceiverID)
VALUES 
    (500.00, '2024-06-01', 1, 2),
    (300.00, '2024-06-02', 2, 3),
    (200.00, '2024-06-03', 3, 1);

-- Populando a tabela UserTransactions
INSERT INTO UserTransactions (UserID, TransactionID)
VALUES 
    (1, 1),
    (2, 2),
    (3, 3);

-- Populando a tabela LoanRequests (com exemplo de uma solicitação pendente)
INSERT INTO LoanRequests (UserID, Amount, RequestDate, RequestStatus)
VALUES 
    (1, 1000.00, '2024-06-01', 'Pendente');

-- Populando a tabela TransactionType
INSERT INTO TransactionType (TypeName)
VALUES 
    ('Enviar'),
    ('Receber');