<img width="1025" alt="2017-12-18 23 30 42" src="https://user-images.githubusercontent.com/8135472/34284191-8d8cd02c-e713-11e7-986a-73d960aff231.png">

# 1. 概要

ImageRootは画像をアップロードして、その画像について会話することができるサービスです。  

# 2. 環境

cakePHP 3.4
Docker 17.03.1-ce
mysql 5.7.18 (dockerが自動的にダウンロード)
Ubuntu 16.04.2 LTS (dockerが自動的にダウンロード)
aws-sdk-php 3.48.0

このソフトウェアはファイルのアップロードにAWSのS3を使用することを前提としています。

# 3.インストール

ImageRootはDocker-composeを使用することでデータベースを同時に作成することが可能です。
外部のデータベースを使用する場合はDockerfileからビルドを行います。

## 3.1 データベースを同時に起動する方法

githubからファイルのダウンロード

```
$ git clone https://github.com/hal1437/ImageRoot
```

ディレクトリを移動

```
$ cd ImageRoot/
```

docker-composeでサーバーとデータベースを同時に作成し、起動する

```
$ docker-compose build
$ docker-compose up
```

## 3.2 外部のデータベースを利用する方法

cakePHPはデーターベースの情報をconfig/app.phpに記録しています。
app.default.phpからコピー

```
$ cp config/app.default.php config/app.php
```

Datasources/defaultを編集しSQLホストIP、ユーザー名、パスワード、データベース名を変更します。
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

リードレプリカなどを使用する場合、Datasources/writeに書き込みのデータベースを別の物に指定します。
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
dockerでコンテナを作成

```
$ docker build ./ -t imageroot_web
```

サーバーを起動

```
$ docker run -d -p 80:8765 -v `pwd`:/code imageroot_web bin/cake server -H 0.0.0.0
```

# 4.サーバーの設定
## 4.1 AWSの設定
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

## 4.2 CloudFrontの設定
config/CloudFrontにCloudFrontのドメイン名を設定することでS3へCloudFrontを経由してアクセスします。
```
<?php
return [
	"cloud_front_domain" => ""
];
```
CloudFrontのドメイン名を空にした場合、直接S3へ接続されます。
