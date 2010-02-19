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


INSERT INTO `#__community_videos` (`id`, `title`, `type`, `video_id`, `description`, `creator`, `creator_type`, `created`, `permissions`, `category_id`, `hits`, `published`, `featured`, `duration`, `status`, `thumb`, `path`, `groupid`, `filesize`, `storage`) VALUES
(1, '''We Are the World'' Class of 2010', 'youtube', 'jOuJ4tJ4mts', '25 years after the original, charity anthem ''We Are The World'' has been given a hip-hip, pop twist by top artists, including Celine Dion, Jonas Brothers and Wyclef Jean. The stars have re-recorded the 80s hit to raise money for Haiti. (Feb. 2)', 63, 'user', '2010-02-03 13:28:16', '0', 1, 1, 1, 0, 102, 'ready', 'images/videos/63/thumbs/x1t2WzjPe1M.jpg', 'http://www.youtube.com/watch?v=jOuJ4tJ4mts&feature=popular', 0, 0, 'file'),
(2, 'Lux Dance India Dance Season 2 Jan. 23 ''10 - Dharmesh', 'youtube', '54DTWqdcEic', 'For more videos visit http:didstep2.zeetv.com', 63, 'user', '2010-02-04 07:14:14', '0', 1, 0, 1, 0, 560, 'ready', 'images/videos/63/thumbs/i7naY4i8tdC.jpg', 'http://www.youtube.com/watch?v=54DTWqdcEic&feature=fvhr', 0, 0, 'file'),
(3, 'DLF IPL 2010 - IPL 3 Back In India - Sachin Tendulkar from the Mumbai Indians Team', 'youtube', 'SaswpMvUR4M', 'Sachin Tendulkar Captain of the IPL 3 Mumbai Indians Team - IPL 2010', 63, 'user', '2010-02-04 07:14:36', '0', 1, 0, 1, 0, 26, 'ready', 'images/videos/63/thumbs/ywYr9Bphea1.jpg', 'http://www.youtube.com/watch?v=SaswpMvUR4M&feature=fvhl', 0, 0, 'file'),
(4, 'WWE RAW 2110 PART 1111', 'youtube', 'pcrfPhm-ZDc', 'WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110', 63, 'user', '2010-02-04 07:15:05', '0', 1, 0, 1, 0, 620, 'ready', 'images/videos/63/thumbs/EDAMP4w4zwF.jpg', 'http://www.youtube.com/watch?v=pcrfPhm-ZDc&feature=popular', 0, 0, 'file'),
(5, 'Noor-E-Khuda - My Name is Khan', 'youtube', 'oC-bioRLLDY', 'Rizvan Khan, a Muslim man from India, moves to San Francisco and lives with his brother and sister-in-law. Rizvan, who has Aspergers, falls in love with Mandira. Despite protests from his family they get married and start a small business together. They are happy until September 11, 2001 when attitudes towards Muslims undergo a sea-change. When tragedy strikes, Mandira is devastated and they split. Rizvan is confused and very upset that the love of his life has left him. To win her back, he embarks on a touching and inspiring journey across America.\r\n\r\n''My Name is Khan'' is the triumphant story of an unconventional hero overcoming obstacles to regain the love of his life.', 63, 'user', '2010-02-04 07:15:38', '0', 1, 0, 1, 0, 100, 'ready', 'images/videos/63/thumbs/Oj9HfT52gIm.jpg', 'http://www.youtube.com/watch?v=oC-bioRLLDY&feature=topvideos', 0, 0, 'file'),
(6, 'WWE RAW 2110 PART 1 (HQ)', 'youtube', 'HYbypnJ-Wwk', 'WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110 WWE RAW 2110', 63, 'user', '2010-02-04 07:15:54', '0', 1, 0, 1, 0, 611, 'ready', 'images/videos/63/thumbs/ocxi753bVk3.jpg', 'http://www.youtube.com/watch?v=HYbypnJ-Wwk&feature=topvideos', 0, 0, 'file');

INSERT INTO `#__community_videos_category` (`id`, `name`, `description`, `published`) VALUES
(1, 'General', 'General video channel', 1);

