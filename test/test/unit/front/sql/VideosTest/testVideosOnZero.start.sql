TRUNCATE TABLE `#__community_videos`;
TRUNCATE TABLE `#__community_videos_category`;
TRUNCATE TABLE `#__jspc_addons`;

INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'albums', 'Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Album\njspc_profiletype=0\n\n', 'albums_total=8\n\n', 0),
(2, 'groupowner', 'Group', 'jspc_core_total_contribution=90\njspc_core_display_text=Group\njspc_profiletype=0\n\n', 'groupowner_total=8\n\n', 0),
(3, 'photos', 'Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Photos\njspc_profiletype=0\n\n', 'photos_total=9\n\n', 0),
(4, 'avatar', 'Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Avtar\njspc_profiletype=0\n\n', '\n', 0),
(5, 'groupmember', 'GroupMember', 'jspc_core_total_contribution=70\njspc_core_display_text=GroupMember\njspc_profiletype=0\n\n', 'groupmember_total=9\n\n', 0),
(6, 'videos', 'Videos', 'jspc_core_total_contribution=40\njspc_core_display_text=Videos\njspc_profiletype=0\n\n', 'videos_total=6\n\n', 1),
(7, 'profilefields', 'Profile', 'jspc_core_total_contribution=80\njspc_core_display_text=Profile\njspc_profiletype=0\n\n', '2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=8\n\n', 0);

