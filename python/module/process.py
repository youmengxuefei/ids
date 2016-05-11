#!/usr/bin/env python
#coding=utf8
import sys,os,time,re
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from include.db import *
from include.setting import *
from ids_framework import ids_framework

class process(ids_framework):
    def __init__(self):
        ids_framework.__init__(self)
        self.process_whitelist = []

    def run(self):
        if self.is_initial('process'):
            self.initial()
        else:
            self.snapshot('process','user,process',[0,4])

    def marking(self,one_data):
        if not self.process_whitelist:
            with open(process_whitelist_dir) as f:
                for i in f.readlines():
                    self.process_whitelist.append(i.strip())
        if one_data[4] in self.process_whitelist:
            mark = 2
        else:
            mark = 0
        one_data.append(mark)
        return one_data

    def get_data_list(self):
        #获取进程列表
        data = os.popen('ps -eo user,pid,pcpu,pmem,comm')
        data.readline()
        for line in data.readlines():
            result = re.sub('[\s]+',' ',line.strip())
            tmp = result.split(' ')
            user = tmp[0]
            pid = tmp[1]
            cpu = tmp[2]
            mem = tmp[3]
            process = tmp[4]
            self.data_list.append([user,pid,cpu,mem,process])

    def insert(self,new_data_list):
        # print new_data_list
        print 'insert: ',len(new_data_list)
        ids_id = self.get_ids_id()
        sql = "insert into process(ids_id,user,pid,cpu,mem,process,mark) values"
        for i in new_data_list:
            sql += "(%d,'%s','%s','%s','%s','%s',%d)," % (ids_id, MySQLdb.escape_string(i[0]), MySQLdb.escape_string(i[1]),MySQLdb.escape_string(i[2]),MySQLdb.escape_string(i[3]),MySQLdb.escape_string(i[4]),i[5])
        cursor.execute(sql[:-1])
        db.commit()

if __name__ == '__main__':
    start = time.time()
    process().run()
    print 'cost time:',time.time() - start
