# Java-1.7 JDK-SE 部署

## 一、准备

### 1.下载地址
```
http://www.oracle.com/technetwork/java/javase/downloads/jdk7-downloads-1880260.html

选择 Java SE Development Kit 7u75
Linux x64	135.66 MB  	  jdk-7u75-linux-x64.tar.gz

```

## 二、概念
```
1、Java开发的环境叫做JDK,运行的环境叫 JRE,JVM 包含在 JRE 中

2、Java有二种核心机制
  虚拟机
  垃圾回收机制

3、Java虚拟机
  *.java(代码语言) -> *.class(java可执行文件) -> 执行

4、名词
  J2SDK [JDK] （软件开发包）
  JRE （Java运行环境）
开发需要JDK，用户只需要JRE
```


## 三、安装

### 1.卸载原来的openjdk
```
查找openjdk
rpm -qa | grep java

卸载
rpm -e --nodeps java-1.6.0-openjdk-1.6.0.0-1.66.1.13.0.el6.x86_64
```


### 2、安装SUN的JDK
```
2.1) 解压移动
tar -zxvf jdk-7u75-linux-x64.tar.gz
mv ./jdk1.7.0_75 /usr/local/

2.2) 设置环境变量
vim /etc/profile

export JAVA_HOME=/usr/local/jdk1.7.0_75
export JAVA_BIN=${JAVA_HOME}/bin
export PATH=$PATH:$JAVA_HOME/bin
#引入扩展类
export CLASSPATH=.:$JAVA_HOME/lib/dt.jar:$JAVA_HOME/lib/tools.jar

2.3) 配置生效
source /etc/profile
```


### 3、测试
```
vim Test.java

public class Test{
  public static void main(String[] args){
    System.out.println("Hello,Welcome to Linux World!");
  }
}

javac Test.java

java Test
```
