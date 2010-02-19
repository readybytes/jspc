TRUNCATE TABLE `#__community_fields_values`;
TRUNCATE TABLE `#__jspc_addons`;
TRUNCATE TABLE `#__community_videos`;
TRUNCATE TABLE `#__community_videos_category`;

TRUNCATE TABLE `#__community_fields`;

/* add data into community_fields table */
INSERT INTO `#__community_fields`(`id`,`type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) 
VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 1, 1, 1, '', ''),
(2, 'select', 2, 1, 10, 100, 'Gender', 'Select gender', 1, 1, 1, 1, 'Male\nFemale', 'FIELD_GENDER'),
(3, 'date', 3, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 1, 1, 1, '', 'FIELD_BIRTHDAY'),
(4, 'text', 4, 1, 5, 250, 'Hometown', 'Hometown', 1, 1, 1, 1, '', 'FIELD_HOMETOWN'),
(5, 'textarea', 5, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 1, 1, 1, '', 'FIELD_ABOUTME'),
(6, 'group', 6, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 1, 1, 1, '', ''),
(7, 'text', 7, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_MOBILE'),
(8, 'text', 8, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_LANDPHONE'),
(9, 'textarea', 9, 1, 10, 100, 'Address', 'Address', 1, 1, 1, 1, '', 'FIELD_ADDRESS'),
(10, 'text', 10, 1, 10, 100, 'State', 'State', 1, 1, 1, 1, '', 'FIELD_STATE'),
(11, 'text', 11, 1, 10, 100, 'City / Town', 'City / Town', 1, 1, 1, 1, '', 'FIELD_CITY'),
(12, 'select', 12, 1, 10, 100, 'Country', 'Country', 1, 1, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba', 'FIELD_COUNTRY'),
(13, 'text', 13, 1, 10, 100, 'Website', 'Website', 1, 1, 1, 1, '', 'FIELD_WEBSITE'),
(14, 'group', 14, 1, 10, 100, 'Education', 'Educations', 1, 1, 1, 1, '', ''),
(15, 'text', 15, 1, 10, 200, 'College / University', 'College / University', 1, 1, 1, 1, '', 'FIELD_COLLEGE'),
(16, 'text', 16, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 1, 1, 1, '', 'FIELD_GRADUATION');

INSERT INTO `#__community_fields_values` (`id`, `user_id`, `field_id`, `value`) VALUES
(1, 63, 5, 'kfgsafjg'),
(2, 63, 7, 'jfgajsg'),
(3, 63, 8, 'fsfsf'),
(4, 63, 9, ''),
(5, 63, 10, ''),
(6, 63, 4, 'Bhilwara'),
(7, 63, 3, '1988-3-11 23:59:59'),
(8, 63, 2, 'Male'),
(9, 63, 11, 'gfkjsgf'),
(10, 63, 12, 'Kazakhstan'),
(11, 63, 13, 'gfakjfgjk'),
(12, 63, 15, ''),
(13, 63, 16, 'kgfkagskj');

INSERT INTO `#__jspc_addons` (`id`, `name`, `featurename`, `coreparams`, `addonparams`, `published`) VALUES
(1, 'albums', 'Album', 'jspc_core_total_contribution=100\njspc_core_display_text=Album\njspc_profiletype=0\n\n', 'albums_total=8\n\n', 0),
(2, 'groupowner', 'Group', 'jspc_core_total_contribution=90\njspc_core_display_text=Group\njspc_profiletype=0\n\n', 'groupowner_total=8\n\n', 0),
(3, 'photos', 'Photos', 'jspc_core_total_contribution=60\njspc_core_display_text=Photos\njspc_profiletype=0\n\n', 'photos_total=9\n\n', 0),
(4, 'avatar', 'Avtar', 'jspc_core_total_contribution=40\njspc_core_display_text=Avtar\njspc_profiletype=0\n\n', '\n', 0),
(5, 'groupmember', 'GroupMember', 'jspc_core_total_contribution=70\njspc_core_display_text=GroupMember\njspc_profiletype=0\n\n', 'groupmember_total=9\n\n', 0),
(6, 'videos', 'Videos', 'jspc_core_total_contribution=45\njspc_core_display_text=Videos\njspc_profiletype=0\n\n', 'videos_total=6\n\n', 1),
(7, 'profilefields', 'Profile', 'jspc_core_total_contribution=88\njspc_core_display_text=Profile\njspc_profiletype=0\n\n', '2=8\n3=4\n4=4\n5=8\n7=8\n8=4\n9=8\n10=8\n11=4\n12=8\n13=4\n15=4\n16=16\n\n', 1);


INSERT INTO `#__community_videos` (`id`, `title`, `type`, `video_id`, `description`, `creator`, `creator_type`, `created`, `permissions`, `category_id`, `hits`, `published`, `featured`, `duration`, `status`, `thumb`, `path`, `groupid`, `filesize`, `storage`) VALUES
(1, '''We Are the World'' Class of 2010', 'youtube', 'jOuJ4tJ4mts', '25 years after the original, charity anthem ''We Are The World'' has been given a hip-hip, pop twist by top artists, including Celine Dion, Jonas Brothers and Wyclef Jean. The stars have re-recorded the 80s hit to raise money for Haiti. (Feb. 2)', 63, 'user', '2010-02-03 13:28:16', '0', 1, 0, 1, 0, 102, 'ready', 'images/videos/63/thumbs/x1t2WzjPe1M.jpg', 'http://www.youtube.com/watch?v=jOuJ4tJ4mts&feature=popular', 0, 0, 'file'),
(2, 'Lux Dance India Dance Season 2 Jan. 23 ''10 - Dharmesh', 'youtube', '54DTWqdcEic', 'For more videos visit http:didstep2.zeetv.com', 63, 'user', '2010-02-04 07:14:14', '0', 1, 0, 1, 0, 560, 'ready', 'images/videos/63/thumbs/i7naY4i8tdC.jpg', 'http://www.youtube.com/watch?v=54DTWqdcEic&feature=fvhr', 0, 0, 'file'),
(3, 'DLF IPL 2010 - IPL 3 Back In India - Sachin Tendulkar from the Mumbai Indians Team', 'youtube', 'SaswpMvUR4M', 'Sachin Tendulkar Captain of the IPL 3 Mumbai Indians Team - IPL 2010', 63, 'user', '2010-02-04 07:14:36', '0', 1, 0, 1, 0, 26, 'ready', 'images/videos/63/thumbs/ywYr9Bphea1.jpg', 'http://www.youtube.com/watch?v=SaswpMvUR4M&feature=fvhl', 0, 0, 'file');

INSERT INTO `#__community_videos_category` (`id`, `name`, `description`, `published`) VALUES
(1, 'General', 'General video channel', 1);

