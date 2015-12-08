# Yarn 上的 Marp Reduce

## 一、 Yarn 上的 MarReduce 实体

```
1. 客户端: 提交 MapReduce 作业

2. Yarn ResourceManager: 资源管理器，负责协调集群上计算资源的分配

3. Yarn NodeManager: 节点管理器，负责启动和监视集群中机器上的计算容器 (container)

4. MapReduce 应用程序 master, 负责协调运行 MapReduce 作业的任务。
   它和 MapReduce 任务在容器(container) 中运行，这些容器由资源管理器(ResourceManager) 分配并由节点管理器(NodeManager)进行管理

5. 分布式文件系统 (HDFS)
```

## 二、MapReduce 工作机制

### 1、工作在 Yarn 上的 MapReduce

- [Yarn 上的 MapReduce](https://www.processon.com/view/link/56643e61e4b026a7ca2ac271)

### 2、shuffle 和排序

系统执行排序的过程称为 shuffle, 即将 Map 输出作为输入传给 reducer 的过程

![MapReduce shuffle](../file/mapreduce_shuffle.png)

```
Map 端 :
1) 环形内存缓冲区 buffer
  每个 Map 任务都有一个环形内存缓冲区 buffer，用于存储任务输出

2) combiner  组合器
  combiner 使得 map 输出结果更紧凑,因此减少写磁盘的数据和传递给 reduce 的数据

3) 压缩
  对 Map 输出进行压缩,可以增加写磁盘的的速度,减少传递给 reduce 的数量


Reduce 端 :


```

## 三、MapReduce 的类型与格式



### 四、MapReduce 的特性
