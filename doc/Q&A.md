# Q&A

## 目次

1. [docker composeでビルドエラーになる](#docker-composeでビルドエラーになる)
1. [コンテナ間の通信をしたい](#コンテナ間の通信をしたい)
1. [FTPユーザーを追加したい](#ftpユーザーを追加したい)
1. [VmmemWSLのメモリ使用率が高すぎる](#vmmemwslのメモリ使用率が高すぎる)
1. [Apacheでホスティングしているサイトの動作が遅い](#apacheでホスティングしているサイトの動作が遅い)
1. [Dockerコマンドを実行するとエラーになる](#dockerコマンドを実行するとエラーになる)
1. [DockerとWSLの違いがわからない](#dockerとwslの違いがわからない)

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

このエラーはプロキシ環境に起因するものであり、通常であればDocker Desktopにプロキシの設定を入れることで解決できるはずなのだが、社内回線等でプロキシサーバーを使用している場合どうやら上手くいかない場合がある。

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

開発しているアプリにFTP機能やメール機能等がある場合、envファイル等にホスト接続先を指定するかと思うが、コンテナ同士の通信は動的なローカルIPアドレスで行われているため、ホストをどこに向ければいいのかと戸惑うかもしれない。

これについては、コンテナのサービス名を記載すれば動的に別のコンテナに通信するような仕組みになっている。

（サービス名は、`docker-compose.yml`のservicesで定義されている。）

例えば、PHPコンテナからFTPサーバーコンテナへFTPを行う場合、ホスト名は`ftpsrv`と指定すれば`ftpsrv`というホスト名を`172.25.0.6`などのローカルIPに名前解決してくれる。

envファイルの記載例

```ini
FTP_HOST=ftpsrv
FTP_USER=ftpusr
FTP_PASS=adminmin
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

下記記事のようにWSL内にソースコードを配置すると改善する。

[WindowsでDockerを使う時、正しくファイル配置しないと激重になるので注意 #初心者 - Qiita](https://qiita.com/minato-naka/items/84508472c04f628e576e)

※WSLは通常の場合Cドライブにマウントされているため、WSLに移動すると**外付けSSDから出てしまう**。下記記事などを参考にGドライブにマウントし直すなど容量などには十分注意が必要）

[Ubuntu(WSL2)をCドライブからDドライブへ引越す - Zenn](https://zenn.dev/shittoku_xxx/articles/066cfd072d87a1)

## Dockerコマンドを実行するとエラーになる

下記エラーの場合は単にDockerエンジンが起動していないだけなのでDockerを起動すれば解決する。

```bash
docker.errors.DockerException: Error while fetching server API version: ('Connection aborted.', FileNotFoundError(2, 'No such file or directory'))
[3854] Failed to execute script docker-compose
```

それ以外のエラーの場合は大抵Dockerの再起動かWSLの再起動で改善する。

Dockerの再起動はタスクトレイのDockerアイコンを右クリック、「Restart」で再起動できる。

WSLの再起動は下記コマンドで可能（シャットダウンのコマンドだが自動で再立ち上げが行われる）。

```bash
wsl --shutdown
```

## DockerとWSLの違いがわからない

WSLは名前の通りLinuxのプログラムをWindows10/11およびWindowsServer上で実行するための仕組みである。

Dockerはあくまでコンテナ仮想化ソフトウェアであり、WSLと同一ではない。
WSLはWindowsのコンポーネントであり、言うなればLinuxエミュレーターであるが、Dockerはマシン上に仮想の環境を作り開発を便利にするエンジンである。

WSLはほぼ別のOSをインストールしているのに感覚が近いが、Dockerは厳密にはOSではなくコンテナ環境である。OSに似た挙動を取ることも多いが、WSLやVMなどよりもホストマシンとの共有部分が多く軽量である。

今回のDockerはWSL上で動くため、最終的な形としてはWindowsの上にWSL、その上にDockerエンジン、さらにその上にコンテナということになる。

そのためDockerコンテナを仮想OSとして使うのは本来のDockerの使い方ではないので注意されたい。

参考：[備忘録 - WSL、Dockerの関係性について #Docker - Qiita](https://qiita.com/takmot/items/2274d6cdf648eb135a18)
