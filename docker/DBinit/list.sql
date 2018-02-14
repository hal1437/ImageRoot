
use my_app;
-- ルート
create table roots(
	root_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	created DATETIME DEFAULT CURRENT_TIMESTAMP,
	title TEXT,
	image_id INTEGER
);
-- ノード
create table nodes(
	node_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	created DATETIME DEFAULT CURRENT_TIMESTAMP,
	user_name TEXT,
	message TEXT,
	root_id  INTEGER,
	reply_id INTEGER DEFAULT -1,
	image_id INTEGER DEFAULT -1
);
-- 画像
create table images(
	image_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	url TEXT
);
-- ユーザーデータ
create table users (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50),
	password VARCHAR(255),
	mail VARCHAR(255),
	role VARCHAR(20),
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL	
);

-- insert into roots (title,image_id)                     values("今日の夕飯について",1);
-- insert into roots (title,image_id)                     values("今日も夕飯について",1);
-- insert into roots (title,image_id)                     values("毎日の夕飯について",1);
-- insert into roots (title,image_id)                     values("明日も夕飯について",1);
-- insert into nodes (user_name,message,root_id,image_id) values("一人暮らし","今日はカレーを作ってみました。",1,1);
-- insert into nodes (user_name,message,root_id,reply_id) values("シェフ"    ,"滝かよ"                        ,1,1);
-- insert into images(url)                                values("https://goo.gl/i62vJr");
