#!/usr/bin/env python
#coding=utf8
import sys,os,time
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from include.db import *
from ids_framework import ids_framework

class ethernet(ids_framework):
    def __init__(self):
        ids_framework.__init__(self)

    def run(self):
        if self.is_initial('ethernet'):
            self.initial()
        else:
            self.snapshot('ethernet','status_md5',[0])

    def marking(self,one_data):
        '''
        if ethernet status changed ,mark = 0
        '''
        mark = 0
        one_data.append(mark)
        return one_data

    def get_data_list(self):
        data = os.popen('ifconfig -a | grep -Ev "RX|TX"')
        content = data.read()
        md5 = self.get_str_md5(content)
        self.data_list.append([md5,content])

    def insert(self,new_data_list):
        # print new_data_list
        print 'insert: ',len(new_data_list)
        ids_id = self.get_ids_id()
        sql = "insert into ethernet(ids_id,status_md5,ethernet_detail,mark) values"
        for i in new_data_list:
            sql += "(%d,'%s','%s',%d)," % (ids_id, i[0], MySQLdb.escape_string(i[1]),i[2]) 
        cursor.execute(sql[:-1])
        db.commit()

if __name__ == '__main__':
    start = time.time()
    ethernet().run()
    print 'cost time:',time.time() - start
        



    