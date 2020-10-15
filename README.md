# ids
基于系统快照的入侵检测系统

###功能介绍


###环境要求
* linux
* python 2.6/2.7
* php&mysql&apache/nginx

###python端 介绍
* config目录 存放用户自定义配置文件config.ini ,进程黑白名单和后门敏感关键字
* include目录 存放程序配置文件
* module目录 存放系统快照功能模块，模块编写按照里面的ids_framework框架编写。
* main.py 主文件

###php端 介绍
* 前端采用bootstrap+jquery设计而成

###运行
先新建数据库ids并把ids.sql导入
  
运行 python main.py

前端

![index](https://github.com/youmengxuefei/ids/blob/master/index.jpg)
![website](https://github.com/youmengxuefei/ids/blob/master/website.jpg)
  
###总结
每当执行一次main.py后，ids就能发现所检测功能里所有发生的新变化，并且对这些新发生的变化进行危害分析，从而达到入侵检测的效果。

##有问题反馈
在使用中有任何问题，欢迎反馈给我


