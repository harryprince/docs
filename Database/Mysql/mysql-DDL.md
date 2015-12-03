# Mysql 操作语法

## * 创建操作


```sql

*. 创建表
CREATE TABLE `demo_test` (
  `id` int(10) unsigned NOT NULL  AUTO_INCREMENT COMMENT '主键',
  `db_name` char(20) NOT NULL DEFAULT '' COMMENT '数据库名',
  `tb_name` char(20) NOT NULL DEFAULT '' COMMENT '数据表名',
  `im_type` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '导入方式',
  `is_snapshot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否快照',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建日期',
  PRIMARY KEY (`id`),
  KEY `idx_qy` (`db_name`,`tb_name`,`is_delete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

1、登录 mysql
	mysql -uroot -p514591
	show databases;

2、创建数据库
  CREATE DATABASE `hive` /*!40100 DEFAULT CHARACTER SET utf8 */

3、获取表中所有字段名
		select COLUMN_NAME from information_schema.COLUMNS
		where table_name = 'your_table_name'
		and table_schema = 'your_db_name';

4、查看表结构
		SHOW FULL FIELDS FROM oa_case_pics

5、字段子查询 (只能查询一条数据)
	 (SELECT SUM(count) FROM cms_vote  WHERE vid=t1.id) AS participants
	如：
	 	SELECT
						t1.id,
						t1.title,
						t1.state,
						(SELECT SUM(count) FROM cms_vote  WHERE vid=t1.id LIMIT 1) AS participants
			FROM
						cms_vote AS t1
		WHERE
						t1.vid=0
	ORDER BY
						t1.date DESC

6、条件子查询
		WHERE vid IN (SELECT id FROM cms_vote WHERE state=1);
		WHERE ct.nav in (SELECT
													id
										FROM
													cms_nav AS c
									WHERE
													c.pid='$this->nav')

7、筛选子查询
		ORDER BY
							(SELECT
									    	COUNT(*)
								FROM
									    	cms_comment AS c
							WHERE
									    	ct.id=c.cid) DESC


8、表连接
	SELECT n.name,n.title FROM app_group_user AS gu LEFT JOIN app_group_node AS gn ON gu.group_id = gn.group_id LEFT JOIN app_node AS n ON gn.node_id = n.id WHERE ( gu.user_id = 2 )


9、GROUP BY 语句
		GROUP BY 语句用于结合合计函数，根据一个或多个列对结果集进行分组。

		SELECT Customer,SUM(OrderPrice) FROM Orders
		GROUP BY Customer


10、HAVING 子句(对GROUP BY分组后的结果集进行帅选查询)
		在 SQL 中增加 HAVING 子句原因是，WHERE 关键字无法与合计函数一起使用。

		SELECT Customer,SUM(OrderPrice) FROM Orders
			GROUP BY Customer
			HAVING SUM(OrderPrice)<2000

		SELECT Customer,SUM(OrderPrice) FROM Orders
			WHERE Customer='Bush' OR Customer='Adams'
			GROUP BY Customer
			HAVING SUM(OrderPrice)>1500

	distinct 对 user_id 的记录只取一条
	select distinct(user_id),app_name from dw_stage.dw_app_access_log;


11、获取字段详细信息
		SELECT
	 column_name AS `列名`,
	 data_type   AS `数据类型`,
	 character_maximum_length  AS `字符长度`,
	 numeric_precision AS `数字长度`,
	 numeric_scale AS `小数位数`,
	 is_nullable AS `是否允许非空`,
	 CASE WHEN extra = 'auto_increment'
	   THEN 1 ELSE 0 END AS `是否自增`,
	 column_default  AS  `默认值`,
	 column_comment  AS  `备注`
	FROM
	 Information_schema.columns
	WHERE
	  table_Name='test_table';


12、复制表
	create table t2 like t1;							//创建表复制t1数据结构
	insert into t2 select * from t1;				//把t1表数据放入t2表中


13、字段操作
	表开头添加自增主键
		ALTER TABLE `test`
		ADD `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST
	表结尾添加字段
		ALTER TABLE `test` ADD `t` VARCHAR( 255 ) NOT NULL DEFAULT ''
	某个位置添加字段
		ALTER TABLE
			`test`
		ADD t_1 varchar(255) NOT NULL DEFAULT '' AFTER a,
		ADD t_2 varchar(255) NOT NULL DEFAULT '' AFTER t_1;
	删除字段
		ALTER TABLE `user_movement_log`
			drop column `Gatewayid`,
			drop column `Gatewayi2`;


```


## * 索引

- 3个索引中只能用一种索引

```sql
	- 主键联合索引，不允许重复
	PRIMARY KEY (`date_index`,`class_id`,`city_id`,`item_id`),

	- 索引
	KEY `idx_item_id` (`item_id`),

	- 联合索引
	KEY `idx_class_item` (`class_id`,`item_id`)
```


## * 存储过程

- 预先定义好SQL语句，在使用是调用存储过程
- 调用存储过程
	- EXECUTE 存储过程名


## * 触发器（DML和DDL触发器）

- 当表中出现增、删、改时，执行的SQL语句


## * 游标
- 对查找出的结果集进行逐行处理
