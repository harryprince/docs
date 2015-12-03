# hive-udf

## 参考资料

- 官方文档 ：https://cwiki.apache.org/confluence/display/Hive/LanguageManual+UDF
- 其他文档 ：http://lxw1234.com/archives/2015/06/251.htm

## * 数组


### 1、collect_set

- 返回一组对象,消除重复的元素。

``` sql

collect_set(app_name)[0]

案例
SELECT
  user_id,
  -- 返回一组对象,消除重复的元素。
  collect_set(app_name)[0]
FROM
  dw_db.dw_app_access_log
WHERE
    user_id <> ''
  AND
    app_name IN ('a-broker','i-broker')
  AND
    p_dt = ${dealDate}
GROUP BY
  user_id
;

```


### 2、ROW_NUMBER

- 返回一行的顺序号的结果集的一个分区中，从1开始的每个分区中的第一行。
 - 人话[按照指定规则(如 OVER)，返回行出现的次数]
- [案例](http://blog.csdn.net/yangjun2/article/details/9339641)

``` sql

-- 语法
ROW_NUMBER() OVER (
    -- 分区规则
    PARTITION BY
      [filed]
    ORDER BY
      [ts] DESC
  ) AS [recent_click]


-- 使用场景，排重重复数据
SELECT
  user_id,
  app_name
FROM (
  -- 拿出排序好的结果集
  SELECT
    s_1.user_id,
    s_1.app_name,

    ROW_NUMBER ()
      -- OVER 表示规则
      OVER (
        -- 先对 user_id 进行类似 GROUP BY 操作
        PARTITION BY
          s_1.user_id
        -- 再按照时间排序  
        ORDER BY
          s_1.date_time
        DESC
      ) AS row_num
  FROM
    demo_table_1 AS s_1
) AS t_1

-- 再把排名好的结果集，第一名的拿出来
WHERE
  t_1.row_num = 1
;


-- 或者使用 distribute by
SELECT
  t_1.user_id,
  t_1.app_name
FROM (
  SELECT
    s_1.user_id,
    s_1.app_name,
    ROW_NUMBER ()
      OVER (
        DISTRIBUTE BY
          s_1.user_id
        SORT BY
          s_1.time
        DESC
      ) AS row_num
    FROM
      demo_table_1 AS s_1
) AS t_1

WHERE
  t_1.row_num = 1
;
```


## * 字符串类

### 1、regexp_extract

- 正则匹配截取

``` sql

SELECT
  current_page,
  -- 把括号内匹配到的内容截取出来
  regexp_extract(current_page,'^/broker/sh_([1-9]+)/$',1) AS broker_id
FROM
  dw_db.dw_web_visit_traffic_log
WHERE
    p_dt = '2015-06-11'
  AND
    current_page RLIKE '^/broker/sh_[1-9]+/$';
```


### 2、CONCAT_WS

- 数组拼接成字符串

``` sql

-- 案例 1, 直接使用
SELECT
  CONCAT_WS(',',device_id) AS device_ids
FROM
  dw_db.dw_app_access_log
WHERE
    p_dt='2015-06-18'
  AND
    user_id <> ''
GROUP BY
  user_id,
  device_id
;

-- 案例 2,用 collect_set(会去除重复的组) 把统计分组后的行，合并到列中
SELECT
  CONCAT_WS(',',COLLECT_SET(device_id)) AS device_ids
FROM
  dw_db.dw_app_access_log
WHERE
    p_dt='2015-06-18'
  AND
    user_id <> ''
GROUP BY
  user_id
;

```

### 3、COALESCE

- Returns the first v that is not NULL, or NULL if all v's are NULL.

``` sql
SELECT
  -- 当 a 为 null,使用 b 的值。或者当 b 的值为 null 使用 c 的值，以此类推
  COALESCE(t_1.a,t_1.b,t_1.c) AS n,
FROM
  table_1 AS t_1

```

### 4、split

- 把字符串，分割成数组

``` sql
SELECT
  split(request_uri,'\\?')[0] AS n
FROM
  table_1 AS t_1

```

### 5、concat
- 组合字符串

``` sql

SELECT
  concat (t_1.a,',',t_2.b) AS n
FROM
  table_1 AS t_1


```

### 6、parse_url

- 截取URL

``` sql
URL:
http://m.angejia.com/sale/sh_minhang_meilong/?pi=uc-cpc-esfwap-sh-jingpin&utm_term=爱屋吉屋二手房&city_id=1&defaultLimit=10&limit=10&page=1


案例 1,截取 utm_term 的值
parse_url(current_full_url,'QUERY','utm_term')

案例 2,截取 值 并且转换为中文字符
java_method("java.net.URLDecoder", "decode",parse_url(current_full_url,'QUERY','utm_term'),'utf-8') AS china


案例 3
parse_url(url, partToExtract[, key]) - extracts a part from a URL
解析URL字符串，partToExtract的选项包含[HOST,PATH,QUERY,REF,PROTOCOL,FILE,AUTHORITY,USERINFO]。
举例：
* parse_url('http://facebook.com/path/p1.php?query=1', 'HOST')返回'facebook.com'
* parse_url('http://facebook.com/path/p1.php?query=1', 'PATH')返回'/path/p1.php'
* parse_url('http://facebook.com/path/p1.php?query=1', 'QUERY')返回'query=1'，
可以指定key来返回特定参数，例如
* parse_url('http://facebook.com/path/p1.php?query=1', 'QUERY','query')返回'1'，

* parse_url('http://facebook.com/path/p1.php?query=1#Ref', 'REF')返回'Ref'
* parse_url('http://facebook.com/path/p1.php?query=1#Ref', 'PROTOCOL')返回'http'

```


## * Date 函数

### 1、unix_timestamp

``` sql
1.unix_timestamp() 获取当前时间戳

2.unix_timestamp(string date) 获取这种日期格式的时间戳
  案例
  unix_timestamp('2009-03-20 11:30:01')

3.unix_timestamp(string date, string pattern) 获取指定格式的时间戳
  案例
  unix_timestamp('2009-03-20', 'yyyy-MM-dd') = 1237532400
```

### 2、from_unixtime

``` sql

时间戳转换日期

1.格式
  yyyy-MM-dd HH:mm:ss

  from_unixtime(1440409548,'yyyy-MM-dd HH:mm:ss')

```


## * Obj 函数

### 1、get_json_object

- 解析字段的字符串的 json 对象

``` sql
SELECT
  get_json_object(desc,'$.hash') AS hash
FROM
  dw_db_temp.angejia__image_desc
LIMIT
  10;
```

## * 复合类型

- map
- struct
- array

### 1、array

``` sql

-- 把行的数据，塞到一列中
CREATE TABLE array_test_1 AS  
SELECT
  ARRAY(  
  id,
  name ) AS all_col_data
FROM
  source_table
LIMIT 2;

-- 查询所有
SELECT * FROM array_test_1;
-- 访问某个值
SELECT all_col_data[0] FROM array_test_1 LIMIT 10;

-- 把列中数据，都按照行输出
SELECT
  explode(all_col_data) AS all_1
from
  source_table;


-- posexplode 对一列的数据，按照数据打印，每次从 1 开始
SELECT
  posexplode(all_col_data) AS  (pos, col_data)
from
  source_table;


-- 格式化输出
  SELECT
    'aaa' AS a,
    row_list
  FROM
    array_test_1 AS t_1
  -- 列转行成为行显示
  lateral view
    -- 分割成数组
    explode (
      t_1.all_col_data
    ) now_row_list AS row_list;

```


### 2、map

``` sql

-- 把行的数据，塞到一列中
CREATE TABLE map_test_1 AS  
SELECT
  MAP(
  'id',id,
  'name',name
   ) AS all_col_data
FROM
  source_table
LIMIT 2;

-- 查询所有
SELECT * FROM map_test_1;
-- 查询某个键下的数据
SELECT all_col_data['id'] FROM map_test_1 LIMIT 10;

-- 把列中数据，都按照行输出
SELECT
  -- key_name , value_name 表示输出到列的字段名
  explode(all_col_data) AS (key_name , value_name)
FROM
  map_test;
-- 或者不写也可以  
SELECT
  explode(all_col_data)
FROM
  map_test;

```
