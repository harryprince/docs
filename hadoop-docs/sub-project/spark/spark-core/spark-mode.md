# Spark-mode 运行模式

## 一、介绍

- spark 是一个基于内存计算的开源的集群计算系统

 ```
  Spark提供的数据集操作类型有很多种，不像Hadoop只提供了Map和Reduce两种操作。
  比如 map,filter, flatMap,sample, groupByKey, reduceByKey, union,join,cogroup,mapValues,sort,partionBy 等多种操作类型，他们把这些操作称为 Transformations。同时还提供 Count,collect, reduce, lookup, save 等多种 actions
 ```

### 1. spark 工作角色

```
Client :
  客户端进程，负责提交作业到 Master。

Master :
  负责接收 Client 提交的作业，管理 Worker，并命令 Worker 启动 Driver 和 Executor。

Worker :
  slave 节点上的守护进程，负责管理本节点的资源，定期向 Master 汇报心跳，接收 Master 的命令，启动 Driver 和 Executor。

Driver :
  一个 Spark 作业运行时包括一个 Driver 进程，也是作业的主进程，负责作业的解析、生成 Stage 并调度 Task 到 Executor 上。包括 DAGScheduler,TaskScheduler。

Executor :
  即真正执行作业的地方，一个集群一般包含多个 Executor，每个 Executor 接收 Driver 的命令 Launch Task，一个 Executor 可以执行一到多个 Task。
```

## 二、运行模式以及环境


### 1、standalone 独立模式

- 自带完整的服务，可单独部署到一个集群中，无需依赖任何其他资源管理系统
- Spark://hostname:port:Standalone 需要部署 Spark 到相关节点，URL 为 Spark Master 主机地址和端口。

```
从一定程度上说，该模式是其他两种的基础。
借鉴Spark开发模式，我们可以得到一种开发新型计算框架的一般思路：
先设计出它的standalone模式，为了快速开发，起初不需要考虑服务（比如master/slave）的容错性，之后再开发相应的wrapper，将stanlone模式下的服务原封不动的部署到资源管理系统yarn或者mesos上，由资源管理系统负责服务本身的容错。
目前Spark在standalone模式下是没有任何单点故障问题的，这是借助zookeeper实现的，思想类似于Hbase master单点故障解决方案。将Spark standalone与MapReduce比较，会发现它们两个在架构上是完全一致的：

1) 都是由master/slaves服务组成的，且起初master均存在单点故障，后来均通过zookeeper解决（Apache MRv1的JobTracker仍存在单点问题，但CDH版本得到了解决）；
2) 各个节点上的资源被抽象成粗粒度的slot，有多少slot就能同时运行多少task。不同的是，MapReduce将slot分为map slot和reduce slot，它们分别只能供Map Task和Reduce Task使用，而不能共享，这是MapReduce资源利率低效的原因之一，而Spark则更优化一些，它不区分slot类型，只有一种slot，可以供各种类型的Task使用，这种方式可以提高资源利用率，但是不够灵活，不能为不同类型的Task定制slot资源。总之，这两种方式各有优缺点。
```

### 2、Spark On Mesos 模式

- Mesos：一个开源的分布式弹性资源管理系统
 - http://dongxicheng.org/category/apache-mesos/
- Mesos://hostname:port:Mesos 需要部署 Spark 和 Mesos 到相关节点，URL 为 Mesos 主机地址和端口

```
这是很多公司采用的模式，官方推荐这种模式（当然，原因之一是血缘关系）。
正是由于Spark开发之初就考虑到支持Mesos，因此，目前而言，Spark运行在Mesos上会比运行在YARN上更加灵活，更加自然。
目前在Spark On Mesos环境中，用户可选择两种调度模式之一运行自己的应用程序（可参考Andrew Xia的“Mesos Scheduling Mode on Spark”）：
```

#### 2.1 粗粒度模式（Coarse-grained Mode）

- 固定分配资源

```
每个应用程序的运行环境由一个 Dirver 和若干个 Executor['eksikju:tə] 组成
其中，每个 Executor 占用若干资源，内部可运行多个Task（对应多少个“slot”）。
应用程序的各个任务正式运行之前，需要将运行环境中的资源全部申请好，且运行过程中要一直占用这些资源，即使不用，最后程序运行结束后，回收这些资源。举个例子，比如你提交应用程序时，指定使用5个executor运行你的应用程序，每个executor占用5GB内存和5个CPU，每个executor内部设置了5个slot，则Mesos需要先为executor分配资源并启动它们，之后开始调度任务。另外，在程序运行过程中，mesos的master和slave并不知道executor内部各个task的运行情况，executor直接将任务状态通过内部的通信机制汇报给Driver，从一定程度上可以认为，每个应用程序利用mesos搭建了一个虚拟集群自己使用。
```

#### 2.2 细粒度模式（Fine-grained Mode）

- 弹性分配资源

```
鉴于粗粒度模式会造成大量资源浪费，Spark On Mesos还提供了另外一种调度模式：细粒度模式，这种模式类似于现在的云计算，思想是按需分配。
与粗粒度模式一样，应用程序启动时，先会启动 executor，但每个executor占用资源仅仅是自己运行所需的资源，不需要考虑将来要运行的任务，之后，mesos会为每个executor动态分配资源，每分配一些，便可以运行一个新任务，单个Task运行完之后可以马上释放对应的资源。每个Task会汇报状态给Mesos slave和Mesos Master，便于更加细粒度管理和容错，这种调度模式类似于MapReduce调度模式，每个Task完全独立，优点是便于资源控制和隔离，但缺点也很明显，短作业运行延迟大。
```


### 3、Spark On YARN 模式 (社区活跃，与 hadoop 开源生态圈融合性高)

- 运行在 Yarn 资源管理框架上的

```
这是一种最有前景的部署模式。但限于YARN自身的发展，目前仅支持粗粒度模式（Coarse-grained Mode）。
这是由于YARN上的Container资源是不可以动态伸缩的，一旦Container启动之后，可使用的资源不能再发生变化，不过这个已经在YARN计划（具体参考：https://issues.apache.org/jira/browse/YARN-1197）中了
```

#### 3.1 Yarn cluster / YARN standalone 集群模式

- driver 和 executors 都运行在 yarn 上
- Yarn-Standalone模式相对其它模式有些特殊，需要由外部程序辅助启动APP。用户的应用程序通过org.apache.spark.deploy.yarn.Client启动

```
Client 通过 (Yarn Client API) 在 Hadoop 集群上启动一个Spark ApplicationMaster，Spark ApplicationMaster 首先注册自己为一个 YarnApplication Master，之后启动用户程序，SparkContext在用户程序中初始化时，使用CoarseGrainedSchedulerBackend配合YarnClusterScheduler,YarnClusterScheduler只是对TaskSchedulerImpl 的一个简单包装，增加对Executor的等待逻辑等。
```

#### 3.2 YARN client 客户端模式 (我们目前使用的模式)

- 其资源分配是交给 Yarn 的 ResourceManager 来进行管理的
- driver 运行在提交任务的 client 上，executors 运行在 yarn 上
- Yarn-client 模式中，SparkContext 运行在本地，该模式适用于应用APP本身需要在本地进行交互的场合，比如Spark Shell，Shark等

```
Yarn-client模式下，会在集群外面启动一个ExecutorLauncher来作为driver，并向集群申请 Yarn Container[kən'teɪnə]容器，来启动CoarseGrainedExecutorBackend，并向CoarseGrainedSchedulerBackend中的DriverActor进行注册。

Yarn-client模式下，SparkContext在初始化过程中启动YarnClientSchedulerBackend（同样拓展自CoarseGrainedSchedulerBackend）
该Backend进一步调用org.apache.spark.deploy.yarn.Client在远程启动一个WorkerLauncher作为Spark的Application Master，相比Yarn-standalone模式，WorkerLauncher不再负责用户程序的启动（已经在客户端本地启动），而只是启动Container运行CoarseGrainedExecutorBackend与客户端本地的Driver进行通讯，后续任务调度流程相同
```

### 4、Local[N]：本地模式

- 使用 N 个线程。


### 5、Local Cluster[Worker,core,Memory]

- 伪分布式模式，可以配置所需要启动的虚拟工作节点的数量，以及每个工作节点所管理的 CPU 数量和内存尺寸
