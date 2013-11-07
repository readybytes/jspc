TRUNCATE TABLE `#__community_apps`;
TRUNCATE TABLE `#__jspc_addons`;

INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'events', 'create events', 'jspc_core_total_contribution=100\njspc_core_display_text=\njspc_profiletype=0\n\n', 'events_total=10\n\n', 0),
(2, 'profilevideo', 'profile video', 'jspc_core_total_contribution=5\njspc_core_display_text=\njspc_profiletype=0\n\n', '\n', 0),
(4, 'application', 'Add application', 'jspc_core_total_contribution=10\njspc_core_display_text=\njspc_profiletype=0\n\n', 'application_total=5\n\n', 1);


INSERT INTO `#__community_apps` (`id`, `userid`, `apps`, `ordering`, `params`, `privacy`, `position`) VALUES
(4, 62, 'apps1', 0, '', '', 'sidebar-top'),
(5, 62, 'apps2', 0, '', '', 'sidebar-top'),
(6, 62, 'apps3', 0, '', '', 'sidebar-top'),
(7, 62, 'apps4', 0, '', '', 'sidebar-top'),
(8, 62, 'apps5', 0, '', '', 'sidebar-top');
