TRUNCATE TABLE `#__users`;

INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, '2009-10-27 14:21:57', '2010-02-03 08:10:09', '', ''),
(63, 'gaurav', 'gaurav', 'gaurav@email.com', 'd196c605ecda097be3976226e37b209d:PFJeg6TYWwTpOY5xVvLXX2vrECTdIm6B', 'Registered', 0, 0, '2010-02-03 08:19:51', '2010-02-03 08:20:15', 'b51f5d5f4f2d416d34d9abd255fdccd7', '\n'),
(64, 'manish', 'manish', 'manish@email.com', 'bc0805d983baaefa3e68572518e058b8:tdoRDUcICfpslu050t12l2Ghc8PrYpbn', 'Registered', 1, 0, '2010-02-06 10:15:45', '0000-00-00 00:00:00', 'd43619c21bb2559f4ac4d419eb461587', '\n');
