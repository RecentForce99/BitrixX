CREATE TABLE IF NOT EXISTS `y_emails` (
                    `ID` int(11) NOT NULL AUTO_INCREMENT,
                    `ADDRESSES_ID` int(11) NOT NULL,
                    `NAME` varchar(255) NOT NULL,
                    `EMAIL` varchar(255) NOT NULL,
                    PRIMARY KEY(`ID`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `y_addresses` (
                    `ID` int(11) NOT NULL AUTO_INCREMENT,
                    `COUNTRY` varchar(255) NOT NULL,
                    `ADDRESS` varchar(255) NOT NULL,
                    `PHONE_NUMBER` varchar(20) NOT NULL,
                    PRIMARY KEY(`ID`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;