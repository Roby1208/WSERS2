drop database someExample;
commit;

create database someExample;
use someExample;

create table PossibleColors(
    ColorId INT NOT NULL AUTO_INCREMENT,
    ColorText varchar(20),
    PRIMARY KEY (ColorId)
);

create table PossibleSizes(
    SizeId INT NOT NULL AUTO_INCREMENT,
    SizeText varchar(20),
    PRIMARY KEY (SizeId)
);

create table Fruits(
    FruitId INT NOT NULL AUTO_INCREMENT,
    Name varchar(20),
    Size int,
    Color int,
    Description varchar(50),
    Calories int,
    Price int,
    PRIMARY KEY (FruitId),
    FOREIGN KEY (Size) REFERENCES PossibleSizes(SizeId),
    FOREIGN KEY (Color) REFERENCES PossibleColors(ColorId)
);

INSERT INTO PossibleColors (ColorText) VALUES("Yellow");
INSERT INTO PossibleColors (ColorText) VALUES("Red");
INSERT INTO PossibleColors (ColorText) VALUES("Green");
INSERT INTO PossibleColors (ColorText) VALUES("Blue");
INSERT INTO PossibleColors (ColorText) VALUES("Pink");

INSERT INTO PossibleSizes (SizeText) VALUES("Small");
INSERT INTO PossibleSizes (SizeText) VALUES("Medium");
INSERT INTO PossibleSizes (SizeText) VALUES("Large");

INSERT INTO Fruits(Name, Size, Color, Description, Calories,Price) VALUES ("Cheries", 1, 2, "They grow on trees", 2, 10);
INSERT INTO Fruits(Name, Size, Color, Description, Calories,Price) VALUES ("Apples", 2, 1, "They grow on trees", 10, 5);
INSERT INTO Fruits(Name, Size, Color, Description, Calories,Price) VALUES ("Watermelon", 3, 3, "They grow on the floor", 20, 2);

create view fullFruitsView as SELECT * FROM Fruits
join PossibleColors on Fruits.Color = PossibleColors.ColorId 
JOIN PossibleSizes on Fruits.Size = PossibleSizes.SizeId;