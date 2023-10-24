#!/bin/sh

# 変数定義
GRPNAME="rkc"

# 古いシンボリックリンクを削除
cd /home/${GRPNAME}/
rm -f batch/news_test/playlist \
      batch/news/playlist \
      web/${GRPNAME}/news_test/playlist \
      web/${GRPNAME}/news/playlist \
      batch/news_support/japrs \
      batch/news_test/playlist \
      batch/news_test/japrs \
      batch/news_support/means

# 新しいシンボリックリンクを作成
ln -fs ftp_test/vas/playlist batch/news_test/playlist
ln -fs ftp/vas/playlist      batch/news/playlist
ln -fs ftp_test/vas/playlist web/${GRPNAME}/news_test/playlist
ln -fs ftp/vas/playlist      web/${GRPNAME}/news/playlist
# ln -fs ftp/japrs batch/news_support/japrs
# ln -fs ftp_test/japrs batch/news_test/japrs
# ln -fs ftp/means batch/news_support/means
