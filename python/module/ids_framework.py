#!/usr/bin/env python
#coding=utf8
import sys,os,time
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from include.db import *
import hashlib
class ids_framework():
    def __init__(self):
        self.data_list = []
        self.previous_data = []

    def is_initial(self,table):
        cursor.execute('select count(*) from ' + table)
        count = cursor.fetchone()[0]
        if count == 0:
            return 1
        else:
            return 0

    def run(self):
        '''
        @overwrite
        eg.
        if self.is_initial('ids_log'):
            self.initial()
        else:
            self.snapshot('ids_log')
        '''
        pass

    def initial(self):
        self.get_data_list()
        for i in range(len(self.data_list)):
            self.data_list[i].append(3) # set mark = 3
        self.insert(self.data_list)

    def snapshot(self,table,columns,index=[]):
        cursor.execute('select ' + columns + ' from ' + table)
        self.previous_data = cursor.fetchall()
        self.get_data_list()
        new_data_list = []
        for i in self.data_list:
            if index:
                tmp = []
                for j in index:
                    tmp.append(i[j])
            else:
                tmp = i
            if tuple(tmp) in self.previous_data:
                pass
            else:
                new_data_list.append(self.marking(i))
        if new_data_list:
            self.insert(new_data_list)

    def marking(self,one_data):
        '''
        @overwrite
        '''
        mark = 3
        one_data.append(mark)
        return one_data

    def get_data_list(self):
        '''
        @overwrite
        fill self.data_list
        eg.
        self.data_list.append([proto,process,listen])
        '''
        pass

    def insert(self,new_data_list):
        '''
        @overwrite
        insert into databases
        '''
        pass
        '''
        print 'insert: ',len(new_data_list)
        ids_id = self.get_ids_id()
        sql = "insert into port(ids_id,proto,process,listen,mark) values"
        for i in new_data_list:
            sql += "(%d,'%s','%s','%s',%d)," % (ids_id, MySQLdb.escape_string(i[0]), MySQLdb.escape_string(i[1]),MySQLdb.escape_string(i[2]),i[3]) 
        cursor.execute(sql[:-1])
        db.commit()
        '''
    def get_ids_id(self):
        cursor.execute('select max(ids_id) from ids_log')
        ids_id = cursor.fetchone()[0]
        return ids_id

    def get_str_md5(self,s):
        return hashlib.md5(s).hexdigest()