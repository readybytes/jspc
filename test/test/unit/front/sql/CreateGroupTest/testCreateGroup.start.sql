TRUNCATE TABLE `#__jspc_addons`;
TRUNCATE TABLE `#__community_groups`;
TRUNCATE TABLE `#__community_groups_members`;

INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'albums', 'Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Album\njspc_profiletype=0\n\n', 'album_total=8\n\n', 0),
(2, 'groupowner', 'Group', 'jspc_core_total_contribution=90\njspc_core_display_text=Group\njspc_profiletype=0\n\n', 'groupowner_total=8\n\n', 1),
(3, 'photos', 'Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Photos\njspc_profiletype=0\n\n', 'photo_total=9\n\n', 0),
(4, 'avatar', 'Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Avtar\njspc_profiletype=0\n\n', '\n', 0),
(5, 'groupmember', 'GroupMember', 'jspc_core_total_contribution=70\njspc_core_display_text=GroupMember\njspc_profiletype=0\n\n', 'groupmember_total=9\n\n', 0),
(6, 'videos', 'Videos', 'jspc_core_total_contribution=40\njspc_core_display_text=Videos\njspc_profiletype=0\n\n', 'video_total=6\n\n', 0),
(7, 'profilefields', 'Profile', 'jspc_core_total_contribution=80\njspc_core_display_text=Profile\njspc_profiletype=0\n\n', '2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=8\n\n', 0);

INSERT INTO `#__community_groups` (`id`, `published`, `ownerid`, `categoryid`, `name`, `description`, `email`, `website`, `approvals`, `created`, `avatar`, `thumb`, `discusscount`, `wallcount`, `membercount`, `params`) VALUES
(1, 1, 63, 4, 'group2', 'group2', '', '', 0, '2010-02-03 08:54:54', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(2, 1, 63, 4, 'group1', 'grroup1', '', '', 0, '2010-02-03 08:54:36', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(3, 1, 63, 4, 'group3', 'group3', '', '', 0, '2010-02-03 08:55:15', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(4, 1, 63, 4, 'group4', 'group4', '', '', 0, '2010-02-03 08:55:39', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n'),
(5, 1, 63, 4, 'group5', 'group5', '', '', 0, '2010-02-03 08:57:23', 'components/com_community/assets/group.jpg', 'components/com_community/assets/group_thumb.jpg', 0, 0, 1, 'discussordering=0\nphotopermission=0\nvideopermission=0\ngrouprecentphotos=6\ngrouprecentvideos=6\n\n');

INSERT INTO `#__community_groups_members` (`groupid`, `memberid`, `approved`, `permissions`) VALUES
(1, 63, 1, 1),
(2, 63, 1, 1),
(3, 63, 1, 1),
(4, 63, 1, 1),
(5, 63, 1, 1);
