[网络CDN加速及其原理](https://blog.csdn.net/jwq101666/article/details/78575370)

[浏览器禁用Cookie后PHP怎样实现session会话保持](https://blog.csdn.net/jwq101666/article/details/78759316)

[http与https的区别到底有哪些](https://blog.csdn.net/jwq101666/article/details/78907256)


# session与cookie的区别浅析

 session 是一个抽象概念,我们开发时为了实现中断和继续等操作，将用户和代理服务器之间一对一的交互，抽象为“会话”，进而衍生出 


      一种会话状态。而 cookie是一个实际存在的东西，可以认为是 session 的一种后端无状态实现。session 因为 session id 的存在，  


    通常要借助 cookie 实现，但这并非必要，只能说是通用性较好的一种实现方案。cookie存放的数据保存在客户端，session的方案是把    


  数据保存在服务器端.cookie不是很安全，别人可以分析存放在本地的COOKIE并进行COOKIE欺骗,考虑到安全应当使用session。session会在   


  一定时间内保存在服务器上。当访问增多，会比较占用你服务器的性能,考虑到减轻服务器性能方面，应当使用COOKIE。单个cookie保存的     


  数据不能超过4K，很  多浏览器都限制一个站点最多保存20个cookie。可以将登陆信息等重要信息存放在SESSION 其他信息如果需要        


保留，可以放在COOKIE中  ； 

## 一、session
翻译：会话。

存放位置：服务器端

时长：默认存在时长为半小时。

作用：表示用户登录访问某个网站时，实际上是用户与服务器在会话。常用于验证用户是否已经登录：
```
HttpSession session = request.getSession();
session.setAttribute("isLogin", true);
```
用户再次访问时，tomcat在会话对象中查看登录状态：
```
HttpSession session = request.getSession();
session.getAttribute("isLogin");
```

## 二、cookie
翻译：饼干。

存放位置：由服务器端发出，存放于客户端（比如浏览器）

时长：可以根据需要，在浏览器中定时设置清除cookie信息，比如退出浏览器时清除cookie

作用：只存放于A浏览器中，在B浏览器中访问，不会出现A浏览器的cookie信息。

用户登录或者未登录的情况下都可以存放的用户信息，下次浏览网页可以直接显示数据。浏览器发送http请求时自动附带cookie信息，常用于单点登录。



## 三、cache
翻译：电脑高速缓冲存储器。

存放位置：客户端

时长：保存的时间同cookie

作用：同样的，只存放于A浏览器中，在B浏览器中访问，不会出现A浏览器的cache信息。用户在访问网页时，保存该网页的页面以及数据。比cookie多存储了页面和css样式。这样，当用户关闭页面或者退出A浏览器之后，再次通过A浏览器访问页面时，打开速度变得比之前快很多（比如视频中的缓存）。
 