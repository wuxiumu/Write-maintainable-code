## php利用多进程处理任务
注：php多进程一般应用在php_cli命令行中执行php脚本，做进程任务时要检查php是否开启了pcntl扩展，（pcntl是process control进程管理的缩写）

pcntl_fork — 在当前进程当前位置产生分支（子进程）。
一个fork子进程的基础示例：
```
$pid = pcntl_fork();
//父进程和子进程都会执行下面代码
if ($pid == -1) {
    //错误处理：创建子进程失败时返回-1.
        die('could not fork');
} else if ($pid) {
        //父进程会得到子进程号，所以这里是父进程执行的逻辑
        pcntl_wait($status); //等待子进程中断，防止子进程成为僵尸进程。
} else {
        //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
}
```

如果一个任务被分解成多个进程执行，就会减少整体的耗时。
比如有一个比较大的数据文件要处理，这个文件由很多行组成。如果单进程执行要处理的任务，量很大时要耗时比较久。这时可以考虑多进程。

来看一道面试题，有一个1000万个元素的int数组，需要求和，平均分到4个进程处理，每个进程处理一部分，再将结果统计出来，代码如下
```
<?php

$arrint = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];//假设很多
$arrint = array_chunk($arrint,4,TRUE);
for ($i = 0; $i < 4; $i++){
    $pid = pcntl_fork();
if ($pid == -1) {
    die("could not fork");
} elseif ($pid) {
    echo $pid;
    echo "I'm the Parent $i\n";
} else {
    // 子进程处理
    // $content = file_get_contents("prefix_name0".$i);
    $psum = array_sum($arrint[$i]);
    echo $psum . "\n";分别输出子进程的部分求和数字，但是无法进行想加，因为进程互相独立
    exit;// 一定要注意退出子进程,否则pcntl_fork() 会被子进程再fork,带来处理上的影响。
    }
}
        
// 等待子进程执行结
while (pcntl_waitpid(0, $status) != -1) {
    $status = pcntl_wexitstatus($status);
    echo "Child $status completed\n";
}
```

上诉答案中，是把数组分为4个子数组分别用4个子进程去处理了，但是没有办法把所计算的结果相加，因为进程都是独立完成任务的，没有办法共享同一个（内存）变量，下面将引进消息队列来解决进程通信的问题
```
<?php
$arrint = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];//假设很多
$arrint = array_chunk($arrint,4,TRUE);//把数组分为4个

// 创建消息队列,以及定义消息类型(类似于数据库中的库)
$id = ftok(__FILE__,'m');//生成文件key，唯一
$msgQueue = msg_get_queue($id);
const MSG_TYPE = 1;
msg_send($msgQueue,MSG_TYPE,'0');//给消息队列一个默认值0，必须是字符串类型

//fork出四个子进程
for ($i = 0; $i < 4; $i++){
    $pid = pcntl_fork();
    if ($pid == -1) {
        die("could not fork");
    } elseif ($pid) {
        echo $pid;
        echo "I'm the Parent $i\n";
    } else {
        // 子进程处理逻辑，相互独立，解决办法，放到内存消息队列中
        $part = array_sum($arrint[$i]);
        implode_sum($part);//合成计算出的sum
        exit;// 一定要注意退出子进程,否则pcntl_fork() 会被子进程再fork,带来处理上的影响。
    }
}
        
function implode_sum($part){
    global $msgQueue;
    msg_receive($msgQueue,MSG_TYPE,$msgType,1024,$sum);//获取消息队列中的值，最后一个参数为队列中的值
    $sum = intval($sum) + $part;
    msg_send($msgQueue,MSG_TYPE,$sum);//发送每次计算的结果给消息队列
}
    
// 等待子进程执行结束
while (pcntl_waitpid(0, $status) != -1) {
    $status = pcntl_wexitstatus($status);
    $pid = posix_getpid();
    echo "Child $status completed\n";
}
    
//所有子进程结束后，再取出最后在队列中的值，就是int数组的和
msg_receive($msgQueue,MSG_TYPE,$msgType,1024,$sum);
echo $sum;//输出120
```