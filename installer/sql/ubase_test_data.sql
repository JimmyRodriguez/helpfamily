-- (c) copyright 2011 nadlabs. All rights reserved.
-- liceneced under the nl-DFLA for more info goto http://www.nadlabs.co.uk/licence.php

-- --------------------------------------------------------
USE ##dbname##;

INSERT INTO `security_blocks` (`blockid`, `blockvalue`, `type`, `description`, `valid`, `blockarea`) VALUES 
(2, 'mikedahacker@hotmail.com', 3, 'block this user as he is a hacker', 1, 1),
(3, 'bbc.co.uk', 5, 'domain', 1, 1),
(4, '127.0.0.1', 1, 'ip', 2, 1),
(5, 'yahoo.co.uk/news', 4, 'url', 2, 1),
(6, 'newblock@mynamethis_long.com', 3, 'my email address', 1, 1),
(7, '123.123.123.123', 1, 'ip blocked due to suspect dos', 1, 3),
(8, '123.21.213.12', 1, 'block this ip from accessing the site', 1, 2),
(9, '221.21.56.78', 1, '', 1, 1),
(10, '43.5.6.2', 1, '', 1, 1),
(11, '4.5.66.123', 1, '', 2, 1),
(12, '123.56.7.8', 1, '', 1, 1),
(13, '198.0.0.1', 1, '', 1, 1),
(14, '123.23.43.5', 1, '', 1, 1),
(15, '12.32.45.5', 1, '', 1, 1),
(16, '213.32.4.56', 1, '', 1, 1),
(17, '12.23.4.223', 1, '', 1, 1),
(18, '12.3.45.6', 1, '', 1, 1),
(19, '213.4.5.66', 1, '', 1, 1),
(20, '55.55.55.55', 1, '', 1, 1),
(21, '12.32.21.34', 1, '', 1, 1),
(22, '32.43.213.4', 1, '', 1, 1),
(23, '92.0.0.1', 1, '', 1, 1),
(24, '21.32.5.2', 1, '', 1, 1),
(25, '0.0.0.0', 1, '', 1, 1),
(26, 'http://www.bbc.co.uk/sport', 4, 'block any sports people!', 1, 3),
(27, 'newblock@blocks.com', 3, '', 1, 1),
(28, 'gmail.com', 2, 'block all people signing up with gmail accounts', 1, 1),
(29, 'ymail.com', 2, 'block people signing up with ymail.com accounts', 1, 1),
(30, 'mike@estore.com', 3, 'i dont like this guy - blocking his email', 1, 1),
(31, 'tony@british.gov', 3, 'blocked email address', 1, 1),
(32, 'sports.com', 5, '', 1, 2),
(33, 'thisisasiteblock.com', 5, '', 1, 3),
(34, 'example.com', 2, 'blocking the obvious', 1, 3),
(35, 'adobeflash.com', 5, '', 1, 3),
(36, 'yahoo.co.uk', 5, 'we dont have anything against yahoo - it''s just the first thing to come to mind!', 1, 1),
(37, 'yahoo', 1, '', 1, 1);



INSERT INTO `user_table` (`userid`, `username`, `screenname`, `p_hash`, `s_hash`, `valid`, `acti_code`, `ipad`, `date_joined`, `lastip`, `last_visit`, `email`, `gravtar_email`, `usergroup`, `temppass`, `tpdate`, `tpip`, `tp_flag`, `browser`, `os`, `lang`, `country`, `refid`, `refurl`, `refdomain`, `contact`, `fname`, `sname`, `mobilenum`, `screenres`, `searchengine`, `searchterm`, `smstok`, `smsip`, `smstimedate`, `oneuse`, `landingpage`, `openidurl`, `authentication_source`, `img_flag`, `img_url`, `cookie_id`, `cookie_salt`, `cookie_expire`, `paid`, `fee`, `renew_date`) VALUES
(1012, 'kjsah', 'kjsah', '6ed5613610a7958d5a684a97c0855c91ad1d7fb2', '*Q<|<', 0, '1374851110', '127.0.0.1', '2013-07-26 16:05:10', 'no visit', '0000-00-00 00:00:00', 'sjsjhd@example.com', '', 2273, '', '0000-00-00 00:00:00', '', 0, 'FFX', 'WINXP', 'en', 'ZZ', '', 'type-in-traffic', 'type-in-traffic', 1, NULL, NULL, 'N/A', '1024x768', 'none', '---', '', '', '0000-00-00 00:00:00', 0, 'http://localhost/ns/basic_new/development/nervecentre/userbase/index_1_3/index.php', '', 'userbase', '0', '', '', '', '0000-00-00 00:00:00', 0, '0.00', '0000-00-00 00:00:00'),
(1010, 'tiys', 'tiys', '84c2cc1fbd069b2c671ffdbdf3aa01a46b7e27c8', 'jxvP~', 0, '1374505827', '127.0.0.1', '2013-07-22 16:10:27', 'no visit', '0000-00-00 00:00:00', 'hsjhs@sjhsh.com', '', 4, '', '0000-00-00 00:00:00', '', 0, 'FFX', 'WINXP', 'en', 'ZZ', '', 'type-in-traffic', 'type-in-traffic', 0, NULL, NULL, 'N/A', '1024x768', 'none', '---', '', '', '0000-00-00 00:00:00', 0, 'http://localhost/ns/basic_new/development/nervecentre/userbase/index_1_3/index.php', '', 'userbase', '0', '', '', '', '0000-00-00 00:00:00', 0, '0.00', '0000-00-00 00:00:00'),
(1008, 'crazynadeem', 'crazynadeem', '', '', 1, '', '127.0.0.1', '2012-11-30 14:24:16', 'no visit', '0000-00-00 00:00:00', '', '', 4, '', '0000-00-00 00:00:00', '', 0, 'FFX', 'WINXP', 'ool', 'ZZ', '', 'type-in-traffic', 'type-in-traffic', 0, NULL, NULL, NULL, '', 'none', '---', NULL, NULL, '0000-00-00 00:00:00', 0, 'http://localhost/ns/basic_new/development/nervecentre/userbase/index_js_only/', 'http://crazynadeem.wordpress.com/', 'openid', '1', 'http://localhost/images/no_img.gif', '', '', '0000-00-00 00:00:00', 0, '0.00', '0000-00-00 00:00:00'),
(1009, 'guest_881364765296', 'guest_881364765296', '', '', 1, '', '127.0.0.1', '2013-03-31 22:28:16', '127.0.0.1', '2013-03-31 22:33:42', 'naejhu@yahoo.co.uk', '', 4, '', '0000-00-00 00:00:00', '', 0, 'FFX', 'WINXP', 'ool', 'ZZ', '', 'type-in-traffic', 'type-in-traffic', 0, NULL, NULL, NULL, '', 'none', '---', NULL, NULL, '0000-00-00 00:00:00', 0, 'http://localhost/ns/basic_new/development/nervecentre/userbase/index_js_only/', 'https://me.yahoo.com/a/HtPN8hF60OyZLZV9UCfN168R.Q--#ed3f3', 'openid', '1', 'http://localhost/images/no_img.gif', '', '', '0000-00-00 00:00:00', 0, '0.00', '0000-00-00 00:00:00'),
(1003, 'testy', 'testy', '8f06553a774047bb7bc3f0484572f0efcffbd41f', 'OVTM', 1, 'admin-activated', '127.0.0.1', '2012-09-21 19:07:40', 'no visit', '0000-00-00 00:00:00', 'hsjhss@skhjs.com', '', 1, '', '0000-00-00 00:00:00', '', 0, 'OBW', 'OOS', 'ool', 'ZZ', '', 'admin-created', 'admin-created', 0, NULL, NULL, 'N/A', 'not set', 'none', '---', '', '', '0000-00-00 00:00:00', 0, 'admin-cp', '', 'userbase', '0', 'http://localhost/images/no_img.gif', 'none', 'none', '0000-00-00 00:00:00', 0, '0.00', '0000-00-00 00:00:00'),
(1007, 'guest_911354284721', 'guest_911354284721', '', '', 1, '', '127.0.0.1', '2012-11-30 14:12:01', 'no visit', '0000-00-00 00:00:00', 'nadeem83uk@gmail.com', '', 4, '', '0000-00-00 00:00:00', '', 0, 'FFX', 'WINXP', 'ool', 'ZZ', '', 'type-in-traffic', 'type-in-traffic', 0, NULL, NULL, NULL, '', 'none', '---', NULL, NULL, '0000-00-00 00:00:00', 0, 'http://localhost/ns/basic_new/development/nervecentre/userbase/index_js_only/', 'https://www.google.com/accounts/o8/id?id=AItOawnuXtTxtP0X_Az2xkzRdi8okHLeBJhFkmw', 'openid', '1', 'http://localhost/images/no_img.gif', '', '', '0000-00-00 00:00:00', 0, '0.00', '0000-00-00 00:00:00'),
(408, 'tonybalony', 'tonybalony', '', '', 1, '', '127.0.0.1', '2012-09-13 10:14:59', '127.0.0.1', '2013-07-27 11:19:21', 'habib83uk@gmail.com', '', 4, '', '0000-00-00 00:00:00', '', 0, 'FFX', 'WINXP', 'ool', 'ZZ', '', 'type-in-traffic', 'type-in-traffic', 0, NULL, NULL, NULL, '', 'none', '---', NULL, NULL, '0000-00-00 00:00:00', 0, 'http://localhost/ns/basic_new/development/nervecentre/userbase/index_js_only/', 'https://www.google.com/accounts/o8/id?id=AItOawk5bLClLkmCSIyDTel1_YTUVg6-b9xq2PI', 'openid', '1', 'http://localhost/images/no_img.gif', '', '', '0000-00-00 00:00:00', 0, '0.00', '0000-00-00 00:00:00'),
(409, 'hellguy', 'hellguy', 'e0d4d8b960b1b37c7e6b0050f3741ba34ba25ec1', '2}rA:', 1, 'admin-activated', '127.0.0.1', '2012-09-21 09:11:39', 'no visit', '0000-00-00 00:00:00', 'email@example.com', '', 1, '', '0000-00-00 00:00:00', '', 0, 'OBW', 'OOS', 'ool', 'ZZ', '', 'admin-created', 'admin-created', 0, NULL, NULL, 'N/A', 'not set', 'none', '---', '', '', '0000-00-00 00:00:00', 0, 'admin-cp', '', 'userbase', '0', 'http://localhost/images/no_img.gif', '', '', '0000-00-00 00:00:00', 0, '0.00', '0000-00-00 00:00:00'),
(405, 'hello', 'hello', '685b6cf3224718dcac5cf1847016d81447d8d7dc', '2jVv', 0, '1343380792', '127.0.0.1', '2012-07-27 10:19:52', 'no visit', '0000-00-00 00:00:00', 'ljskj@skjs.com', '', 2273, '', '0000-00-00 00:00:00', '', 0, 'FFX', 'WINXP', 'en', 'ZZ', '', 'type-in-traffic', 'type-in-traffic', 1, NULL, NULL, 'N/A', '1024x768', 'none', '---', '', '', '0000-00-00 00:00:00', 0, 'http://localhost/ns/basic_new/development/nervecentre/userbase/index_js_only/', '', 'userbase', '0', '', '', '', '0000-00-00 00:00:00', 0, '0.00', '0000-00-00 00:00:00'),
(396, 'testguy', 'testguy', '5da49df2811cd80a78f079534c09af89df4404d2', 'Rq:$R', 0, '1342955046', '127.0.0.1', '2012-07-22 12:04:06', 'no visit', '0000-00-00 00:00:00', 'passwo@skjsjh.com', '', 2271, '', '0000-00-00 00:00:00', '', 0, 'FFX', 'WINXP', 'en', 'ZZ', '', 'type-in-traffic', 'type-in-traffic', 1, NULL, NULL, 'N/A', '1024x768', 'none', '---', '', '', '0000-00-00 00:00:00', 0, 'http://localhost/ns/basic_new/development/nervecentre/userbase/index_js_only/index.php', '', 'userbase', '0', '', '', '', '0000-00-00 00:00:00', 0, '0.00', '0000-00-00 00:00:00'),
(395, 'newregguy', 'newregguy', '3468821e1b17b0632e04ab46b7d3ada7550cb97c', '9AFUY', 1, '1342609543', '127.0.0.1', '2012-07-18 12:05:43', '127.0.0.1', '2012-07-22 11:07:59', 'paspos@skhjjhs.com', '', 2271, '', '0000-00-00 00:00:00', '', 0, 'FFX', 'WINXP', 'en', 'ZZ', '', 'type-in-traffic', 'type-in-traffic', 1, NULL, NULL, 'N/A', '1024x768', 'none', '---', '', '', '0000-00-00 00:00:00', 0, 'http://localhost/ns/basic_new/development/nervecentre/userbase/index_js_only/index_v1_3.php', '', 'userbase', '0', '', '', '', '0000-00-00 00:00:00', 1, '34.00', '2012-06-12 00:00:00');
