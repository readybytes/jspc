TRUNCATE TABLE `#__jspc_addons`;
TRUNCATE TABLE `#__community_groups`;
TRUNCATE TABLE `#__community_groups_members`;
TRUNCATE TABLE `#__community_photos_albums`;
TRUNCATE TABLE `#__community_photos`;


INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'albums', 'Album1', 'jspc_core_total_contribution=100\njspc_core_display_text=Add %s Album\njspc_profiletype=0\n\n', 'albums_total=8\n\n', 1),
(2, 'groupowner', 'Group1', 'jspc_core_total_contribution=90\njspc_core_display_text=Create %s Group\njspc_profiletype=0\n\n', 'groupowner_total=8\n\n', 1),
(3, 'photos', 'Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Upload %s Photos\njspc_profiletype=0\n\n', 'photos_total=9\n\n', 0),
(4, 'avatar', 'Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Upload Avtar\njspc_profiletype=0\n\n', '\n', 0),
(5, 'groupmember', 'GroupMember', 'jspc_core_total_contribution=70\njspc_core_display_text=Join %s Group\njspc_profiletype=0\n\n', 'groupmember_total=9\n\n', 1),
(6, 'videos', 'Videos', 'jspc_core_total_contribution=40\njspc_core_display_text=Add %s Videos\njspc_profiletype=0\n\n', 'videos_total=6\n\n', 0),
(7, 'profilefields', 'Profile', 'jspc_core_total_contribution=80\njspc_core_display_text=Complete %s Profile Fields\njspc_profiletype=0\n\n', '2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=8\n\n', 0),
(8, 'albums', 'Album2', 'jspc_core_total_contribution=60\njspc_core_display_text=Add %s Album2\njspc_profiletype=0\n\n', 'albums_total=6\n\n', 1),
(9, 'groupowner', 'Group2', 'jspc_core_total_contribution=90\njspc_core_display_text=Create %s Group2\njspc_profiletype=0\n\n', 'groupowner_total=4\n\n', 1),
(10, 'sql', 'sql', 'jspc_core_total_contribution=100\njspc_core_display_text=Add % sql photos\njspc_profiletype=0\n\n', 'sql_total=4\nsql_query=SELECT count(*) FROM `#__community_photos` WHERE `creator`=<<userid>>\nsql_url=index.php?option=com_community\n\n', 1);


INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`, `params`) VALUES
(1, 1, 63, 4, 'group2', 'group2', '', '', 0, '2010-02-03 08:54:54', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(2, 1, 63, 4, 'group1', 'grroup1', '', '', 0, '2010-02-03 08:54:36', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(3, 1, 63, 4, 'group3', 'group3', '', '', 0, '2010-02-03 08:55:15', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(4, 1, 63, 4, 'group4', 'group4', '', '', 0, '2010-02-03 08:55:39', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(5, 1, 63, 4, 'group5', 'group5', '', '', 0, '2010-02-03 08:57:23', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(6, 1, 62, 4, 'admins', 'admins group', '', '', 0, '2010-02-04 10:31:19', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 2, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n');

INSERT INTO `#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(1, 63, 1, 1),
(2, 63, 1, 1),
(3, 63, 1, 1),
(4, 63, 1, 1),
(5, 63, 1, 1),
(6, 62, 1, 1),
(6, 63, 1, 0);

INSERT INTO `#__community_photos_albums` (`id`, `photoid`, `creator`, `name`, `description`, `permissions`, `created`, `path`, `type`, `groupid`) VALUES
(1, 0, 63, 'album2', 'album1', '0', '2010-02-03 08:21:03', 'images/photos/75/13', 'user', 0),
(2, 0, 63, 'album3', 'album2', '0', '2010-02-03 08:21:32', 'images/photos/75/14', 'user', 0);

INSERT INTO `#__community_photos` (`id`, `albumid`, `caption`, `published`, `creator`, `permissions`, `image`, `thumbnail`, `original`, `created`) VALUES
(1, 1, 'images.', 1, 63, '0', 'images/photos/63/1/3d801f1610ff323c609dcfdb.jpg', 'images/photos/63/1/thumb_3d801f1610ff323c609dcfdb.jpg', 'images/originalphotos/63/1/3d801f1610ff323c609dcfdb.jpg', '2010-06-03 04:23:55'),
(2, 1, 'images3.', 1, 63, '0', 'images/photos/63/1/d6f59b1080e4413c0c26cdf1.jpg', 'images/photos/63/1/thumb_d6f59b1080e4413c0c26cdf1.jpg', 'images/originalphotos/63/1/d6f59b1080e4413c0c26cdf1.jpg', '2010-06-03 04:23:55');


