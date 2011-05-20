TRUNCATE TABLE `#__jspc_addons`;
TRUNCATE TABLE `#__community_users`;
TRUNCATE TABLE `#__users`;
TRUNCATE TABLE `#__core_acl_aro`;

INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'albums', 'Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Album\njspc_profiletype=0\n\n', 'albums_total=8\n\n', 0),
(2, 'groupowner', 'Group', 'jspc_core_total_contribution=90\njspc_core_display_text=Group\njspc_profiletype=0\n\n', 'groupowner_total=8\n\n', 0),
(3, 'photos', 'Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Photos\njspc_profiletype=0\n\n', 'photos_total=9\n\n', 0),
(4, 'avatar', 'Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Avtar\njspc_profiletype=0\n\n', '\n', 1),
(5, 'groupmember', 'GroupMember', 'jspc_core_total_contribution=70\njspc_core_display_text=GroupMember\njspc_profiletype=0\n\n', 'groupmember_total=9\n\n', 0),
(6, 'videos', 'Videos', 'jspc_core_total_contribution=40\njspc_core_display_text=Videos\njspc_profiletype=0\n\n', 'videos_total=6\n\n', 0),
(7, 'profilefields', 'Profile', 'jspc_core_total_contribution=80\njspc_core_display_text=Profile\njspc_profiletype=0\n\n', '2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=8\n\n', 0);

INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n', 1, 0),
(63, '', 5, '0000-00-00 00:00:00', 'images/avatar/a442178bd1f81ca97429c37a.png', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(64, '', 2, '0000-00-00 00:00:00', 'images/avatar/a442178bd1f81ca97429c37a.png', 'images/avatar/thumb_a442178bd1f81ca97429c37a.png', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0);

INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2010-02-03 08:10:09', '', ''),
(63, 'gaurav', 'gaurav', 'gaurav@email.com', 'd196c605ecda097be3976226e37b209d:PFJeg6TYWwTpOY5xVvLXX2vrECTdIm6B', 'Registered', 0, 0, 18, '2010-02-03 08:19:51', '2011-05-20 11:10:49', 'b51f5d5f4f2d416d34d9abd255fdccd7', '\n'),
(64, 'manish', 'manish', 'manish@email.com', 'bc0805d983baaefa3e68572518e058b8:tdoRDUcICfpslu050t12l2Ghc8PrYpbn', 'Registered', 1, 0, 18, '2010-02-06 10:15:45', '0000-00-00 00:00:00', 'd43619c21bb2559f4ac4d419eb461587', '\n');

INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(23, 'users', '63', 0, 'gaurav', 0),
(24, 'users', '64', 0, 'manish', 0);
