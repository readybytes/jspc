/* xipt_users */
TRUNCATE TABLE `#__xipt_users`;
INSERT INTO `#__xipt_users` (`userid`, `profiletype`, `template`) VALUES
(62, 1, 'default'),
(66, 2, 'default'),
(67, 3, 'default'),
(68, 4, 'default'),
(69, 5, 'default'),
(70, 1, 'default');

/* xipt_profiletypes */
TRUNCATE TABLE `#__xipt_profiletypes`;
INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`) VALUES
(1, 'Director', 1, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', ''),
(2, 'Manager', 2, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', ''),
(3, 'Teacher', 3, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', ''),
(4, 'Student', 4, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', ''),
(5, 'Parents', 5, 1, '', 'friends', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, 0, '', '');


/* xipt_profilefields */
TRUNCATE TABLE `#__xipt_profilefields`;
INSERT INTO `#__xipt_profilefields` (`id`, `fid`, `pid`) VALUES
(1, 18, 2),
(2, 18, 4),
(3, 2, 5),
(4, 5, 1),
(5, 5, 2),
(6, 5, 3),
(7, 5, 5),
(8, 8, 3),
(9, 8, 4),
(10, 8, 5),
(11, 13, 3),
(12, 13, 4),
(13, 13, 5),
(14, 16, 1),
(15, 16, 2),
(16, 11, 1),
(17, 11, 2),
(18, 11, 4),
(19, 11, 5);


/* jspc_addons */
TRUNCATE TABLE `#__jspc_addons`;
INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'albums', 'Album1', 'jspc_core_total_contribution=100\njspc_core_display_text=Add %s Album\njspc_profiletype=1\n\n', 'albums_total=8\n\n', 1),
(2, 'groupowner', 'Group1', 'jspc_core_total_contribution=90\njspc_core_display_text=Create %s Group\njspc_profiletype=5\n\n', 'groupowner_total=8\n\n', 1),
(3, 'photos', 'Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Upload %s Photos\njspc_profiletype=0\n\n', 'photos_total=9\n\n', 1),
(4, 'avatar', 'Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Upload Avtar\njspc_profiletype=0\n\n', '\n', 1),
(5, 'groupmember', 'GroupMember', 'jspc_core_total_contribution=70\njspc_core_display_text=Join %s Group\njspc_profiletype=4\n\n', 'groupmember_total=9\n\n', 1),
(6, 'videos', 'Videos', 'jspc_core_total_contribution=40\njspc_core_display_text=Add %s Videos\njspc_profiletype=0\n\n', 'videos_total=6\n\n', 1),
(7, 'profilefields', 'Profile', 'jspc_core_total_contribution=80\njspc_core_display_text=Complete %s Profile Fields\njspc_profiletype=3\n\n', '18=0\n17=0\n2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=8\n\n', 1),
(8, 'albums', 'Album2', 'jspc_core_total_contribution=60\njspc_core_display_text=Add %s Album2\njspc_profiletype=0\n\n', 'albums_total=6\n\n', 1),
(9, 'groupowner', 'Group2', 'jspc_core_total_contribution=90\njspc_core_display_text=Create %s Group2\njspc_profiletype=2\n\n', 'groupowner_total=4\n\n', 1);


/* community_videos */
TRUNCATE TABLE `#__community_videos`;
INSERT INTO `#__community_videos` (`id`, `title`, `type`, `video_id`, `description`, `creator`, `creator_type`, `created`, `permissions`, `category_id`, `hits`, `published`, `featured`, `duration`, `status`, `thumb`, `path`, `groupid`, `filesize`, `storage`) VALUES
(5, 'Karthik Calling Karthik- Theatrical Trailer Exclusive!!!', 'youtube', 'dIZ2OwW7HJU', 'Theatrical Trailer of Karthik Calling Karthik\nDirected by Vijay Lalwani\nProduced by Farhan Akhtar and Ritesh Sidhwani\nAssociate Producers- Vijay Lalwani and Amit Chandrra', 70, 'user', '2010-02-13 04:54:03', '0', 1, 0, 1, 0, 146, 'ready', 'images/videos/70/thumbs/FiI4AdqVD4D.jpg', 'http://www.youtube.com/watch?v=dIZ2OwW7HJU&feature=dir', 0, 0, 'file'),
(4, 'WWE RAW 2110 PART 1111', 'youtube', 'pcrfPhm-ZDc', 'WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110', 70, 'user', '2010-02-13 04:53:41', '0', 1, 0, 1, 0, 620, 'ready', 'images/videos/70/thumbs/9rUGITTYB7s.jpg', 'http://www.youtube.com/watch?v=pcrfPhm-ZDc&feature=popular', 0, 0, 'file'),
(7, 'DLF IPL 2010 - IPL 3 Back In India - Sachin Tendulkar from the Mumbai Indians Team', 'youtube', 'SaswpMvUR4M', 'Sachin Tendulkar Captain of the IPL 3 Mumbai Indians Team - IPL 2010', 67, 'user', '2010-02-13 05:00:09', '0', 1, 0, 1, 0, 26, 'ready', 'images/videos/67/thumbs/psqrhDMQn0h.jpg', 'http://www.youtube.com/watch?v=SaswpMvUR4M&feature=fvhl', 0, 0, 'file'),
(8, 'DLF IPL 2010 - IPL 3 Back In India - Gautam Gambhir from the Delhi Daredevils Team', 'youtube', 'j6rv9_NUQH0', 'Gautam Gambhir Captain of the IPL 3 Delhi Daredevils Team - IPL 2010', 67, 'user', '2010-02-13 05:00:27', '0', 1, 0, 1, 0, 25, 'ready', 'images/videos/67/thumbs/g30ssOq20w6.jpg', 'http://www.youtube.com/watch?v=j6rv9_NUQH0&feature=SeriesPlayList&p=225B4D0F63986D47', 0, 0, 'file'),
(9, 'DLF IPL 2010 - IPL 3 Back In India - Anil Kumble from the Royal Challengers Bangalore Team', 'youtube', 'S21W42s4nTw', 'Anil Kumble Captain of the IPL 3 Royal Challengers Bangalore Team - IPL 2010', 67, 'user', '2010-02-13 05:01:20', '0', 1, 0, 1, 0, 25, 'ready', 'images/videos/67/thumbs/vYYIHCHGpva.jpg', 'http://www.youtube.com/watch?v=S21W42s4nTw&feature=SeriesPlayList&p=225B4D0F63986D47', 0, 0, 'file'),
(10, 'Funny IPL Ad', 'youtube', 'kTtZJ0NZhBc', 'funny ipl ad with andrew symonds', 67, 'user', '2010-02-13 05:01:57', '0', 1, 0, 1, 0, 30, 'ready', 'images/videos/67/thumbs/0cmYF9Fhgw2.jpg', 'http://www.youtube.com/watch?v=kTtZJ0NZhBc&feature=related', 0, 0, 'file'),
(11, 'An invite to IPL 2010', 'youtube', 'o6RP5UeuOnc', 'The grandest T20 tournament is back in India. Get Ready...', 69, 'user', '2010-02-13 05:14:12', '0', 1, 0, 1, 0, 242, 'ready', 'images/videos/69/thumbs/vv49HCHNxwG.jpg', 'http://www.youtube.com/watch?v=o6RP5UeuOnc&feature=related', 0, 0, 'file'),
(12, 'IPL 2008 Super Spell: Shoaib Akhtar', 'youtube', 'MiZhDdLAaqs', 'KKR''s Shoaib Akhtar demolishes Delhi Daredevils in IPL 2008.', 69, 'user', '2010-02-13 05:14:43', '0', 1, 0, 1, 0, 92, 'ready', 'images/videos/69/thumbs/a7vsXe5JzWg.jpg', 'http://www.youtube.com/watch?v=MiZhDdLAaqs&feature=related', 0, 0, 'file'),
(13, 'IPL 2008 Top Partnerships: Sachin-Sanath show', 'youtube', 'V-xRf4IkpqA', 'Tendulkar and Jayasuriya''s 96-run partnership for Mumbai Indians vs Royal Challengers Bangalore in IPL 2008', 69, 'user', '2010-02-13 05:15:22', '0', 1, 0, 1, 0, 161, 'ready', 'images/videos/69/thumbs/SaF5D6sjY1B.jpg', 'http://www.youtube.com/watch?v=V-xRf4IkpqA&feature=related', 0, 0, 'file');


/* community_users */
TRUNCATE TABLE `#__community_users`;
INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n', 1, 0),
(70, '', 5, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(66, '', 17, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(67, '', 7, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(68, '', 13, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(69, '', 21, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0);


/* community_photos_albums */
TRUNCATE TABLE `#__community_photos_albums`;
INSERT INTO `#__community_photos_albums` (`id`, `photoid`, `creator`, `name`, `description`, `permissions`, `created`, `path`, `type`, `groupid`) VALUES
(4, 0, 68, 'student album 3', 'student album 3', '0', '2010-02-12 13:16:02', 'images/photos/68/4', 'user', 0),
(3, 5, 68, 'student album 1', 'student album 1', '0', '2010-02-12 13:14:47', 'images/photos/68/3', 'user', 0),
(5, 11, 70, 'Director Album 1', 'Director Album 2', '0', '2010-02-13 04:51:10', 'images/photos/70/5', 'user', 0),
(6, 10, 70, 'Director Album 2', 'Director Album 2', '0', '2010-02-13 04:51:25', 'images/photos/70/6', 'user', 0),
(7, 9, 70, 'Director Album 3', 'Director Album 3', '0', '2010-02-13 04:51:42', 'images/photos/70/7', 'user', 0),
(8, 0, 67, 'Teacher Album 1', 'Teacher Album 1', '0', '2010-02-13 04:58:19', 'images/photos/67/8', 'user', 0),
(9, 0, 67, 'Teacher Album 2', 'Teacher Album 2', '0', '2010-02-13 04:58:32', 'images/photos/67/9', 'user', 0),
(10, 0, 67, 'Teacher Album 3', 'Teacher Album 3', '0', '2010-02-13 04:58:47', 'images/photos/67/10', 'user', 0),
(11, 16, 67, 'Teacher Album 4', 'Teacher Album 4', '0', '2010-02-13 04:58:58', 'images/photos/67/11', 'user', 0),
(12, 12, 67, 'Teacher Album 5', 'Teacher Album 5', '0', '2010-02-13 04:59:15', 'images/photos/67/12', 'user', 0),
(13, 17, 66, 'Manager Album 1', 'Manager Album 1', '0', '2010-02-13 05:05:09', 'images/photos/66/13', 'user', 0),
(14, 0, 66, 'Manager Album 2', 'Manager Album 2', '0', '2010-02-13 05:05:21', 'images/photos/66/14', 'user', 0),
(15, 0, 66, 'Manager Album 3', 'Manager Album 3', '0', '2010-02-13 05:05:40', 'images/photos/66/15', 'user', 0),
(17, 0, 69, 'Parents Album 1', 'Parents Album 1', '0', '2010-02-13 05:11:49', 'images/photos/69/17', 'user', 0),
(18, 24, 69, 'Parents Album 2', 'Parents Album 2', '0', '2010-02-13 05:12:00', 'images/photos/69/18', 'user', 0),
(19, 19, 69, 'Parents Album 3', 'Parents Album 3', '0', '2010-02-13 05:12:12', 'images/photos/69/19', 'user', 0);


/* community_photos */
TRUNCATE TABLE `#__community_photos`;
INSERT INTO `#__community_photos` (`id`, `albumid`, `caption`, `published`, `creator`, `permissions`, `image`, `thumbnail`, `original`, `created`, `filesize`, `storage`) VALUES
(8, 3, 'manu-icon-blacklist', 1, 68, '0', 'images/photos/68/3/0bc8a51a8af4ca96d604839a.png', 'images/photos/68/3/thumb_0bc8a51a8af4ca96d604839a.png', 'images/originalphotos/68/3/0bc8a51a8af4ca96d604839a.png', '2010-02-12 13:19:02', 13472, 'file'),
(7, 3, 'menu-icon-blacklist', 1, 68, '0', 'images/photos/68/3/3942a14265cfc4e66b69ffde.png', 'images/photos/68/3/thumb_3942a14265cfc4e66b69ffde.png', 'images/originalphotos/68/3/3942a14265cfc4e66b69ffde.png', '2010-02-12 13:18:48', 941, 'file'),
(6, 3, 'manu-icon-blacklist', 1, 68, '0', 'images/photos/68/3/6a0a4ebba6ed933d56b99ad2.png', 'images/photos/68/3/thumb_6a0a4ebba6ed933d56b99ad2.png', 'images/originalphotos/68/3/6a0a4ebba6ed933d56b99ad2.png', '2010-02-12 13:18:08', 13472, 'file'),
(5, 3, 'menu-icon-whitelist', 1, 68, '0', 'images/photos/68/3/65368914e4fe3791514208cd.png', 'images/photos/68/3/thumb_65368914e4fe3791514208cd.png', 'images/originalphotos/68/3/65368914e4fe3791514208cd.png', '2010-02-12 13:15:17', 14884, 'file'),
(9, 7, '1264753804_intruder', 1, 70, '0', 'images/photos/70/7/a4762cbc51f2da34cd47f809.png', 'images/photos/70/7/thumb_a4762cbc51f2da34cd47f809.png', 'images/originalphotos/70/7/a4762cbc51f2da34cd47f809.png', '2010-02-13 04:55:39', 13077, 'file'),
(10, 6, 'menu-icon-whitelist', 1, 70, '0', 'images/photos/70/6/e9bbff5a3e9278da2da19fa0.png', 'images/photos/70/6/thumb_e9bbff5a3e9278da2da19fa0.png', 'images/originalphotos/70/6/e9bbff5a3e9278da2da19fa0.png', '2010-02-13 04:56:33', 14884, 'file'),
(11, 5, '1264753715_network_unlock', 1, 70, '0', 'images/photos/70/5/bb5e888f47ca7ad4f44100e5.png', 'images/photos/70/5/thumb_bb5e888f47ca7ad4f44100e5.png', 'images/originalphotos/70/5/bb5e888f47ca7ad4f44100e5.png', '2010-02-13 04:56:49', 21112, 'file'),
(12, 12, 'icon-updates', 1, 67, '0', 'images/photos/67/12/4d9646f3425ebd0041b8b203.gif', 'images/photos/67/12/thumb_4d9646f3425ebd0041b8b203.gif', 'images/originalphotos/67/12/4d9646f3425ebd0041b8b203.gif', '2010-02-13 05:02:23', 11996, 'file'),
(13, 12, 'icon-updates', 1, 67, '0', 'images/photos/67/12/9a2b3c091d4b2ab062fcbc56.png', 'images/photos/67/12/thumb_9a2b3c091d4b2ab062fcbc56.png', 'images/originalphotos/67/12/9a2b3c091d4b2ab062fcbc56.png', '2010-02-13 05:02:32', 7742, 'file'),
(14, 12, 'icon-updates', 1, 67, '0', 'images/photos/67/12/30e6719b21d9ec300f567d06.png', 'images/photos/67/12/thumb_30e6719b21d9ec300f567d06.png', 'images/originalphotos/67/12/30e6719b21d9ec300f567d06.png', '2010-02-13 05:02:36', 7742, 'file'),
(15, 12, '1264753715_network_unlock', 1, 67, '0', 'images/photos/67/12/ed4bb48a85785214c2b0f9c4.png', 'images/photos/67/12/thumb_ed4bb48a85785214c2b0f9c4.png', 'images/originalphotos/67/12/ed4bb48a85785214c2b0f9c4.png', '2010-02-13 05:02:48', 21112, 'file'),
(16, 11, 'features_icon13[1]', 1, 67, '0', 'images/photos/67/11/05da694944328ee3defc6d76.jpg', 'images/photos/67/11/thumb_05da694944328ee3defc6d76.jpg', 'images/originalphotos/67/11/05da694944328ee3defc6d76.jpg', '2010-02-13 05:03:04', 1212, 'file'),
(17, 13, 'menu-icon-blacklist', 1, 66, '0', 'images/photos/66/13/d441948e98db5d78aa57f767.png', 'images/photos/66/13/thumb_d441948e98db5d78aa57f767.png', 'images/originalphotos/66/13/d441948e98db5d78aa57f767.png', '2010-02-13 05:06:17', 941, 'file'),
(18, 13, 'manu-icon-blacklist', 1, 66, '0', 'images/photos/66/13/a86a79e13fbf4b0f7e970139.png', 'images/photos/66/13/thumb_a86a79e13fbf4b0f7e970139.png', 'images/originalphotos/66/13/a86a79e13fbf4b0f7e970139.png', '2010-02-13 05:06:17', 13472, 'file'),
(19, 19, 'setup', 1, 69, '0', 'images/photos/69/19/b4409d38575def2ed5e5586e.png', 'images/photos/69/19/thumb_b4409d38575def2ed5e5586e.png', 'images/originalphotos/69/19/b4409d38575def2ed5e5586e.png', '2010-02-13 05:12:43', 12028, 'file'),
(20, 19, 'menu-icon-whitelist', 1, 69, '0', 'images/photos/69/19/4e37a0d366b5951efaabbd9c.png', 'images/photos/69/19/thumb_4e37a0d366b5951efaabbd9c.png', 'images/originalphotos/69/19/4e37a0d366b5951efaabbd9c.png', '2010-02-13 05:12:43', 14884, 'file'),
(21, 19, 'menu-icon-blacklist', 1, 69, '0', 'images/photos/69/19/147b9664ffe263fe05994fe0.png', 'images/photos/69/19/thumb_147b9664ffe263fe05994fe0.png', 'images/originalphotos/69/19/147b9664ffe263fe05994fe0.png', '2010-02-13 05:12:43', 941, 'file'),
(22, 19, 'manu-icon-blacklist', 1, 69, '0', 'images/photos/69/19/9083b8a7620d3eb79afef68c.png', 'images/photos/69/19/thumb_9083b8a7620d3eb79afef68c.png', 'images/originalphotos/69/19/9083b8a7620d3eb79afef68c.png', '2010-02-13 05:12:44', 13472, 'file'),
(23, 19, 'icon-whitelist', 1, 69, '0', 'images/photos/69/19/976463376cdeba209e5bd085.gif', 'images/photos/69/19/thumb_976463376cdeba209e5bd085.gif', 'images/originalphotos/69/19/976463376cdeba209e5bd085.gif', '2010-02-13 05:12:44', 3457, 'file'),
(24, 18, 'icon-updates', 1, 69, '0', 'images/photos/69/18/6bf52f0b069b4d3cc52b4304.png', 'images/photos/69/18/thumb_6bf52f0b069b4d3cc52b4304.png', 'images/originalphotos/69/18/6bf52f0b069b4d3cc52b4304.png', '2010-02-13 05:13:01', 7742, 'file'),
(25, 18, 'icon-updates', 1, 69, '0', 'images/photos/69/18/c69e510afc78e0a92909cc14.gif', 'images/photos/69/18/thumb_c69e510afc78e0a92909cc14.gif', 'images/originalphotos/69/18/c69e510afc78e0a92909cc14.gif', '2010-02-13 05:13:01', 11996, 'file'),
(26, 18, '1264753804_intruder', 1, 69, '0', 'images/photos/69/18/242172a9e6d0a0f451a6547c.png', 'images/photos/69/18/thumb_242172a9e6d0a0f451a6547c.png', 'images/originalphotos/69/18/242172a9e6d0a0f451a6547c.png', '2010-02-13 05:13:01', 13077, 'file');



/* community_groups_members */
TRUNCATE TABLE `#__community_groups_members`;
INSERT INTO `#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(12, 66, 1, 1),
(11, 66, 1, 1),
(10, 66, 1, 1),
(9, 68, 1, 1),
(8, 68, 1, 1),
(6, 62, 1, 1),
(7, 68, 1, 1),
(13, 66, 1, 1),
(14, 69, 1, 1),
(15, 69, 1, 1),
(16, 69, 1, 1),
(17, 69, 1, 1),
(18, 69, 1, 1);


/* community_groups */
TRUNCATE TABLE `#__community_groups`;

INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`, `params`) VALUES
(11, 1, 66, 4, 'Manager group 2', 'Manager group 2', '', '', 0, '2010-02-13 05:04:13', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(10, 1, 66, 4, 'Manager group 1', 'Manager group 1', '', '', 0, '2010-02-13 05:04:00', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(9, 1, 68, 4, 'student gaurav 3', 'student gaurav 3', '', '', 0, '2010-02-12 13:12:20', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(8, 1, 68, 4, 'student gaurav 2', 'student gaurav 2', '', '', 0, '2010-02-12 13:12:03', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(7, 1, 68, 4, 'student group 1', 'student gaurav 1', '', '', 0, '2010-02-12 13:11:51', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(6, 1, 62, 4, 'admins', 'admins group', '', '', 0, '2010-02-04 10:31:19', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 2, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(12, 1, 66, 4, 'Manager group 3', 'Manager group 3', '', '', 0, '2010-02-13 05:04:24', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(13, 1, 66, 4, 'Manager group 4', 'Manager group 4', '', '', 0, '2010-02-13 05:04:34', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(14, 1, 69, 4, 'Parents Group 1', 'Parents Group 1', '', '', 0, '2010-02-13 05:07:29', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(15, 1, 69, 4, 'Parents Group 2', 'Parents Group 2', '', '', 0, '2010-02-13 05:07:46', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(16, 1, 69, 4, 'Parents Group 3', 'Parents Group 3', '', '', 0, '2010-02-13 05:07:57', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(17, 1, 69, 4, 'Parents Group 4', 'Parents Group 4', '', '', 0, '2010-02-13 05:08:12', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(18, 1, 69, 4, 'Parents Group 5', 'Parents Group 5', '', '', 0, '2010-02-13 05:11:26', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n');


/* community_fields_values */
TRUNCATE TABLE `#__community_fields_values`;

INSERT INTO `#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(89, 70, 15, 'fkh'),
(88, 70, 13, 'fkh'),
(87, 70, 12, 'American Samoa'),
(86, 70, 10, 'fkh'),
(85, 70, 9, 'kd'),
(84, 70, 8, 'khf'),
(83, 70, 7, 'hfhfd'),
(82, 70, 4, 'jdf'),
(81, 70, 3, '1967-3-1 23:59:59'),
(14, 62, 17, 'default'),
(15, 62, 18, '1'),
(80, 70, 2, 'Male'),
(79, 70, 18, '1'),
(78, 70, 17, 'bubble'),
(32, 66, 17, 'blueface'),
(33, 66, 18, '2'),
(34, 66, 2, 'Male'),
(35, 66, 3, '1984-2-19 23:59:59'),
(36, 66, 4, 'jdjhd'),
(37, 66, 7, ''),
(38, 66, 8, ''),
(39, 66, 9, 'jhdjhd'),
(40, 66, 10, 'jhd'),
(41, 66, 12, 'Algeria'),
(42, 66, 13, 'kjfkjf'),
(43, 66, 15, 'fg'),
(44, 67, 17, 'bubble'),
(45, 67, 18, '3'),
(46, 67, 2, 'Male'),
(47, 67, 3, '1990-9-11 23:59:59'),
(48, 67, 4, 'cdhdf'),
(49, 67, 7, 'd'),
(50, 67, 9, 'jd'),
(51, 67, 10, 'jhd'),
(52, 67, 11, 'hd'),
(53, 67, 12, 'Anguilla'),
(54, 67, 15, 'jhd'),
(55, 67, 16, 'dfhgf'),
(56, 68, 17, 'blackout'),
(57, 68, 18, '4'),
(58, 68, 2, 'Male'),
(59, 68, 3, '1960-7-27 23:59:59'),
(60, 68, 4, 'kjfgkurf'),
(61, 68, 5, 'kjfydf'),
(62, 68, 7, 'hd'),
(63, 68, 9, 'hd'),
(64, 68, 10, 'jdh'),
(65, 68, 12, 'Albania'),
(66, 68, 15, 'djhd'),
(67, 68, 16, 'hskdgh'),
(68, 69, 17, 'default'),
(69, 69, 18, '5'),
(70, 69, 3, '1984-11-18 23:59:59'),
(71, 69, 4, 'dnfjf'),
(72, 69, 7, 'jhgdjh'),
(73, 69, 9, 'dj'),
(74, 69, 10, 'hdjhd'),
(75, 69, 12, 'Albania'),
(76, 69, 15, 'kjgkj'),
(77, 69, 16, 'gkjgkg');


/* Communiy fields */
TRUNCATE TABLE `#__community_fields`;

INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 1, 1, 1, '', ''),
(2, 'select', 4, 1, 10, 100, 'Gender', 'Select gender', 1, 1, 1, 1, 'Male\nFemale', 'FIELD_GENDER'),
(3, 'date', 5, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 1, 1, 1, '', 'FIELD_BIRTHDAY'),
(4, 'text', 6, 1, 5, 250, 'Hometown', 'Hometown', 1, 1, 1, 1, '', 'FIELD_HOMETOWN'),
(5, 'textarea', 7, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 1, 1, 1, '', 'FIELD_ABOUTME'),
(6, 'group', 8, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 1, 1, 1, '', ''),
(7, 'text', 9, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_MOBILE'),
(8, 'text', 10, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_LANDPHONE'),
(9, 'textarea', 11, 1, 10, 100, 'Address', 'Address', 1, 1, 1, 1, '', 'FIELD_ADDRESS'),
(10, 'text', 12, 1, 10, 100, 'State', 'State', 1, 1, 1, 1, '', 'FIELD_STATE'),
(11, 'text', 13, 1, 10, 100, 'City / Town', 'City / Town', 1, 1, 1, 1, '', 'FIELD_CITY'),
(12, 'select', 14, 1, 10, 100, 'Country', 'Country', 1, 1, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba', 'FIELD_COUNTRY'),
(13, 'text', 15, 1, 10, 100, 'Website', 'Website', 1, 1, 1, 1, '', 'FIELD_WEBSITE'),
(14, 'group', 16, 1, 10, 100, 'Education', 'Educations', 1, 1, 1, 1, '', ''),
(15, 'text', 17, 1, 10, 200, 'College / University', 'College / University', 1, 1, 1, 1, '', 'FIELD_COLLEGE'),
(16, 'text', 18, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 1, 1, 1, '', 'FIELD_GRADUATION'),
(17, 'templates', 3, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, 1, '', 'XIPT_TEMPLATE'),
(18, 'profiletypes', 2, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, 1, '', 'XIPT_PROFILETYPE');

