# DC-MAXs on Docker

## 概要

このリポジトリは、コンテナアプリケーション開発プラットフォームであるDockerを利用してDC-MAXsのローカル環境を作成するためのリポジトリである。

## はじめる前に

使用するためにはDockerエンジンのインストールが必要であるため、まずはDocker Desktop for Windowsをインストールすること。

具体的なインストール方法についてはわかりやすい記事や公式のドキュメントがあるため割愛する。

[Windows に Docker Desktop をインストール — Docker-docs-ja 19.03 ドキュメント](https://docs.docker.jp/docker-for-windows/install.html)

## 使い方

### コンテナ起動

1. 本リポジトリのルートディレクトリ（docker-compose.ymlと同階層）でコマンドプロンプトやPowerShellを開く
1. 下記のコマンドを入力し実行する（コンテナイメージのプル・ビルドおよび起動が行われる）

```bash
docker compose up -d
```

### コンテナ停止

```bash
docker compose stop
```

### コンテナ削除

```bash
docker compose down
```

### docker composeでエラーになる場合

以下のようなエラーになることがある。

```shell
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

今回はエラーの通り`load metadata for docker.io/library/almalinux:9`とAlmalinuxの読み込みが出来なかったため、以下のようにプルしておく。

```shell
docker pull docker.io/library/almalinux:9
```

その後にビルドをやり直すことで成功すると思われる。

```shell
docker compose build
```

### FTPユーザーの追加方法
```shell
docker compose exec ftpsrv bash

pure-pw useradd ftp.xxx -f /etc/pure-ftpd/passwd/pureftpd.passwd -m -u ftpuser -d /home/ftpusers/ftp.xxx
```
```yml
      - "G:/MUS/var/www/html/www.uhb.jp:/home/ftp.uhb/"
```