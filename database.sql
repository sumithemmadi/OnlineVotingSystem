CREATE TABLE `candidates` ( 
    `voter_id` INTEGER  NOT NULL AUTO_INCREMENT,
    `firstname` varchar(255) NOT NULL,
    `lastname` varchar(255) NOT NULL, 
    `username` varchar(255) NOT NULL, 
    `email` varchar(255) NOT NULL, 
    `password` varchar(255) NOT NULL, 
    `gender` varchar(255) NOT NULL, 
    `dob` varchar(255) NOT NULL,
    primary key (voter_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;