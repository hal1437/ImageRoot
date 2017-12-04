# ToDoLists

[![Build Status](https://travis-ci.org/hal1437/ToDoLists.svg?branch=master)](https://travis-ci.org/hal1437/ToDoLists)
![スクリーンショット](https://raw.githubusercontent.com/hal1437/ToDoLists/doc/doc/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88%202017-06-26%2013.07.26.png)


ToDoListsはToDoリストを管理できるWebアプリケーションです。  
ブラウザからアクセスでき、あなたのやるべきことのリストを作成できます。

# 1. 環境

+ cakePHP 3.4
+ Docker 17.03.1-ce
+ Docker Compose version 1.11.2
+ mysql 5.7.18 (dockerが自動的にダウンロード)
+ Ubuntu 16.04.2 LTS (dockerが自動的にダウンロード)

# 2. 構成
DockerComposeによって、サーバーとデータベースのイメージが作成され互いにリンクされます。  
サーバーがリクエストを受け付け、必要に応じてデータベースへデータの取得・更新・削除を行います。  
データベースのテーブルはToDoListとToDoの2つが存在し、以下の様にテーブルが作成されています。

### ToDoList
| リストID\* | 作成日時 | リスト名 |
|:-:|:-:|:-:|

### ToDo
| ToDoID\* | 所属するリストのID | ToDo名 | 作成日時 | 締め切り日時 | 完了済みフラグ |
|:-:|:-:|:-:|:-:|:-:|:-:|

\*は主キー  
これらのデータベースは/docker/DBinit/list.sqlに保存され、いくつかのサンプルデータと共に、
データベース初回起動時に作成されます。

# 3. インストール方法

#### 1. リポジトリをダウンロードし、ディレクトリを移動します。
```
git clone https://github.com/hal1437/ToDoLists/
cd ToDoLists/
```

#### 2. Dockerファイルをビルドします。（**非常に時間がかかります。**）
```
docker-compose build
```

#### 3. Dockerコンテナを起動します。
```
docker-compose up 
```
初回起動時、cakePHPの起動に必要なファイルをcomposerを使ってダウンロードするため、時間がかかります。


#### 4. ブラウザの[localhost](http://localhost/)にアクセスすることで、ToDoListsを利用できます。

# 4. 使用したライブラリ
デザイン：[bootstrap](http://getbootstrap.com/)  
日付設定:[bootstrap-datepicker](https://github.com/uxsolutions/bootstrap-datepicker)

