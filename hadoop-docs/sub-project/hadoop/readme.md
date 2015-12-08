# Hadoop

## 一、模块介绍

## 二、命令行

### 1、shell 文件操作 (类似 linux 文件操作)

- hadoop dfs 查看所有命令

``` sh
1) 列出文件列表
  hadoop dfs –ls [文件目录]
  hadoop dfs -ls /

2) 打开某个文件
  hadoop dfs –cat [file_path]
  hadoop dfs -cat /user/hive/warehouse/jason_test.db/student/student.txt

3) 将本地文件存储至 hadoop
  hadoop dfs –put [本地地址] [hadoop目录]
  hadoop dfs -put ./example.log /user/test/a.log

4) 将本地文件夹存储至 hadoop
  hadoop dfs –put [本地目录] [hadoop目录]
  hadoop dfs –put /home/t/dir_name /user/test/

5) 下载 hadoop 文件到我本地
  hadoop dfs -get [文件目录] [本地目录]
  hadoop dfs –get /user/test/a.log ./

6) 删除 hadoop 上指定文件
  hadoop dfs –rm [文件地址]
  hadoop dfs –rm /user/test/a.log

7) 删除 hadoop 上指定文件夹（包含子目录等）
  hadoop dfs –rmr [目录地址]
  hadoop dfs –rmr /user/test

8) 在 hadoop 指定目录内创建新目录
  hadoop dfs –mkdir /user/test/aaa

9) 在 hadoop 指定目录下新建一个空文件
  hadoop dfs -touchz  /user/test/new.txt

10) 将 hadoop 上某个文件重命名
  hadoop dfs –mv [原目录地址] [新目录地址]
  hadoop dfs –mv /user/test/new.txt  /user/test/new1.txt

11) 将hadoop指定目录下所有内容保存为一个文件，同时下载至本地
  hadoop dfs –getmerge [原目录地址] [本地目录地址]
  hadoop dfs –getmerge /user/test/ ./

12) hadoop dfs -count -q /  

  hadoop dfs -count -q -h /

  QUOTA（命名空间的限制文件数）: 8.0 E
  REMAINING_QUATA(剩余的命名空间): 8.0 E
  SPACE_QUOTA(限制空间占用大小): none
  REMAINING_SPACE_QUOTA(剩余的物理空间): inf
  DIR_COUNT(目录数统计): 81.4 K
  FILE_COUNT(文件数统计): 272.6 K
  CONTENT_SIZE: 258.6 G
  FILE_NAME :  /

13) 查看目录使用情况
  hadoop dfs -du -s -h /

```

### 2、查看 hadoop job

```sh
1) 查看 job 任务
hadoop job -list

2) 将正在运行的 hadoop 作业kill掉
hadoop job –kill [job-id]

3) 查看 job 状态
hadoop job -status [job-id]
```

## 三、挂载hdfs目录到本地，实现云存储到 hadoop hdfs

- [安装 JDK 包，下载地址](http://www.oracle.com/technetwork/java/javase/downloads/jdk7-downloads-1880260.html)

```sh
$(lsb_release -cs)  linux内核版本

1) 找到源
  (1) Ubuntu
  wget  http://archive.cloudera.com/cdh5/one-click-install/$(lsb_release -cs)/amd64/cdh5-repository_1.0_all.deb

  dpkg -i cdh5-repository_1.0_all.deb

  sudo apt-get update

  apt-get install hadoop-hdfs-fuse


  (2) Centos6
  yum 包源
  wget http://archive.cloudera.com/cdh5/redhat/6/x86_64/cdh/cloudera-cdh5.repo

  cp ./cloudera-cdh5.repo /etc/yum.repos.d/

  导入key
  rpm --import http://archive.cloudera.com/cdh5/redhat/6/x86_64/cdh/RPM-GPG-KEY-cloudera

  yum install hadoop-hdfs-fuse


2) 挂载
  hadoop-fuse-dfs dfs://<name_node_hostname>:<namenode_port> <mount_point>

  mkdir -p /data/hdfs/
  chown -R hdfs:hdfs /data/hdfs/

  hadoop-fuse-dfs dfs://192.168.160.45:8020/ /data/hdfs/

  umount /data/hdfs/ 卸载分区
```

### 2、shell.sh 操作 hadoop

``` sh
1) 列出目录
hadoop dfs -ls hdfs://192.168.160.45:8020/user/

2) 写本地文件到 hdfs 中
hadoop dfs -put /data/soj_log/aaa.log hdfs://192.168.160.45:8020/user/test/

```
