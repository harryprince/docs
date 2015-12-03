# 配置


## 一、环境配置

``` sh

根据 tomcat 版本，在 bin/catalina.sh 中配置不同的 JAVA_HOME 路径，实际情况个根据安装的 JDK HOME 路径有关

 1.7 的
 JAVA_HOME="/Library/Java/JavaVirtualMachines/jdk1.7.0_75.jdk/Contents/Home"

 1.8 的
 JAVA_HOME="/Library/Java/JavaVirtualMachines/jdk1.7.0_75.jdk/Contents/Home"

```



## web.xml

## tomcat-users.xml

访问 manager 的用户

``` xml
<tomcat-users>
  <role rolename="manager"/>
  <user username="admin" password="admin" roles="manager"/>

  <role rolename="manager-gui"/>
  <user username="admin" password="admin" roles="manager-gui"/>

</tomcat-users>
```
