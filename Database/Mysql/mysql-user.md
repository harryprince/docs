# mysql 用户

## 一、创建用户

``` sh
语法：{username}用户名 @ {host}可访问地址 {password}密码
CREATE USER 'username'@'host' IDENTIFIED BY 'password';

1) 创建任意远程连接账号
  CREATE USER 'test'@'%' IDENTIFIED BY  '123456'

2) 创建本地连接账号
  CREATE USER 'test1'@'localhost' IDENTIFIED BY '123456';

3) 创建指定host远程连接账号
  CREATE USER 'test3'@'180.166.126.94' IDENTIFIED BY '123456';

```

# 二、授权用户

- 授权本身，如果账号不存在也会创建账号，所以用授权来创建账号也不错
- [授权文章](http://blog.csdn.net/andy_yf/article/details/7487519)

``` sql
语法：{*.*} 数据库.表
GRANT ALL PRIVILEGES ON *.* TO '用户名'@'%' IDENTIFIED BY '登录密码' WITH GRANT OPTION;

1) 创建 test3 账号，授予任意host登录权限，并且授予所有数据库访问权限
  GRANT ALL PRIVILEGES ON *.* TO 'test3'@'%' IDENTIFIED BY '123456' WITH GRANT OPTION;


2) 授权 test1 账号 test 数据库权限
  GRANT ALL PRIVILEGES ON  test.* TO  'test1'@'localhost' WITH GRANT OPTION ;

3) 授权指定权限
  GRANT select on *.* to 'readonly'@'%' WITH GRANT OPTION;

```

# 三、显示所用用户

``` sh
SELECT DISTINCT CONCAT('User: ''',user,'''@''',host,''';') AS query FROM mysql.user;
```
