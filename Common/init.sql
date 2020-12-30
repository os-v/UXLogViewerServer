
DROP TABLE UsersInfo;
DROP TABLE UsersRegs;

CREATE TABLE UsersInfo (
    ID INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    UserInfo TEXT,
    UserPass TEXT,
    ThemesDefs TEXT,
    ActiveTheme INTEGER,
    TimeStamp TEXT,
    IsPublic INTEGER,
    RestoreKey TEXT,
    RestoreTime TEXT
);

CREATE TABLE UsersRegs (
    ID INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    UserInfo TEXT,
    UserPass TEXT,
    AuthKey TEXT,
    TimeStamp TEXT
);

