# Spark SQL - pyspark 接口文档

-  Spark SQL Python Doc Index : http://spark.apache.org/docs/1.4.1/sql-programming-guide.html

## * 客户端使用

### 一、sql 接口

- http://spark.apache.org/docs/1.4.1/api/python/pyspark.sql.html

``` python

from pyspark.sql import HiveContext
sqlContext = HiveContext(sc)

u'游标'
cursor = sqlContext.sql("use default")
cursor = sqlContext.sql("show tables")

u'输出结果'
print cursor.collect()

```

### 二、spark-sql 通过 JDBC 操作 hive 数据仓库

#### 1、安装 python 类包

- 可以直接使用 python 的 hiveServer2 客户端连接
- [hiveServer2 文档](https://cwiki.apache.org/confluence/display/Hive/Setting+Up+HiveServer2)

 ```
    1. 安装 : pip install pyhs2
    2. Thrift JDBC/ODBC server 实现对应于 HiveServer2 in Hive 0.13.  这是官方的说明，所以我们可以直接适用 hiveServer2 的客户端操作 Spark-Sql
 ```


#### 2、使用

- 开启 thrift-server 服务
- [spark thrift-jdbcodbc-serve 文档](http://spark.apache.org/docs/1.4.1/sql-programming-guide.html#running-the-thrift-jdbcodbc-server)

``` sh
cd $SPARK_HOME

./sbin/start-thriftserver.sh \
--master yarn \
--deploy-mode client \
--hiveconf hive.server2.thrift.port=10002


-- 内存不够的时候，不要使用！会拖慢整个集群的速度
./sbin/start-thriftserver.sh \
--master yarn \
--deploy-mode client \
--hiveconf hive.server2.thrift.port=10002 \
--driver-memory 5000M \
--executor-memory 4000M


JDBC 操作 hive
!connect jdbc:hive2://uhadoop-ociicy-master2:10002
```
