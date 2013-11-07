TRUNCATE TABLE `#__jspc_addons`;
DROP TABLE IF EXISTS `au_#__jspc_addons`;
CREATE TABLE `au_#__jspc_addons` SELECT * FROM `#__jspc_addons`;

INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'albums', 'Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Add % Album\njspc_profiletype=0\n\n', 'albums_total=10\n\n', 0),
(2, 'groupmember', 'Group Member', 'jspc_core_total_contribution=100\njspc_core_display_text=%s Group Member\njspc_profiletype=0\n\n', 'groupmember_total=10\n\n', 0),
(3, 'profilefields', 'Profile', 'jspc_core_total_contribution=100\njspc_core_display_text=%s Profile\njspc_profiletype=0\n\n', '2=10\n3=10\n4=10\n5=10\n7=10\n8=10\n9=10\n10=10\n11=10\n12=10\n13=0\n15=0\n16=0\n\n', 0);

INSERT INTO `au_#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'albums', 'Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Add % Album\njspc_profiletype=0\n\n', 'albums_total=10\n\n', 0);

