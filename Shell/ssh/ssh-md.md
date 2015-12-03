# ssh 操作

## 安装

``` sh
sudo apt-get install openssh-client
sudo apt-get install openssh-server

```

## 高级特性

- [文章](http://blog.csdn.net/fdipzone/article/details/23000201)

``` sh
  ssh-keygen -t rsa -P "密码"	 //创建非对称秘钥
      ssh-keygen -t rsa  //不需要密码的
  ssh www@192.168.1.24 		//链接远程主机
  ssh-add -l 			//查看添加的key缓存
  ssh-add -D      //清除缓存
  ssh -t ac@ad command 执行远程命令
  ssh -vvv ac@ad command 显示调试模式
  ssh-add ~/.ssh/id_rsa   添加本地 key 到缓存

  执行远程脚本，需要免密码登陆
  ssh -t -p 22 hadoop@192.168.160.45 touch /tmp/aaaaa.txt

2.远程执行命令配置

  ~/.bashrc 里面，如果不是交互模式会推出,如果特殊需求，这里注释掉
  # If not running interactively, don't do anything
  case $- in
      *i*) ;;
        *) return;;
  esac

  案例：必须在目标的服务器，使用脚本作为容器来执行指定 shell
  ssh -q -t dwadmin@bi2 "bash -i /usr/local/hive/bin/hive -e 'show tables;'"


  ssh -q -t dwadmin@10.10.2.91 "bash -i /usr/local/hive/bin/hive -e \"LOAD DATA LOCAL INPATH '/data/log/uba/uba_web_visit_20151201.log' OVERWRITE INTO TABLE real_time.uba_web_visit_log\""

```
