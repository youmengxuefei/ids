# ids
基于系统快照的入侵检测系统

###功能介绍
本系统定期获取操作系统的各类状态信息，如进程快照信息、文件快照信息、端口快照信息等，存入数据库中，当下一次对系统进行快照时，通过与之前存在数据库中的快照信息进行比对，抽离出所有发生过变化的异常信息，并对这些异常信息进行相应入侵检测模块的危害等级评定分析，当总体评分低于正常值时，给管理员发送预警邮件。同时Web前端可以展示各类检测模块的详细信息、配置系统的详细参数、下发检测任务。

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
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件：dedwod@qq.com
* QQ: 641199800

