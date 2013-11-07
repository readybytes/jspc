TRUNCATE TABLE `#__jspc_addons`;
TRUNCATE TABLE `#__community_users`;

INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'events', 'create events', 'jspc_core_total_contribution=100\njspc_core_display_text=\njspc_profiletype=0\n\n', 'events_total=10\n\n', 0),
(2, 'profilevideo', 'profile video', 'jspc_core_total_contribution=5\njspc_core_display_text=\njspc_profiletype=0\n\n', '\n', 1),
(4, 'application', 'Add application', 'jspc_core_total_contribution=10\njspc_core_display_text=\njspc_profiletype=0\n\n', 'application_total=5\n\n', 0);

INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`, `alias`, `latitude`, `longitude`) VALUES
(62, '', 0, '0000-00-00 00:00:00', 'components/com_community/assets/default1.jpg', 'components/com_community/assets/default1_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=0\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\nprofileVideo=\n\n', 0, 0, '', 255, 255);

