CREATE TABLE IF NOT EXISTS `#__jspc_addons` (
 `id` int(21) NOT NULL AUTO_INCREMENT,
 `name` varchar(64) NOT NULL,
 `featurename` varchar(250) NOT NULL,
 `coreparams` text NOT NULL,
 `addonparams` text NOT NULL,
 `published` tinyint(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


/* inser some sample rules into database */
INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`)
VALUES
(1, 'albums', 'Create 8 Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Create %s Album\njspc_profiletype=0\n\n', 'albums_total=8\n\n', 1),
(2, 'groupowner', 'Create 5 Group', 'jspc_core_total_contribution=90\njspc_core_display_text=Create %s Group\njspc_profiletype=0\n\n', 'groupowner_total=5\n\n', 1),
(3, 'photos', 'Add 9 Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Add %s Photos\njspc_profiletype=0\n\n', 'photos_total=9\n\n', 1),
(4, 'avatar', 'Upload Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Upload Avtar\njspc_profiletype=0\n\n', '\n', 1),
(5, 'groupmember', 'Join 6 Group', 'jspc_core_total_contribution=70\njspc_core_display_text=Join %s Group\njspc_profiletype=0\n\n', 'groupmember_total=6\n\n', 1),
(6, 'videos', 'Upload 4 Videos', 'jspc_core_total_contribution=40\njspc_core_display_text=Upload %s Videos\njspc_profiletype=0\n\n', 'videos_total=4\n\n', 1),
(7, 'profilefields', 'Edit Profile', 'jspc_core_total_contribution=80\njspc_core_display_text=Edit Profile\njspc_profiletype=0\n\n', '2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=8\n\n', 1);
