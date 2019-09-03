# 目录
1. [习惯养成](#习惯养成)
    1. [提交](##提交)
    2. [推送](##推送)
    3. [拉取](##拉取)
    4. [合并](##合并)
2. [分支管理](#分支管理)
3. [事前准备](#事前准备)
4. [开发流程](#开发流程)
5. [额外说明](#额外说明)

在 2005 年的某一天，Linux 之父 Linus Torvalds 发布了他的又一个里程碑作品——Git。

它的出现改变了软件开发流程，大大地提高了开发流畅度！

直到现在仍十分流行，完全没有衰退的迹象。

本文不是一篇 Git 入门教程，这样的文章一搜一大把，我是要从具体实践角度，尤其是在团队协作中，阐述如何去好好地应用 Git

。既然是讲在团队中的应用实践，我就尽可能地结合实际场景来讲述。

## 习惯养成

如果一个团队在使用 Git 时没有一些规范，那么将是一场难以醒来的噩梦！

然而，规范固然重要，但更重要的是个人素质，在使用 Git 时需要自己养成良好的习惯。

### 提交
 
如何去写一个提交信息，[《Git: 教你如何在Commit时有话可说》](http://mp.weixin.qq.com/s?__biz=MzAwNDYwNzU2MQ==&mid=401622986&idx=1&sn=470717939914b956ac372667ed23863c&scene=2&srcid=0114ZcTNyAMH8CLwTKlj6CTN&from=timeline&isappinstalled=0#wechat_redirect)中做了很好的说明。

在具体开发工作中主要需要遵守的原则就是「使每次提交都有质量」，只要坚持做到以下几点就 OK 了：

1. 提交时的粒度是一个小功能点或者一个 bug fix，这样进行恢复等的操作时能够将「误伤」减到最低；
2. 用一句简练的话写在第一行，然后空一行稍微详细阐述该提交所增加或修改的地方；
3. 不要每提交一次就推送一次，多积攒几个提交后一次性推送，这样可以避免在进行一次提交后发现代码中还有小错误。

假如已经把代码提交了，对这次提交的内容进行检查时发现里面有个变量单词拼错了或者其他失误，只要还没有推送到远程，就有一个不被他人发觉你的疏忽的补救方法——

首先，把失误修正之后提交，可以用与上次提交同样的信息。

![](https://ourai.ws/assets/posts/20160418/merge-commits-step-1-d826ccf6d579f429ae9fb2df963c7d04eaa367f995153a6918604be86f6c7d57.png)
修改前的提交记录


然后，终端中执行命令 `git rebase -i [SHA]`，其中 SHA 是上一次提交之前的那次提交的，在这里是 `3b22372`。

![](https://ourai.ws/assets/posts/20160418/merge-commits-step-2-26e94aa759fd181aa553021b70c094f09f50cba474e7e09ad3177a67c38912c5.png)
修改提交节点

最后，这样就将两次提交的节点合并成一个，甚至能够修改提交信息！

![](https://ourai.ws/assets/posts/20160418/merge-commits-step-3-3a2e490f9b4061870e56685530ed4698e53d36ed8d5b2d43e005e01338f9662c.png)
修改后的提交记录

谁说历史不可篡改了？前提是，**想要合并的那几次提交还没有推送到远程！**

### 推送

当自己一个人进行开发时，在功能完成之前不要急着创建远程分支。

### 拉取

请读张文钿所写的[《使用 git rebase 避免無謂的 merge》](当自己一个人进行开发时，在功能完成之前不要急着创建远程分支。)。

### 合并

在将其他分支的代码合并到当前分支时，如果那个分支是当前分支的父分支，为了保持图表的可读性和可追踪性，可以考虑用 `git rebase` 来代替 `git merge`；反过来或者不是父子关系的两个分支以及互相已经 `git merge` 过的分支，就不要采用 `git rebase` 了，避免出现重复的冲突和提交节点。

## 分支管理

Git 的一大特点就是可以创建很多分支并行开发。正因为它的灵活性，团队中如果没有一个成熟的分支模型的话，那将会是一团糟。
![](https://ourai.ws/assets/posts/20160418/shit-dde31e540c79ba96f74c51fa6eca53284f7daf0671f3df0d673f04aae0cf3f0f.jpg)
混乱的分支

要是谁真把这么乱的提交图表摆在我面前，就给他一个上勾拳！

### 分支模型

有个很成熟的叫「[Git Flow](http://nvie.com/posts/a-successful-git-branching-model/) 的分支模型，它能够应对 99% 的场景，剩下的那 1% 留给几乎不存在的极度变态的场景。

需要注意的是，**它只是一个模型，而不是一个工具；你可以用工具去应用这个模型，也可以用最朴实的命令行。所以，重要的是理解概念，不要执着于实行的手段。**

简单说来，Git Flow 就是给原本普普通通的分支赋予了不同的「职责」：

* **master**——最为稳定功能最为完整的随时可发布的代码；
* hotfix——修复线上代码的 bug；
* **develop**——永远是功能最新最全的分支；
* feature——某个功能点正在开发阶段；
* release——发布定期要上线的功能。

看到上面的「master」和「develop」加粗了吧？代表它们是「主要分支」，其他的分支是基于它们派生出来的。**主要分支每种类型只能有一个，派生分支每个类型可以同时存在多个。**各类型分支之间的关系用一张图来体现就是：

![](https://ourai.ws/assets/posts/20160418/git-workflow-release-cycle-4maintenance-fa8c36de20146856f0606d9b0cf2161204e0838ec2c4345c7d6c54bcd5c11e07.png)
Git Flow 模型

更多信息可参考 [xirong](https://github.com/xirong) 所整理的《[Git工作流指南](https://github.com/xirong/my-git/blob/master/git-workflow-tutorial.md) 》。

### 工具选择

一直不喜欢「＊＊最好用」这种命题，主观性太强，不会有一个结论。

对于工具的选择，我一直都是秉承「哪个能更好地解决问题就用哪个」这个原则。

所以，只要不影响到团队，用什么工具都是可以接受的。

但根据多数开发人员的素质情况来看，建议使用图形化工具，例如 [SourceTree](https://www.sourcetreeapp.com) 。

如果想用命令行，可以啊！先在心里问下自己：「我 Git 牛逼不？会不会惹麻烦给别人？」

在团队中应用 Git Flow 时，推荐使用 SourceTree 与 [GitLab](https://gitlab.com)  配合的形式：

1. 用 SourceTree 创建 feature 等分支以及本地的分支合并、删除；
2. 用 GitLab 做代码审核和远程的分支合并、删除。

SourceTree 和 GitLab 应该是相辅相成的存在，而不是互相取代。

## 事前准备

为了将一些规范性的东西和 Git Flow 的部分操作自动化处理，要对 SourceTree 和 GitLab 进行一下配置。

### SourceTree

按下 <kbd>command</kbd> + <kbd>,</kbd> 调出「Preferences」界面并切换到「Git」标签，勾选「Use rebase instead of merge by default for tracked branches」和「Do not fast-forward when merging, always create commit」。

![](https://ourai.ws/assets/posts/20160418/git-workflow-release-cycle-4maintenance-fa8c36de20146856f0606d9b0cf2161204e0838ec2c4345c7d6c54bcd5c11e07.png)
「Preferences」界面的「Git」标签

这样设置之后，在点「Pull」按钮拉取代码时会自动执行 `git pull --rebase`；并且，每次合并时会自动创建新的包含分支信息的提交节点。

接下来，点击工具栏中的「Git Flow」按钮将相关的流程自动化。如果没有特殊需求，直接按下对话框中的「OK」就好了。初始化完成后会自动切换到 develop 分支。

![](https://ourai.ws/assets/posts/20160418/setting-of-sourcetree-git-613778e7be5645f8e3aa76053fb340fd6429bbcaf46f10c478f8ecb1a94420f4.png)
初始化 git-flow 工具

这下再点「Git Flow」按钮所弹出的对话框就是选择创建分支类型的了。

### GitLab

在创建项目仓库后一定要把主要分支，也就是 master 和 develop 给保护起来。为它们设置权限，只有项目负责人可以进行推送和删除等操作。

![](https://ourai.ws/assets/posts/20160418/setting-for-protecting-branch-f2f89270126e14eb7d7038c30bb684bc0ea51a7ce0faee372feadb9fd7387a3d.jpg)
设置保护分支

被保护的分支在列表中会有特殊的标记进行区分。

## 开发流程

在引入 Git Flow 之后，所有工作都要围绕着它来展开，将原本的流程与之结合形成「基于 Git Flow 的开发流程」。

![](https://ourai.ws/assets/posts/20160418/working-with-gitflow-efa631445317065fd85a17b314e91907ec6ef5e380460dd77a68aa60f91d95c4.png)
基于 Git Flow 的开发流程

### 开发功能

在确定发布日期之后，将需要完成的内容细分一下分配出去，负责某个功能的开发人员利用 SourceTree 所提供的 Git Flow 工具创建一个对应的 feature 分支。如果是多人配合的话，创建分支并做一些初始化工作之后就推送创建远程分支；否则，直到功能开发完毕要合并进 develop 前，不要创建远程分支。

功能开发完并自测之后，先切换到 develop 分支将最新的代码拉取下来，再切换回自己负责的 feature 分支把 develop 分支的代码合并进来。合并方式参照上文中的「[合并](#merging)」，如果有冲突则自己和配合的人一起解决。

然后，到 GitLab 上的项目首页创建合并请求（merge request）。

![](https://ourai.ws/assets/posts/20160418/create-merge-request-434fe68f78118a4ba5d9377ac6085eb4b20ccd1ef4f2441cc7a58938fb7a5e89.jpg)
创建合并请求

「来源分支」选择要被合并的 feature 分支且「目标分支」选择 develop 分支后点击「比较分支」按钮，在出现的表单中将处理人指派为项目负责人。

![](https://ourai.ws/assets/posts/20160418/select-branch-6e96ad984b0703f95019df0f797191951b6c7cfe38d4b7fcadc5da4a7e68786c.jpg)
选择分支

项目负责人在收到合并请求时，应该先做下代码审核看看有没有明显的严重的错误；有问题就找负责开发的人去修改，没有就接受请求并删除对应的 feature 分支。

![](https://ourai.ws/assets/posts/20160418/accept-merge-request-8ff0ac4356f9b834cf8d6b3d6b4e49e35df72b83b0d6317adfb8d111536b9a81.jpg)
接受合并请求

在将某次发布的所需功能全部开发完成时，就可以交付测试了。

### 测试功能

负责测试的人创建一个 release 分支部署到测试环境进行测试；

若发现了 bug，相应的开发人员就在 release 分支上或者基于 release 分支创建一个分支进行修复。

### 发布上线

当确保某次发布的功能可以发布时，负责发布的人将 release 分支合并进 master 和 develop 并打上 tag，然后打包发布到线上环境。

建议打 tag 时在信息中详细描述这次发布的内容，如：添加了哪些功能，修复了什么问题。

### 修复问题

当发现线上环境的代码有小问题或者做些文案修改时，相关开发人员就在本地创建 hotfix 分支进行修改，具体操作参考「[开发功能](#developing)」。

如果是相当严重的问题，可能就得回滚到上一个 tag 的版本了。

## 额外说明

这里所提到的事情，虽非必需，但知道之后却会如虎添翼。

### 分支命名

除了主要分支的名字是固定的之外，派生分支是需要自己命名的，这里就要有个命名规范了。强烈推荐用如下形式：

* feature——按照功能点（而不是需求）命名；
* release——用发布时间命名，可以加上适当的前缀；
* hotfix——GitLab 的 issue 编号或 bug 性质等。

另外还有 tag，用[语义化的版本号](http://semver.org/lang/zh-CN/)命名。

### 发布日期

发布频率是影响开发人员与测试人员的新陈代谢和心情的重要因素之一，频繁无规律的发布会导致内分泌失调、情绪暴躁，致使爆粗口、砸电脑等状况出现。

所以，确保一个固定的发布周期至关重要！

在有一波或几波需求来临之时，想挡掉是不太可能的，但可以在评审时将它（们）分期，在某个发布日之前只做一部分。

这是必须要控制住的！不然任由着需求方说「这个今天一定要上」「那个明天急着用」的话，技术人员就等着进医院吧！
