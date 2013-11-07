TRUNCATE TABLE `#__community_photos`;
TRUNCATE TABLE `#__jspc_addons`;


INSERT INTO `#__community_photos` (`id`, `albumid`, `caption`, `published`, `creator`, `permissions`, `image`, `thumbnail`, `original`, `created`) VALUES
(1, 1, 'images.', 1, 63, '0', 'images/photos/63/1/3d801f1610ff323c609dcfdb.jpg', 'images/photos/63/1/thumb_3d801f1610ff323c609dcfdb.jpg', 'images/originalphotos/63/1/3d801f1610ff323c609dcfdb.jpg', '2010-06-03 04:23:55'),
(2, 1, 'images3.', 1, 63, '0', 'images/photos/63/1/d6f59b1080e4413c0c26cdf1.jpg', 'images/photos/63/1/thumb_d6f59b1080e4413c0c26cdf1.jpg', 'images/originalphotos/63/1/d6f59b1080e4413c0c26cdf1.jpg', '2010-06-03 04:23:55');


INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'sql', 'sql', 'jspc_core_total_contribution=100\njspc_core_display_text=Add photos\njspc_profiletype=0\n\n', 'sql_total=2\nsql_query=SELECT count(*) FROM `#__community_photos` WHERE `creator`=<<userid>>\nsql_url=index.php?option=com_community\n\n', 1);

