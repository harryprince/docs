# MapReduce1

## 一、介绍

- 分布式计算框架

## 二、原理

- [官方文档](http://hadoop.apache.org/docs/r1.0.4/cn/mapred_tutorial.html)

### 1. JobTracker 和 TaskTracker

- JobTracker

  ```
  Map-reduce 框架的中心,他需要与集群中的机器定时通信 (heartbeat),
  需要管理哪些程序应该跑在哪些机器上，需要管理所有 job 失败、重启等操作
  ```
- TaskTracker

  ```
  是 Map-reduce 集群中每台机器都有的一个部分，他做的事情主要是监视自己所在机器的资源情况
  TaskTracker 同时监视当前机器的 tasks 运行状况。
  TaskTracker 需要把这些信息通过 heartbeat 发送给 JobTracker，
  JobTracker 会搜集这些信息以给新提交的 job 分配运行在哪些机器上。
  ```


### 2、工作流程

其中 Map 是寻址，Reduce 是计算，客户端提交任务给 JobTracker ，Job racker 会取把任务分配给对应的

TaskTracker 去 map 和 reduce 后，把结果返回给  JobTracker
