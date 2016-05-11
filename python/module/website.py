#!/usr/bin/env python
#coding=utf8
import sys,os,time,datetime
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
import ConfigParser
import threading,Queue
from include.db import *
from include.setting import *
from ids_framework import ids_framework

class website(ids_framework):
    def __init__(self):
        ids_framework.__init__(self)
        self.website_path = []
        self.extension_whitelist = []
        self.sensitive_word = []
        self.other_path = []

    def run(self):
        self.parse_config('website')
        if self.is_initial('website'):
            self.initial()
        else:
            self.snapshot('website','file,father_path,file_md5',[0,1,3])

    def parse_config(self,table):
        cf = ConfigParser.ConfigParser()
        cf.read(config_dir)
        secs = cf.sections() 
        if 'file' in secs:
            if 'website_path' in cf.options('file'):
                self.website_path = cf.get("file", "website_path").split('|')
            if 'other_path' in cf.options('file'):
                self.other_path = cf.get("file", "other_path").split('|')
            if 'extension_whitelist' in cf.options('file'):
                self.extension_whitelist = cf.get("file", "extension_whitelist").split('|')

    def get_data_list(self):
        for i in self.website_path:
            self.scan_dir(i)

    def scan_dir(self,path):
        for root, dirs, files in os.walk(path):
            for d in dirs:
                full_path = os.path.join(root, d)
                file_mtime = self.get_file_mtime(full_path)
                self.data_list.append([d, root,file_mtime,''])
            for filename in files:
                full_path = os.path.join(root, filename)
                file_mtime = self.get_file_mtime(full_path)
                file_md5 = self.get_file_md5(full_path)
                self.data_list.append([filename, root,file_mtime,file_md5])
            
    def marking(self,one_data):
        '''
        optimze: add permission.
        '''
        full_path = os.path.join(one_data[1],one_data[0])
        ext = self.file_extension(full_path)
        is_backdoor = self.find_backdoor(full_path)
        if os.path.isdir(full_path):
            mark = 3
        if ext not in self.extension_whitelist:
            if is_backdoor:
                mark = 0
            else:
                mark = 1
        elif is_backdoor:
            mark = 2
        else:
            mark = 3
        one_data.append(mark)
        return one_data

    def file_extension(self,path):
        if os.path.splitext(path)[1]:
            return os.path.splitext(path)[1].split('.')[1]
        return ''

    def find_backdoor(self,path):
        if not self.sensitive_word:
            with open(sensitive_word_dir) as f:
                for i in f.readlines():
                    self.sensitive_word.append(i.strip())
        if os.path.isdir(path):
            return 0
        with open(path) as f:
            content = f.read()
            for i in self.sensitive_word:
                if i in content:
                    return {"flag":1,"sensitive_word":i}
        return 0

    def get_file_mtime(self,path):
        try:
            stat = os.stat(path)
            mtime = datetime.datetime.fromtimestamp(int(stat.st_mtime))
            return mtime
        except:
            return '0000-00-00 00:00:00'

    def get_file_md5(self,path):
        return os.popen('md5sum "' + path +'"').readline().strip()[0:32]

    def insert(self,new_data_list):
        # per 1000 data execute a sql.
        print 'insert: ',len(new_data_list)
        ids_id = self.get_ids_id()
        sql = 'insert into website(ids_id,file,father_path,file_mtime,file_md5,mark) values'
        count = 0
        for i in new_data_list:
            sql += "(%d,'%s','%s','%s','%s',%d)," % (ids_id, MySQLdb.escape_string(i[0]), MySQLdb.escape_string(i[1]), str(i[2]), i[3], i[4])
            count += 1
            if count % 1000 == 0 or count == len(new_data_list):
                try:
                    cursor.execute(sql[:-1])
                    db.commit()
                except Exception,e:
                    print e
                sql = 'insert into website(ids_id,file,father_path,file_mtime,file_md5,mark) values'

if __name__ == '__main__':
    start = time.time()
    o = website()
    o.run()
    print 'cost time:',time.time() - start
    # import profile
    # profile.run('website().run()', "run.txt")
    # import pstats
    # p = pstats.Stats("run.txt")
    # p.sort_stats("time").print_stats()