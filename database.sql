Database name : eduvanz

Table code:

CREATE TABLE `tbl_participants` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(50) NOT NULL,
 `age` int(11) NOT NULL,
 `dob` date NOT NULL,
 `profession` varchar(100) NOT NULL,
 `locality` varchar(100) NOT NULL,
 `no_of_guests` int(11) NOT NULL,
 `address` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

API Collection link : https://www.getpostman.com/collections/876d6af475fca596d587