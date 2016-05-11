#!/usr/bin/env python
#coding=utf8
import sys,os,time,re
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from include.db import *
from include.setting import *
from ids_framework import ids_framework

class port(ids_framework):
    def __init__(self):
        ids_framework.__init__(self)
        self.process_whitelist = []

    def run(self):
        if self.is_initial('port'):
            self.initial()
        else:
            self.snapshot('port','proto,process,listen')

    def marking(self,one_data):
        '''
        if the new listen process in whitelist, mark = 2,else mark = 0
        '''
        if not self.process_whitelist:
            with open(process_whitelist_dir) as f:
                for i in f.readlines():
                    self.process_whitelist.append(i.strip())
        if one_data[1] in self.process_whitelist:
            mark = 2
        else:
            mark = 0
        one_data.append(mark)
        return one_data

    def get_data_list(self):
        #get listen post list 
        data = os.popen('netstat -lnutp | grep "LISTEN"')
        data.readline()
        data.readline()
        for line in data.readlines():
            result = re.sub('[\s]+',' ',line.strip())
            tmp = result.split(' ')
            proto = tmp[0]
            process = tmp[6].split('/')[1] if len(tmp[6].split('/')) > 1 else tmp[5]
            listen = tmp[3]
            self.data_list.append([proto,process,listen])

    def insert(self,new_data_list):
        # print new_data_list
        print 'insert: ',len(new_data_list)
        ids_id = self.get_ids_id()
        sql = "insert into port(ids_id,proto,process,listen,mark) values"
        for i in new_data_list:
            sql += "(%d,'%s','%s','%s',%d)," % (ids_id, MySQLdb.escape_string(i[0]), MySQLdb.escape_string(i[1]),MySQLdb.escape_string(i[2]),i[3]) 
        cursor.execute(sql[:-1])
        db.commit()

if __name__ == '__main__':
    
    start = time.time()
    port().run()
    print 'cost time:',time.time() - start
        



    