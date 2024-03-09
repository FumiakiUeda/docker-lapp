# `.env`ファイルの環境変数について

## Apache/PHP関係

|変数|意味|デフォルト|備考|
|--|--|--|--|
|HTTP_PUBLISHED_PORT|ApacheにHTTPアクセスするためポート番号|`80`|ホストマシンへ転送されるポート番号|
|HTTPS_PUBLISHED_PORT|ApacheにHTTPSアクセスするためポート番号|`443`|〃|
|HOME_DIR|ホストマシン上でhomeファイルを配置している場所|`G:\MUS\home`|コンテナ内へマウントされる|
|HTML_DIR|ホストマシン上でhtmlファイルを配置している場所|`G:\MUS\var\www\html`|〃|
|SMARTY_DIR|ホストマシン上でSmartyファイルを配置している場所|`G:\MUS\usr\lib64\php\pear\smarty`|〃|
|SHAREPHP_DIR|ホストマシン上でshare/phpファイルを配置している場所|`G:\MUS\usr\share\php`|中身が空でもOK|

## PostgreSQL関係

|変数|意味|デフォルト|備考|
|--|--|--|--|
|POSTGRES_PUBLISHED_PORT|PostgreSQLのポート番号|`5432`|ホストマシンへ転送されるポート番号|
|POSTGRES_PASS|postgresユーザー（初期ユーザー）のパスワード|`adminmin`||

## pgAdmin4関係

|変数|意味|デフォルト|備考|
|--|--|--|--|
|PGADMIN_PUBLISHED_PORT|pgAdmin4へアクセスするためのポート番号|`8080`|ホストマシンへ転送されるポート番号|
|PGADMIN_DEFAULT_EMAIL|pgAdmin4の初期ユーザー名|`demo.digicon@topcreation.co.jp`||
|PGADMIN_DEFAULT_PASS|pgAdmin4の初期ユーザーPW|`adminmin`||

## FTPサーバー関係

|変数|意味|デフォルト|備考|
|--|--|--|--|
|FTP_CTRL_PORT|FTPのコントロールコネクション番号|`21`|FileZilla等で接続する際に指定するポート番号|
|FTP_PASV_MIN_PORT|FTPパッシブモード時のデータコネクションポート番号（最小値）|`50000`||
|FTP_PASV_MAX_PORT|FTPパッシブモード時のデータコネクションポート番号（最大値）|`50009`||
|FTP_USER_NAME|初期FTPユーザー名|`ftpuser`||
|FTP_USER_PASS|初期FTPユーザーPW|`adminmin`||

## SFTPサーバー関係

|変数|意味|デフォルト|備考|
|--|--|--|--|
|SFTP_PUBLISHED_PORT|SFTPへアクセスするためのリスニングポート|`22`|ホストマシンへ転送されるポート番号|
|SFTP_USER_NAME|初期SFTPユーザー名|`sftpuser`||
|SFTP_USER_PASS|初期SFTPユーザーPW|`adminmin`||

## Mailpit関係

|変数|意味|デフォルト|備考|
|--|--|--|--|
|MAILPIT_PUBLISHED_PORT|Mailpit管理画面にアクセスするためのポート番号|`8025`||
