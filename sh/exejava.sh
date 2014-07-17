#! /bin/bash -

# 実行サンプル
# sh exejava.sh jp/co/d2c/appliranking/Test

source ./"ranking_conf.txt"
cd $build_dir
pwd
echo $classpath
java -cp $classpath $1

