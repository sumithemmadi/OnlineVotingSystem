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


CREATE TABLE `events` ( 
    `event_id` INTEGER  NOT NULL AUTO_INCREMENT,
    `eventName` varchar(255) NOT NULL,
    `partyName1` varchar(255) NOT NULL, 
    `partyName2` varchar(255) NOT NULL, 
    `partyName3` varchar(255) NOT NULL, 
    `partyName4` varchar(255) NOT NULL, 
    primary key (event_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `vote` ( 
    `id` INTEGER  NOT NULL  AUTO_INCREMENT,
    `event_id` INTEGER  NOT NULL ,
    `voter_id` INTEGER  NOT NULL ,
    `username` varchar(255) NOT NULL,
    `voteParty` varchar(255) NOT NULL,
    `VoteDate` varchar(255) NOT NULL,
    primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;