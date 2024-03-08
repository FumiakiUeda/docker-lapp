#!/bin/bash

# 変数定義
GRPNAME="rkc"

# 古いシンボリックリンクを削除
cd /home/${GRPNAME}/
rm -f batch/news_test/playlist \
      batch/news/playlist \
      web/news_test/playlist \
      web/news/playlist \
      batch/news_support/japrs \
      batch/news_test/playlist \
      batch/news_test/japrs \
      batch/news_support/means

# 新しいシンボリックリンクを作成
ln -fs /home/${GRPNAME}/ftp_test/vas/playlist /home/${GRPNAME}/batch/news_test/playlist
ln -fs /home/${GRPNAME}/ftp/vas/playlist      /home/${GRPNAME}/batch/news/playlist
ln -fs /home/${GRPNAME}/ftp_test/vas/playlist /home/${GRPNAME}/web/news_test/playlist
ln -fs /home/${GRPNAME}/ftp/vas/playlist      /home/${GRPNAME}/web/news/playlist
# ln -fs ftp/japrs batch/news_support/japrs
# ln -fs ftp_test/japrs batch/news_test/japrs
# ln -fs ftp/means batch/news_support/means
