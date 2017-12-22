<img width="1025" alt="2017-12-18 23 30 42" src="https://user-images.githubusercontent.com/8135472/34111134-352a5c98-e44c-11e7-8d11-49dd58dba518.png">

# 1.概要

ImageRootは画像をアップロードして、その画像について会話することができるサービスです。  

# 2. 環境

+ cakePHP 3.4
+ Docker 17.03.1-ce
+ Docker Compose version 1.11.2
+ mysql 5.7.18 (dockerが自動的にダウンロード)
+ Ubuntu 16.04.2 LTS (dockerが自動的にダウンロード)
+ aws-sdk-php 3.48.0

このソフトウェアはファイルのアップロードにAWSのS3を使用することを前提としています。

# 3.インストール

## 3.1 Docker環境での起動

githubからファイルのダウンロード

```
$ git clone https://github.com/hal1437/ImageRoot
```
ディレクトリを移動

```
$ cd ImageRoot/
```

dockerで起動

```
$ dockerc-compose build
$ dockerc-compose up
```
DockerComposeによってサーバーとデータベースが構築されます。サイトへのアクセスは https://localhost:8765 から閲覧できます。

## 3.2 EC2環境での起動


githubからファイルのダウンロード

```
$ git clone https://github.com/hal1437/ImageRoot
```

ディレクトリを移動
```
$ cd ImageRoot/
```

使用するソフトウェアをインストール
```
$ apt-get update
$ apt-get install -y composer
$ apt-get install -y curl
$ apt-get install -y php
$ apt-get install -y php-intl
$ apt-get install -y php-mbstring
$ apt-get install -y php-mysql
$ apt-get install -y php-xml
$ apt-get install -y unzip
$ apt-get install -y zip
```
composerでさらにソフトウェアをインストール
```
$ composer update
```

サーバーを起動
```
$ bin/cake server -H 0.0.0.0 -p 80
```
-p の値を変更することでポートを変更できます。

## 4. サーバーの設定

### データベースの設定
cakePHPはデーターベースの情報をconfig/app.phpに記録しています。
app.default.phpからコピー
```
$ cp config/app.default.php config/app.php
```

ファイルを編集しデータベースの情報を設定する。
SQLホストIP、ユーザー名、パスワード、データベース名を変更する。
Datasources/defaultに読み込むデータベースの情報を記述する。
```php:config/app.php
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'SQLホストIP',
            //'port' => 'non_standard_port_number',
            'username' => 'ユーザー名',
            'password' => 'パスワード',
            'database' => 'データベース名',
            'encoding' => 'utf8',
            'timezone' => 'UTC', 
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false, 
```

リードレプリカなどを使用する場合、書き込みのデータベースを別の物に指定できる。
Datasources/writeに書き込むデータベースの情報を記述する。
```php:config/app.php
    'Datasources' => [
        'write' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'SQLホストIP',
            //'port' => 'non_standard_port_number',
            'username' => 'ユーザー名',
            'password' => 'パスワード',
            'database' => 'データベース名',
            'encoding' => 'utf8',
            'timezone' => 'UTC', 
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false, 
```

### AWSの設定
AWS-SDKは~/.aws/credentialsファイルに記述されたキーを元にS3アクセスします。
ImageRootディレクトリではなくホームディレクトリである点に注意。
~/.awsディレクトリを作成。
```
$ mkdir ~/.aws
```
アクセスキーIDとシークレットアクセスキーを設定
```
[default]
aws_access_key_id=アクセスキーID
aws_secret_access_key=シークレットアクセスキー
region=us-east-2
```
ImageRootはS3のImage/以下に画像を保存するため、あらかじめS3にImage/ファイルを作成する必要があります。


### CloudFrontの設定
config/CloudFrontにCloudFrontのドメイン名を設定することでS3へCloudFrontを経由してアクセスします。
```
<?php
return [
	"cloud_front_domain" => ""
];
```
CloudFrontのドメイン名を空にした場合、直接S3へ接続されます。
