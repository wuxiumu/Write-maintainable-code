>前两天接到一个需求，做一个群发功能。一次需要群发给几万个用户，其实就是批量调用一个 http 接口，相信大部分同学都做过。

我首先想到的是使用 curl_multi （也就是 guzzle 的异步调用接口）实现。curl_multi 是使用了多线程来实现并发，但是自己测试大概 1000 条左右 http 请求就用到了 40 秒左右。后续呈线性增长，这个速率远不能满足发送几万条 http 请求的需求。

接下来自然而然的就想到了多进程处理，网上查了一下大多使用 pcntl_fork() 来实现多进程，该函数需要安装 php 扩展。安装 php 扩展对于我这里的环境并不方便（甚至说难以实现），所以这个方法被 cut 掉。

于是承接上面的 curl 想到了用 http 请求自己的 api 来实现开启多进程，实验代码如下

producer.php
```
<?php

echo microtime(true).'<br>';

$url = 'http://localhost/consumer.php';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, 1);

curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
curl_setopt($curl, CURLOPT_TIMEOUT_MS, 200); //超时等待时间为200ms

curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($curl);
curl_close($curl);

echo microtime(true);
```
consumer.php
```
<?php
ignore_user_abort(true); //客户端断开链接后，php脚本继续运行. 这行代码可能有点多余，但是无法准确的证明，所以先留着
set_time_limit(0); //保证程序长时间运行不中断

while(true) {
    file_put_contents('./date', time());
    sleep(2);
}
```
producer.php（生产端）中的 curl_setopt($curl, CURLOPT_TIMEOUT_MS, 200); 使 http 链接运行 200 毫秒后中断。生产端中断后，consumer.php (消费端) 依旧在运行，因此通过 curl 多次调用 comsumer.php 来达到开启多个消费进程的目的。

这也是种一生产者 / 多消费者的思路，在 redis 的 list 为数据支撑的情况下，可以高效应对高并发时的数据处理。

当然高效的数据处理往往也对应着很高的服务器压力，虽然上面的多进程思路在负载均衡环境下会有神秘的加成

对于 ignore_user_abort(true); 的使用我是心存很大的疑惑的，我各种情况的测试下发现这个函数并没有什么用，测试的结果是 php 脚本的运行并不会受到 http 请求中断的影响，不知道是否是因为测试环境为 nginx 的影响

tree-ql 意在代替 dingo/api，帮助你开发高可用的 API