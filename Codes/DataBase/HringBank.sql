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

CREATE TABLE IF NOT EXISTS Transactions (
    TransactionID INT AUTO_INCREMENT PRIMARY KEY,
    Amount FLOAT NOT NULL,
    TransactionDate DATE
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