[PHP的数组底层实现](https://blog.csdn.net/jwq101666/article/details/78548227)

[PHP建造一个高可用高性能的网站](https://blog.csdn.net/jwq101666/article/details/80162245)

[PHP 并发下的进程间通信](https://blog.csdn.net/jwq101666/article/details/78759936)

[大用户量访问情况下项目的各种优化方案](https://blog.csdn.net/jwq101666/article/details/78916469)

[nginx+php提示nginx error的解决办法](https://blog.csdn.net/jwq101666/article/details/79056772)

# php常用函数
 
## 一、写入文件
1. 打开资源（文件）fopen($filename,$mode)
2. 写文件fwrite($handle,$str)
3. 关闭文件fclose($handle)
4. 一步写入file_put_contents($filename,$str,$mode) FILE_APPEND LOCK_EX  

## 二、读文件
1. 读文件fread($handle,字节数) 
2. 读一行fgets($handle);
3. 读一个字符fgetc($handle)
4. 读成一个数组中file($filename)
5. 一步读取file_get_contents($filename)

## 三、 目录操作
1. 建目录mkdir($dirname)
2. 删除目录rmdir($dirname)
3. 打开目录句柄opendir($dirname)
4. 读取目录条数readdir($handle)
5. 关闭目录资源closedir($handle)
6. 重置目录资源rewinddir($dirname);

## 四、目录和文件操作
1. 检查文件或目录是否存在file_exists($filename)
2. 文件或者目录重命名rename($file)

## 五、 文件操作
1. 拷贝文件copy('原文件','目标文件')
2. 删除文件unlink($filename)
3. 获取文件大小filesize($filename)
4. 取得文件的创建时间filectime($filename)
5. 取得文件的访问时间fileatime($filename)
6. 取得文件的修改时间filemtime($filename)

## 六、路径操作
1. 获取路径dirname($path)
2. 获取文件名basename($path)
3. 获取路径信息pathinfo($path)

## 七、数组函数（极其重要）
1. 在数组的开头插入一个元素array_unshift($arr,$v) 
2. 在数组的尾部添加数组元素array_push($arr,$v,$v1...)
3. 将数组的第一个元素移出，并返回此元素array_shift($arr)
4. 在数组的尾部删除元素array_pop($arr)
5. 将数组用$separator连接成一个字符串implode($a,$arr)
6. 检测变量是否是数组is_array($arr)
7. 获得数组的键名array_keys($arr)
8. 获得数组的值array_values($arr)
9. 检索$value是否在$arr中，返回布尔值in_array($v,$arr)
10. 检索数组$arr中，是否有$key这个键名array_key_exists($k,$arr)
11. 检索$value是否在$arr中，若存在返回键名Array_search($value, $arr)
12. 将一个数组逆向排序，如果第二个参数为true，则保持键名Array_reverse($arr, true)
13. 交换数组的键和值 Array_flip($arr)
14. 统计数组元素的个数 Count($arr)
15. 统计数组中所有值的出现次数 Array_count_values($arr)
16. 移除数组中的重复值 Array_unique($arr)
17. 值由小到大排序 Sort($arr)
18. 值由大到小排序 Rsort($arr)
19. 键由小到大排序 ksort($arr)
20. 键由大到小排序 krsort($arr)
21. 随机从数组中取得$num个元素 Array_rand($arr, $num)
22. 对数组的所有元素求和Array_sum($arr)
23. 合并数组 array_merge($arr,$arr)

## 八、字符串函数（极其重要）

1. 输出字符串 echo($str) echo 
2. 原样输出（区分单引号和双引号） print($str)
3. 输出字符串，结束脚本执行 Die($str):die($str) die;
4. 输出字符串，结束脚本执行 exit($str) exit;
5. 输出格式化字符串 printf($str,$p1,...)
6. 不直接输出格式化的字符串，返回格式化的字符串，保存到变量中 sprintf($str,$p1,...)
7. 打印变量的相关信息 var_dump($p)
8. 字符串转换为小写 strtolower($str)
9. 字符串转换为大写 strtoupper($str)
10. 将字符串的第一个字符转换为大写 ucfirst($str)
11. 将字符串中每个单词转换为大写 ucwords($str)
12. 去除字符串两端的空白字符。 Trim($str,' ,')
13. 去除字符串左边空白字符。 Ltrim($str)
14. 去除字符串右边空白字符。Rtrim($str)空白字符：""，"\t"，"\n"，"\r"，”\0” 
15. 取得字符串长度 strlen($str)
16. 统计包含的字符串个数 substr_count($str,’子串’)
17. 返回字符串$string中由$start开始，长度为$length的子字符串Substr($string ,$start[,$length])
18. 返回字符串$string中，$search第一次出现到字符串结束的子字符串。Strstr($string,$search)
19. 查找$search在$str中第一次位的置，从$offset开始。 Strpos($str,$search[,int $offset])
20. 查找$search在$str中最后一次的位置，从$offset开始 Strrpos($str,$search[,int $offset])
21. 替换$str中的全部$search为 $replace。 Str_replace($search,$replace,$str)
22. 重复输出指定的字符串 Str_repeat()
23. 加密字符串 Md5()
24. 字符串翻转 Strrev()
25. 使用一个字符串分割另一个字符串,形成一个数组//把字符串变成数组 Explode(“分隔符”,$str);

## 九、PHP常用的数组函数：
 
1. 数组生成与转化:
    - array() 

        生成一个数组 

        array(mixed [...]) 

        【数组】一个数组型变量
 
array_combine()
生成一个数组,用一个数组的值作为键名,另一个数组值作为值
array_combine(数组1，数组2)
【数组】合成的型数组
 
range()
建立一个指定范围单元的数组
 range(mix $low,mix $high,[num $step])
【数组】合成的数组
 
compact()
建立一个数组,包括他们的变量名和值
compact(mix $varname,[,mix $...])
【数组】返回由变量名为键,变量值为值的数组,变量也可以为多维数组.会递归处理
 
array_fill()
用给定值生成数组
array_fill(int $start,
int $num,
mix $value)
返回完成的数组
$a=array_fill(5,6,'hello');//为数组$a从第5个元素开始添加6个hello
print_r($a);
数组合并和拆分：
 	 	 	 
array_chunk()
将一个数组分成多个数组
array_chunk(arr $input,int $size[,bool $preserve_keys])
分割后的多维数组
$a=array('a','b','c','d','e');
$b=array_chunk($a,2,true);
print_r($b);
array_merge()
合并一个或多个数组.如果元素的键相同,则前面的将被后面的覆盖,索引的序列不会覆盖,只会自动增加
array_merge
(数组1，数组2...])
返回完成的数组
array_merge($arr1,$arr2);
array_slice()
从数组中取出一段,返回截取值的数组
array_slice
(目标数组,截取位置[截取长度【是否保留原有键】)
返回被截取的【数组】
array_slice($array, 2, -1, true)
数组比较操作：
 	 	 	 
array_diff()
计算两个数组的差集,返回一个数组
array_diff
(数组1，数组2，数组3.....)
返回第一个【数组】，计算差集
 
array_intersect()
计算数组的交集
array_intersect
(数组1，数组2，数组3....])
比较几个数组元素值的交集
 
 	 	 	 	 
数组查找替换操作：
 	 	 	 
array_search()
搜索给定的值，如果成功则返回相应的键名
array_search(搜索的值，目标数组)
【键名】成功返回键名,失败返回false
$b=array_search(ta,$a);
array_splice()
把数组中一部分去掉用其他值替代
array_splice(目标数组,开始位置【截取长度【替换的值可为数组】】)
函数本身返回的是截取的【数组】并且改变了原数组.把截取的内容，替换为需要的值原【数组被改变】
注：原数组         
已经被改变
array_sum()
计算数组中所有数值的和
array_sum
(目标数组)
返回求和【整形】
 
in_array()
查找数组中是否存在某个值,区分大小写
in_array
(查找的值,目标数组)
返回是否查到布尔值
$a=array('name','sex','age');
$b=in_array('sex',$a);
print_r($b);
array_key_exists()
检查数组中是否存在某个键
array_key_exists
(键值,目标数组)
返回是否查到布尔值
$a=array('one'=>2,
'two'=>3,
'three'=>3);
$b=array_key_exists('one',$a);
print_r($b);
数组指针操作:
 	 	 	 
key()
当前指针所在位置的键
 	 	 
current()
当前指针所在位置的值
 	 	 
next()
指针向后移动一个
 	 	 
prev()
指针向前移动一个
 	 	 
end()
指针指向最后一个
 	 	 
reset()
指针回到开始处
 	 	 
list()
把数组中的值赋给变量
list($one,$two,$three...])=arr $array
 	
只可以使用键值连续的数组
array_shift()
弹出数组前面的元素
 	 	 
array_unshift()
向前插入一些元素
 	 	 
array_push()
数组最后压入多个元素
int array_push(arr &$array,mix $var1[,$var2...])
返回1为成功,0为失败
直接对目标数组操作
array_pop()
数组最后弹出一个元素
mix array_pop(arr &$array)
返回被弹出的元素值
直接对目标数组操作
数组键值操作:
 	 	 	 
shuffle()
将数组打乱,保留键名
bool shuffle(arr &$array)
返回true
打乱顺序后键名不会有变化
count()
计算数组中的单元数目或对象中的属性个数
 	 	 
array_flip()
交换数组中的键和值
arr array_flip(arr $trans)
返回完成的键值相反的数组
 
array_keys()
返回数组所有的键,组成一个数组
array_keys(arr $input[,mix $search[,bool $str]])
返回键名组成的【数组】
$a=array('name','sex','age');
$b=array_keys($a);
print_r($b);
array_values()
返回数组中所有值，组成一个数组
array_values (目标数组)
键名去除，值组成的新 【数组】
$a=array('name','sex','age');
$b=array_keys($a);
print_r($b);
array_reverse()
返回一个元素顺序相反的数组
array_reverse(目标数组，【是否保留原有的键名顺序，true or false】)
顺序相反的一个【数组】
 
array_count_values()
 统计数组中所有的值出现的次数
array_count_values(目标数组)
用input的值做键,该值出现次数做值的数组
$a=array(1,'hello','1','php','hello');
$b=array_count_values($a);
print_r($b);
array_rand()
从数组中随机抽取一个或多个元素,注意是键名!!!
array_range(目标数组【选取的单元数】)
选取一个返回一个单元，【选取多个返回的数组】
array_rand($a,2)
each()
 	 	 	 
array_unique()
移除数组中的重复值
array_unique(目标数组)
键名保留不变的返回无重复值数组
 
对数组进行排序:
 	 	 	 
sort()
按升序对给定数组的值排序不保持索引关系
sort(目标数组)
成功返回真，失败为假  【布尔型】
对数组值进行重排,同时去除键名
rsort()
对数组进行逆向排序
rsort(目标数组)
成功返回真，失败为假  【布尔型】
对数组进行逆向重排,同时改变键名
asort()
按元素的值由小到大排序,保持索引关系
asort(目标数组)
成功返回真，失败为假 
 【布尔型】
对数组进行排序,保留原来的索引或键
arsort()
对数组进行逆向排序    并保持索引关系
arsort(目标数组)
成功返回真，失败为假 
 【布尔型】
对原数组进行操作，键名保持不变
ksort()
按照键名由小到大排序
ksort(目标数组)
成功返回真，失败为假  
【布尔型】
对键名排序,保留键值对应关系
krsort()
对数组按照键名逆向排序
krsort(目标数组)
成功返回真，失败为假 
 【布尔型】
按照键名大小逆向排序
natsort()
自然顺序，区分大小写
natsort(目标数组)
成功返回真，失败为假  
【布尔型】
对值进行自然排序,保留键值对应关系
natcasesort()
自然排序,不区分大小写
natcasesort(目标数组)
成功返回真，失败为假 
 【布尔型】
不区分大小写自然法排序,保持键值对应关系
array_filter
回调函数过滤数组
array(目标数组,'callback函数')
返回被过滤后的数组
 
array_map
 	 	 	 
