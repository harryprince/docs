# hadoop conf 优化

## 一、 core-site.xml

```xml
<!--
    <property>
        <name>io.compression.codecs</name>
        <value>org.apache.hadoop.io.compress.DefaultCodec,org.apache.hadoop.io.compress.GzipCodec,org.apache.hadoop.io.compress.BZip2Codec,com.hadoop.compression.lzo.LzoCodec,com.hadoop.compression.lzo.LzopCodec,org.apache.hadoop.io.compress.SnappyCodec</value>
    </property>
-->
    <!--压缩相关 -->
    <property>
        <name>io.compression.codec.lzo.class</name>
        <value>com.hadoop.compression.lzo.LzoCodec</value>
    </property>
```


## 二、mapred-site.xml

```xml
<!--增大内存解决oom -->
<property>
  <name>mapred.map.child.java.opts</name>
  <value>-Xmx512M</value>
</property>

<property>
  <name>mapred.reduce.child.java.opts</name>
  <value>-Xmx1024M</value>
</property>

```
