#!/usr/bin/env python
#coding=utf8
import time,os,sys
from include.db import *
from include.setting import *

class ids():
    def __init__(self):
        self.module_name = []

    def is_initial(self,table):
        cursor.execute('select count(*) from ids_log')
        count = cursor.fetchone()[0]
        if count == 0:
            return 1
        else:
            return 0

    def initial(self):
        self.get_module_name()
        self.delete_database()
        self.fill_process_whitelist()

    def run(self):
        if self.is_initial('ids_log'):
            self.initial()
        self.snapshot()

    def snapshot(self):
        cursor.execute('select max(ids_id) from ids_log')
        max_id = cursor.fetchone()[0]
        ids_id = max_id + 1 if max_id else 1
        cursor.execute('insert into ids_log(ids_id) values(%d)' % ids_id)
        db.commit()

        sys.path.append("module")
        for module_name in self.get_module_name():
            module = __import__(module_name)
            c = getattr(module,module_name) 
            print "[*] module: ",module_name
            c().run()

    def delete_database(self):
        for table in self.module_name:
            sql = "delete from " + table
            cursor.execute(sql)
            db.commit()
        cursor.execute("delete from ids_log")
        db.commit()

    def fill_process_whitelist(self):
        data = os.popen("echo $PATH")
        bin_path = data.readline().strip()
        bin_path = bin_path.split(':')
        white_list = []
        for i in bin_path:
            try:
                for j in os.listdir(i):
                    white_list.append(j)
            except:
                continue
        with open(process_whitelist_dir,'w') as f:
            for i in white_list:
                f.write(i + '\n')


    def get_module_name(self):
        if not self.module_name:
            for i in os.listdir("./module"):
                if len(i.split('.')) == 2 and i.split('.')[1] == 'py':
                    if 'init' not in i and 'framework' not in i:
                        self.module_name.append(i.split('.')[0])
        return self.module_name
        
    

if __name__ == '__main__':
    start = time.time()
    ids().run()
    print 'cost time:',time.time() - start
