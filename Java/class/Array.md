# Array 数组

## 1、介绍

Java 数组几个特点
- 连续的
- 大小固定
- 数据类型完全一致 (如果是小的数据类型，可自动转换为大的数据类型)
- 数组是储存在堆上的对象，可以保存多个同类型变量

## 2、案例

### 2.1、定义数组

``` java

public class Test2 {

    public static void main(String[] args) {

        //静态初始化
        int[] arr = new int[10];
        arr[0] = 100;
        arr[1] = 200;
        arr[2] = '啊'; //小的类型，自动转换为大的

        int arr_length = arr.length;    //数组长度，10
        int arr_key3 = arr[2];
        System.out.println(arr_key3);


        //静态初始化
        int[] arr_two = {1,2,3,4,5,6,7};
        System.out.println(arr_two.length);

    }

}

```

### 2.2、 MAP

``` java
public class Test2 {

    public static void main(String[] args) {

        //1、定义 MAP
        Map<String, String> map_1 = new HashMap<String, String>();
        map_1.put("a", "第四条新闻");
        map_1.put("b", "第五条新闻");
        map_1.get("a");
        //循环
        for(Map.Entry<String, String> entry :map_1.entrySet()) {
            System.out.println(entry.getKey());
            System.out.println(entry.getValue());
        }


        //2、定义指定类型的，泛型 MAP
        Map<Integer,String> map_2 = new HashMap<Integer,String>();
        map_2.put(1,"a");
        map_2.put(2,"b");


        //3、定义指定的自定义对象 Map
        Map<Integer,NewsEntity> map_2 = new HashMap<Integer,NewsEntity>();
        map_2.put(1,new NewsEntity(1,"标题1"));
        map_2.put(2,new NewsEntity(2,"标题2"));
        map_2.get(1).getNewsname();
        //循环
        for(Map.Entry<Integer,NewsEntity> entry : map_2.entrySet()) {
          System.out.println(entry.getKey());
          System.out.println(entry.getValue().getNewsname());//答应出对象中的值
        }

        //4、LinkedHashMap
        Map<Integer,String> map_list = new LinkedHashMap<Integer,String>();
        map_list.put(1, "星期一");
        map_list.put(2, "星期二");
        map_list.put(3, "星期三");
        map_list.put(4, "星期四");
        map_list.put(5, "星期五");
        map_list.put(6, "星期六");
        map_list.put(7, "星期日");
        //循环 LinkedHashMap
        for(Map.Entry<Integer, String> entry: map_list.entrySet()) {
            System.out.print(entry.getKey() + ":" + entry.getValue() + "\t");
        }

    }

}

```


### 2.3 、 List

``` java

public class Test3 {

    public static void main(String[] args) {

        //定义 List
        List list_1 = new ArrayList();
        list_1.add(1);
        list_1.add("a");
        list_1.get(0);

        //定义明确类型的泛型 List
        List<String> list_2 = new ArrayList<String>();
        list_2.add("a");
        list_2.add("b");
        list_2.get(0);

        //定义自定义对象的 List
        List<NewsEntity> list_3 = new ArrayList<NewsEntity>();
        list_3.add(new NewsEntity(1,"标题1"));
        list_3.add(new NewsEntity(2,"标题2"));
        list_3.get(0).getNewsname();//获取对应下标的对象方法

    }

}
```


### 2、3 自定义对象数组

``` java

public class Test4 {

  public static void main (String[] args) {

        MyClass[] myClass = new MyClass[10];

        myClass[0] = new MyClass();
        myClass[0].setName("abc");

        System.out.println(myClass[0].getName());
    }
}
```
