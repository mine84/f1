/*
-- Query:
-- Date: 2014-02-20 16:49
*/
-- m_os
INSERT INTO `m_os` (`os_id`,`name`) VALUES (1,'ios'), (2, 'android');

-- m_country ios
INSERT INTO `m_country` (`os_id`, `name`, `url`) VALUES
    (1, '日本', 'jp/'),
    (1, 'フランス', 'fr/'),
    (1, 'ドイツ', 'de/'),
    (1, 'イギリス', 'gb/'),
    (1, 'スペイン', 'es/'),
    (1, 'ロシア', 'ru/'),
    (1, 'アメリカ', 'us/'),
    (1, 'カナダ', 'ca/'),
    (1, 'オーストラリア', 'au/'),
    (1, 'フィリピン', 'ph/'),
    (1, 'インドネシア', 'id/'),
    (1, 'インド', 'in/');

-- m_feed ios
INSERT INTO `m_feed` (`os_id`, `name`, `url`) VALUES
    (1, 'トップ無料 App', 'topfreeapplications/'),
    (1, 'トップセールス App', 'topgrossingapplications/');

-- m_category ios
INSERT INTO `m_category` (`os_id`, `name`, `url`) VALUES
    (1, '全て', ''),
    (1, 'ゲーム', 'genre=6014/');


-- m_feed android
INSERT INTO `m_country` (`os_id`, `name`, `url`) VALUES
   (2, '日本', 'jp'),
   (2, 'フランス', 'fr'),
   (2, 'ドイツ', 'de'),
   (2, 'イギリス', 'gb'),
   (2, 'スペイン', 'es'),
   (2, 'ロシア', 'ru'),
   (2, 'アメリカ', 'us'),
   (2, 'カナダ', 'ca'),
   (2, 'オーストラリア', 'au'),
   (2, 'フィリピン', 'ph'),
   (2, 'インドネシア', 'id'),
   (2, 'インド', 'in');

-- m_feed ios
INSERT INTO `m_feed` (`os_id`, `name`, `url`) VALUES
    (2, '無料トップ Android アプリ', 'topselling_free'),
    (2, '売上トップの Android アプリ', 'topgrossing'),
    (2, '新着無料トップ Android アプリ', 'topselling_new_free');

-- m_category ios
INSERT INTO `m_category` (`os_id`, `name`, `url`) VALUES
    (2, '全て', ''),
    (2, 'ゲーム', 'GAME');

