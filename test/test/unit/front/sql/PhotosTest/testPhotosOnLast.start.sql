TRUNCATE TABLE `#__jspc_addons`;
TRUNCATE TABLE `#__community_photos`;
TRUNCATE TABLE `#__community_photos_albums`;

INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'albums', 'Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Album\njspc_profiletype=0\n\n', 'album_total=8\n\n', 0),
(2, 'groupowner', 'Group', 'jspc_core_total_contribution=90\njspc_core_display_text=Group\njspc_profiletype=0\n\n', 'groupowner_total=8\n\n', 0),
(3, 'photos', 'Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Photos\njspc_profiletype=0\n\n', 'photo_total=9\n\n', 1),
(4, 'avatar', 'Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Avtar\njspc_profiletype=0\n\n', '\n', 0),
(5, 'groupmember', 'GroupMember', 'jspc_core_total_contribution=70\njspc_core_display_text=GroupMember\njspc_profiletype=0\n\n', 'groupmember_total=9\n\n', 0),
(6, 'videos', 'Videos', 'jspc_core_total_contribution=40\njspc_core_display_text=Videos\njspc_profiletype=0\n\n', 'video_total=6\n\n', 0),
(7, 'profilefields', 'Profile', 'jspc_core_total_contribution=80\njspc_core_display_text=Profile\njspc_profiletype=0\n\n', '2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=8\n\n', 0);


INSERT INTO `#__community_photos` (`id`, `albumid`, `caption`, `published`, `creator`, `permissions`, `image`, `thumbnail`, `original`, `created`, `filesize`, `storage`) VALUES
(1, 1, '1264753804_intruder', 1, 63, '0', 'images/photos/63/1/dd32a3a9156f74b698e758ae.png', 'images/photos/63/1/thumb_dd32a3a9156f74b698e758ae.png', 'images/originalphotos/63/1/dd32a3a9156f74b698e758ae.png', '2010-02-03 11:23:24', 13077, 'file'),
(2, 1, 'icon-whitelist', 1, 63, '0', 'images/photos/63/2/8e66815fb925f199d303ac65.gif', 'images/photos/63/2/thumb_8e66815fb925f199d303ac65.gif', 'images/originalphotos/63/2/8e66815fb925f199d303ac65.gif', '2010-02-03 11:23:08', 3457, 'file'),
(3, 2, 'menu-icon-whitelist', 1, 63, '0', 'images/photos/63/2/28bf7e1791c8659886b1f9fd.png', 'images/photos/63/2/thumb_28bf7e1791c8659886b1f9fd.png', 'images/originalphotos/63/2/28bf7e1791c8659886b1f9fd.png', '2010-02-03 11:23:07', 14884, 'file'),
(4, 2, 'setup', 1, 63, '0', 'images/photos/63/2/b381d50df690d0c273e8c817.png', 'images/photos/63/2/thumb_b381d50df690d0c273e8c817.png', 'images/originalphotos/63/2/b381d50df690d0c273e8c817.png', '2010-02-03 11:23:07', 12028, 'file'),
(5, 3, '1264753804_intruder', 1, 63, '0', 'images/photos/63/1/dd32a3a9156f74b698e758ae.png', 'images/photos/63/1/thumb_dd32a3a9156f74b698e758ae.png', 'images/originalphotos/63/1/dd32a3a9156f74b698e758ae.png', '2010-02-03 11:23:24', 13077, 'file'),
(6, 3, 'icon-whitelist', 1, 63, '0', 'images/photos/63/2/8e66815fb925f199d303ac65.gif', 'images/photos/63/2/thumb_8e66815fb925f199d303ac65.gif', 'images/originalphotos/63/2/8e66815fb925f199d303ac65.gif', '2010-02-03 11:23:08', 3457, 'file'),
(7, 2, 'menu-icon-whitelist', 1, 63, '0', 'images/photos/63/2/28bf7e1791c8659886b1f9fd.png', 'images/photos/63/2/thumb_28bf7e1791c8659886b1f9fd.png', 'images/originalphotos/63/2/28bf7e1791c8659886b1f9fd.png', '2010-02-03 11:23:07', 14884, 'file'),
(8, 2, 'setup', 1, 63, '0', 'images/photos/63/2/b381d50df690d0c273e8c817.png', 'images/photos/63/2/thumb_b381d50df690d0c273e8c817.png', 'images/originalphotos/63/2/b381d50df690d0c273e8c817.png', '2010-02-03 11:23:07', 12028, 'file'),
(9, 3, 'setup', 1, 63, '0', 'images/photos/63/2/b381d50df690d0c273e8c817.png', 'images/photos/63/2/thumb_b381d50df690d0c273e8c817.png', 'images/originalphotos/63/2/b381d50df690d0c273e8c817.png', '2010-02-03 11:23:07', 12028, 'file');


INSERT INTO `#__community_photos_albums` (`id`, `photoid`, `creator`, `name`, `description`, `permissions`, `created`, `path`, `type`, `groupid`) VALUES
(1, 1, 63, 'album2', 'album2', '0', '2010-02-03 08:21:03', 'images/photos/75/13', 'user', 0),
(2, 4, 63, 'album3', 'album3', '0', '2010-02-03 08:21:32', 'images/photos/75/14', 'user', 0),
(3, 0, 63, 'album1', 'album1', '0', '2010-02-03 08:20:42', 'images/photos/75/12', 'user', 0);

