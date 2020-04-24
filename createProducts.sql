use roby;

CREATE TABLE Products(
    ID INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    Description VARCHAR(500),
    Price INT NOT NULL,
    PRIMARY KEY (ID)
);