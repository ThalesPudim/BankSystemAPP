CREATE DATABASE HringBank;
USE HringBank;

CREATE TABLE Address(
    AddressID int not null,
    Street varchar(255) not null,
    City varchar(255) not null,
    State varchar(255) not null,
    ZipCode int(9) not null,
    Country varchar(255) not null,
    
    PRIMARY KEY (AddressID)
);

CREATE TABLE AccountTypes(
    AccountTypeID int not null,
    Type varchar(255) not null,
    
    PRIMARY KEY(AccountTypeID)
);

CREATE TABLE Transactions(
    TransactionID int not null,
    Amount float not null,
    TransactionDate date,
    
    PRIMARY KEY (TransactionID)
);

CREATE TABLE Users(
    UserID int not null,
    FirstName varchar(255) not null,  
    LastName varchar(255) not null,    
    DateOfBirth datetime not null,
    AddressID int not null,
    Email varchar(255) not null,
    CPF char(11) not null,
    UserPassword varchar(255) not null,
    Gender boolean not null,
    Balance float not null,
    AccountTypeID int not null,
    
    PRIMARY KEY (UserID),
    FOREIGN KEY (AddressID) REFERENCES Address(AddressID),
    FOREIGN KEY (AccountTypeID) REFERENCES AccountTypes(AccountTypeID)
);

CREATE TABLE UserTransactions (
    UserID int not null,
    TransactionID int not null,
    
    PRIMARY KEY (UserID, TransactionID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (TransactionID) REFERENCES Transactions(TransactionID)
);

CREATE TABLE LoanRequests(
    LoanRequestID int not null,
    UserID int not null,
    Amount float not null,
    RequestDate date not null,
    RequestStatus varchar(45),
    
    PRIMARY KEY(LoanRequestID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE TransactionType(
    TransactionTypeID int not null,
    Type varchar(45),
    
    PRIMARY KEY(TransactionTypeID)
);

