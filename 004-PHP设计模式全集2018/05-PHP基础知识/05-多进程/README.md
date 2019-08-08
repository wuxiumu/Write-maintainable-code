# PHP 多进程入门
## php多进程
php多进程是在开发业务逻辑层面,并行处理多个任务的一种开发方式,例如,需要给10万给会员发送邮件,每个邮件需要处理1秒,如果是一个进程处理,就得10万*1秒才能处理完,但是,如果开启多个进程同时处理,例如:10个进程,那只需要10万*1/10秒就能处理完成,缩短了10倍的时间

## 多进程的概念
前面有讲到,多进程主要是在开发业务逻辑层面,并行处理多个任务的开发方式,什么叫做开发业务逻辑层面呢?
在上面我们有讲到,php-fpm是fast-cgi的进程管理器,启动之后会启动多个fast-cgi进程,等待任务处理

在php-fpm软件层面,fast-cgi的多个进程就属于多进程处理,但是,当用户发起请求,由nginx交给php-fpm处理请求时,在这个层面,每个请求其实只占有一个php fast-cgi进程进行处理逻辑,对于运行业务逻辑的这个php进程,其实是单进程的.

同理,当我们直接运行一个php文件时,默认是只开启了一个php进程进行运行php的代码

## 多进程的开发场景
在传统web模式下,php一向是单进程处理业务逻辑,只有在php-cli模式下,用于处理异步任务,作为网络服务器时,才可能用到多进程处理,所以,大部分phper都对php多进程的概念不熟悉

## 伪多进程
在上面讲到,在传统web下,一个请求就是一个进程,我们可以通过这个方法,实现理论上的多进程:

- 在一个php文件中,写消费任务逻辑,比如给队列中的会员id发送邮件(注意超时,注意用户端关闭不终止脚本)
- 用网页访问这个php文件,相当于开启了一个进程处理
- 再开第二个网页访问这个文件,相当于又开启了一个进程
- 如此重复,我们可以得到n个处理邮件的进程
- 针对于消费任务逻辑层面,我们已经是开启了多进程在处理了

前言

在服务器跑脚本时，避免不了一些耗时任务，使用多进程是必不可少的。而在 PHP5.5 之后，PHP 开始加入了多进程元素，以满足开发需求。

注意

- 实现多进程需要开启的扩展：pcntl、 posix。
- Windows 环境下不支持 PHP 的多进程编程，本文主要在 Linux 环境下开发测试

## 一张简单结构图
![](/000-imgs/3188339-aa22e91e83bedea9.png)


## 主要功能
主要参考官方文档 [进程控制](http://php.net/manual/en/book.pcntl.php#book.pcntl)

1. pcntl_fork：创建多进程，调用后会返回两条进程的pid，0 为子进程，大于 0 为父进程（父进程得到子进程的 id，所以大于 0），-1为创建失败
```
$pid = $pcntlInstall ? pcntl_fork() : 0;

if ($pid == -1) {
    //fork失败
 } elseif ($pid > 0) {
    //父进程
    ......
 } elseif ($pid == 0) {
    //子进程
    ......
 }
 ```
2. pcntl_signal: 注册一个信号处理回调函数，可以捕获子进程结束时发出的信号
```
//配合pcntl_signal使用
declare (ticks = 1);

//当子进程退出时，会触发该函数,当前子进程数-1
pcntl_signal(SIGCHLD, function ($signo) {
    switch ($signo) {
        case SIGCHLD:
            echo $curChildPro . 'SIGCHLD', PHP_EOL;
            $curChildPro--;
            break;
    }
});
```
3. pcntl_wait: 用来暂停父进程，等待子进程退出

## 一个多进程的例子
该例子主要介绍了如何控制 同一时刻 进程 并发 的数量
```
$curChildPro = 0;
$maxChildPro = 5;  // 同一时刻最多 5 个进程

 //配合pcntl_signal使用
declare (ticks = 1);

//当子进程退出时，会触发该函数,当前子进程数-1
pcntl_signal(SIGCHLD, function ($signo) {
    global $curChildPro;
    switch ($signo) {
        case SIGCHLD:
            echo $curChildPro . 'SIGCHLD', PHP_EOL;
             $curChildPro--;
            break;
     }
});

$index  = 0;
while ($index < 10) {
    $index ++;
    $curChildPro++;
    echo "-------- current process" . $curChildPro . "--------\r\n";
    $pid = $pcntlInstall ? pcntl_fork() : 0;
    
    if ($pid == -1) {
        //fork失败
    } elseif ($pid > 0) {
        //达到上限时父进程阻塞等待任一子进程退出后while循环继续
        if ($curChildPro >= $maxChildPro) {
            pcntl_wait($status);
        }
    } elseif ($pid == 0) {
        //子进程   执行一些操作
        ......
        exit(); // 需要退出，避免产生僵尸进程
    }
}
```