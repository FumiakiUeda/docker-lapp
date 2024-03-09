# Q&A

## 目次

1. [docker composeでビルドエラーになる](#docker-composeでビルドエラーになる)
1. [コンテナ間の通信をしたい](#コンテナ間の通信をしたい)
1. [FTPユーザーを追加したい](#ftpユーザーを追加したい)
1. [VmmemWSLのメモリ使用率が高すぎる](#vmmemwslのメモリ使用率が高すぎる)
1. [Apacheでホスティングしているサイトの動作が遅い](#apacheでホスティングしているサイトの動作が遅い)

## docker composeでビルドエラーになる

以下のようなエラーになることがある。

```
[+] Building 12.7s (4/4) FINISHED                                                                        docker:default
 => [php internal] load .dockerignore                                                                              0.1s
 => => transferring context: 2B                                                                                    0.0s
 => [php internal] load build definition from Dockerfile                                                           0.1s
 => => transferring dockerfile: 5.34kB                                                                             0.0s
 => ERROR [php internal] load metadata for docker.io/library/almalinux:9                                          12.5s
 => [php auth] library/almalinux:pull token for registry-1.docker.io                                               0.0s
------
 > [php internal] load metadata for docker.io/library/almalinux:9:
------
failed to solve: almalinux:9: failed to authorize: failed to fetch oauth token: Post "https://auth.docker.io/token": dial tcp 54.198.86.24:443: connectex: No connection could be made because the target machine actively refused it.
```

このエラーはプロキシ環境に起因するものであり、通常であればDocker Desktopにプロキシの設定を入れることで解決できるはずなのだが、UHB回線ではどうやら難しい模様である。

諸々調べた結果、根本的な解決ではないが、エラーになったイメージを以下のように事前にプルしておくことで回避が可能。

```bash
docker pull [イメージ名]
```

今回はエラーの通り`load metadata for docker.io/library/almalinux:9.2`とAlmalinuxの読み込みが出来なかったため、以下のようにプルしておく。

```bash
docker pull docker.io/library/almalinux:9.2
```

その後にビルドをやり直すことで成功すると思われる。

```bash
# Dockerイメージをビルド
docker compose build
# ビルド完了後にコンテナを起動
docker compose up -d
```

## コンテナ間の通信をしたい

DC-MAXsではFTPの設定があるため、configファイルにFTP接続先を指定するかと思うが、コンテナ同士の通信は動的なローカルIPアドレスで行われているため、FTPホストをどこに向ければいいのかと戸惑うかもしれない。

これについては、コンテナのサービス名を記載すれば動的に別のコンテナに通信するような仕組みになっている。

（サービス名は、`docker-compose.yml`のservicesで定義されている。）

例えば、PHPコンテナからFTPサーバーコンテナへFTPを行う場合、ホスト名は`ftpsrv`と指定すれば`ftpsrv`というホスト名を`172.25.0.6`などのローカルIPに名前解決してくれる。

configファイルの記載例
```php
/**ローカル アドレス */
define('YAHOO_FTP_HOST', 'ftpsrv');
/**ローカル ユーザ */
define('YAHOO_FTP_USER', 'ftpusr');
/**ローカル パスワード */
define('YAHOO_FTP_PASS', 'adminmin');
```

※ホストマシンからは名前解決できないため、例えばホストマシンから`ftpsrv`コンテナへアクセスしたい場合は、ホスト名に`localhost`を指定し、envファイルで設定したポート番号を通してコンテナにアクセスすることとなる。

## FTPユーザーを追加したい

FTPサーバーコンテナ内で下記手順でユーザーを増やすことができる。

```bash
# FTPサーバーコンテナへ入る
docker compose exec ftpsrv bash

# ftp.xxxというFTPユーザーを追加する ※デフォルトユーザーをftpuserにしている場合
pure-pw useradd ftp.xxx -f /etc/pure-ftpd/passwd/pureftpd.passwd -m -u ftpuser -d /home/ftpuser/ftp.xxx
```

## VmmemWSLのメモリ使用率が高すぎる

WSL2のプロセスがメモリを大量に使用している状態。

メモリ使用量を制限することができる。

[WindowsでWSL2のプロセス「Vmmem」のメモリ使用量を制限する &#8211; helog](https://helog.jp/windows/vmmem-memory/)

## Apacheでホスティングしているサイトの動作が遅い

ホストマシンのWindowsとDockerのLinuxの間でファイルシステムが根本的に違うことにより、ファイルを読み込む度に変換が発生し、読み込みが多い処理では遅くなってしまう。

WSL内にソースコードを配置すると改善する。（WSLは通常の場合Cドライブにマウントされているため、WSLに移動すると外付けSSDから出てしまう。Gドライブにマウントし直すなど容量などには注意）

[「WindowsでDockerを動かしたら遅かった😥」を解決する方法をまとめました。 - Zenn](https://zenn.dev/conbrio/articles/fcf937c4049132)