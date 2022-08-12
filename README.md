# メッセージ機能付き簡易SNSアプリ
phpを使って簡易的なSNSアプリを作成しました。

## 使用感(動画URL)
https://youtu.be/mLiqK0H1wOs

## 使用技術/動作環境
* HTML/CSS
* JavaScript
* PHP 8.1.6
* XAMPP 8.1.6
* Apache/2.4.53
* MariaDB 10.4.24
* Google Chrome

## 機能
* ユーザーの新規登録
* ログイン・ログアウト
* 投稿、投稿の閲覧、投稿の削除
* いいね機能
* 他ユーザーとのチャット機能

##テーブル
|users|
|----------|
|id|
|unique_id|
|username|
|email|
|password|
|img|

|posts|
|--------|
|id|
|user_id|
|content|
|created_day|

|favorites|
|---------|
|id|
|user_id|
|post_id|

|messages|
|---------|
|msg_id|
|from_id|
|to_id|
|msg|

##さいごに
メッセージ機能については下記の動画を参考にさせていただきました。ありがとうございました。
https://www.youtube.com/watch?v=VnvzxGWiK54&t=7631s
