#! /bin/bash -

# 実行サンプル
# sh exejava.sh jp/co/d2c/appliranking/Test

source ./"ranking_conf.txt"
cd $build_dir
pwd
echo $classpath
echo $conf_dir/googleplay
java -cp $classpath -Djavax.net.ssl.trustStore=$conf_dir/googleplay -Djavax.net.ssl.trustStorePassword=changeit $1


