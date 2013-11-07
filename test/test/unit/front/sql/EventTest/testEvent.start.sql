TRUNCATE TABLE `#__community_events`;
TRUNCATE TABLE `#__jspc_addons`;

INSERT INTO `#__community_events` (`id`, `catid`, `contentid`, `type`, `title`, `location`, `description`, `creator`, `startdate`, `enddate`, `permission`, `avatar`, `thumb`, `invitedcount`, `confirmedcount`, `declinedcount`, `maybecount`, `wallcount`, `ticket`, `allowinvite`, `created`, `hits`, `published`, `latitude`, `longitude`) VALUES
(1, 2, 0, 'profile', 'event1', 'india', '<p>fjlvmyh</p>', 62, '2011-01-24 09:00:00', '2011-01-24 21:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 10, 0, '2011-01-24 09:56:26', 0, 1, 20.5937, 78.9629),
(2, 2, 0, 'profile', 'event2', 'india', '<p>fjlvmyh</p>', 62, '2011-01-24 09:00:00', '2011-01-24 21:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 10, 0, '2011-01-24 09:56:26', 0, 1, 20.5937, 78.9629),
(3, 2, 0, 'profile', 'event3', 'india', '<p>fjlvmyh</p>', 62, '2011-01-24 09:00:00', '2011-01-24 21:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 10, 0, '2011-01-24 09:56:26', 0, 1, 20.5937, 78.9629),
(4, 2, 0, 'profile', 'event4', 'india', '<p>fjlvmyh</p>', 62, '2011-01-24 09:00:00', '2011-01-24 21:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 10, 0, '2011-01-24 09:56:26', 0, 1, 20.5937, 78.9629),
(5, 2, 0, 'profile', 'event5', 'india', '<p>fjlvmyh</p>', 62, '2011-01-24 09:00:00', '2011-01-24 21:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 10, 0, '2011-01-24 09:56:26', 0, 1, 20.5937, 78.9629);




INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'events', 'create events', 'jspc_core_total_contribution=100\njspc_core_display_text=\njspc_profiletype=0\n\n', 'events_total=10\n\n', 1),
(2, 'profilevideo', 'profile video', 'jspc_core_total_contribution=5\njspc_core_display_text=\njspc_profiletype=0\n\n', '\n', 0),
(4, 'application', 'Add application', 'jspc_core_total_contribution=10\njspc_core_display_text=\njspc_profiletype=0\n\n', 'application_total=5\n\n', 0);

