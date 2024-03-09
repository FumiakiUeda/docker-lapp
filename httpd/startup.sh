#!/bin/bash

# 変数定義
GRPNAME="xxx"

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
ln -fs /home/${GRPNAME}/ftp/vas/playlist      /home/${GRPNAME}/batch/news/playlist
ln -fs /home/${GRPNAME}/ftp_test/vas/playlist /home/${GRPNAME}/batch/news_test/playlist
ln -fs /home/${GRPNAME}/ftp/vas/playlist      /home/${GRPNAME}/web/news/playlist
ln -fs /home/${GRPNAME}/ftp_test/vas/playlist /home/${GRPNAME}/web/news_test/playlist
# ln -fs /home/${GRPNAME}/ftp/japrs /home/${GRPNAME}/batch/news/japrs
# ln -fs /home/${GRPNAME}/ftp_test/japrs /home/${GRPNAME}/batch/news_test/japrs
# ln -fs /home/${GRPNAME}/ftp/means /home/${GRPNAME}/batch/news/means
# ln -fs /home/${GRPNAME}/ftp_test/means /home/${GRPNAME}/batch/news_test/means
