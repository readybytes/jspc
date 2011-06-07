CREATE TABLE IF NOT EXISTS `#__jspc_addons` (
 `id` int(21) NOT NULL AUTO_INCREMENT,
 `name` varchar(64) NOT NULL,
 `featurename` varchar(250) NOT NULL,
 `coreparams` text NOT NULL,
 `addonparams` text NOT NULL,
 `published` tinyint(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
