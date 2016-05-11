#!/usr/bin/env python
#coding=utf8
import sys,os,time,datetime
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
import ConfigParser
import threading,Queue
from include.db import *
from include.setting import *
from website import website

class file(website):
    def __init__(self):
        website.__init__(self)
    
    def run(self):
        self.parse_config('file')
        if self.is_initial('file'):
            self.initial()
        else:
            self.snapshot('file','stat_md5',[7])

    def get_data_list(self):
        # path = ['/etc','/home','/root','/lib','/lib64','/var',]
        for i in self.other_path:
            self.scan_dir(i)
        # self.scan_dir('/')

    def scan_dir(self,path):
        for root, dirs, files in os.walk(path):
            for d in dirs:
                full_path = os.path.join(root, d)
                if self.check_ignore_path(self.website_path, full_path):
                    continue
                stat = [d, root] + self.get_file_stat(full_path)
                stat_md5 = self.get_file_stat_md5(stat)
                stat.append(stat_md5)
                self.data_list.append(stat)
            for filename in files:
                full_path = os.path.join(root, filename)
                if self.check_ignore_path(self.website_path, full_path):
                    continue
                stat = [filename, root] + self.get_file_stat(full_path)
                stat_md5 = self.get_file_stat_md5(stat)
                stat.append(stat_md5)
                self.data_list.append(stat)

    def get_file_stat_md5(self,stat):
        file_info = ''
        for i in stat:
            file_info += str(i)
        return self.get_str_md5(file_info)

    def check_ignore_path(self,ignore_path,full_path):
        for i in ignore_path:
            if i in full_path:
                return True
        return False

    def get_file_stat(self,path):
        try:
            stat = os.stat(path)
            mtime = datetime.datetime.fromtimestamp(int(stat.st_mtime))
            permission = oct(stat.st_mode)[-3:]
            size = stat.st_size
            uid = stat.st_uid
            gid = stat.st_gid
            return [mtime,size,permission,uid,gid]
        except:
            return ['0000-00-00 00:00:00',0,'0',0,0]


    def marking(self,one_data):
        full_path = os.path.join(one_data[1],one_data[0])
        file_permission = one_data[4]
        is_high_permission = 0
        if '7' in file_permission:
            is_high_permission = 1
        if os.path.isdir(full_path):
            if is_high_permission:
                mark = 0
            else:
                mark = 3
        else:
            ext = self.file_extension(full_path)
            if ext not in self.extension_whitelist:
                if is_high_permission:
                    mark = 0
                else:
                    mark = 1
            elif is_high_permission:
                mark = 2
            else:
                mark = 3
        one_data.append(mark)
        return one_data

    def insert(self,new_data_list):
        # per 1000 data execute a sql.
        print 'insert: ',len(new_data_list)
        ids_id = self.get_ids_id()
        sql = 'insert into file(ids_id,file,father_path,mtime,size,permission,uid,gid,stat_md5,mark) values'
        count = 0
        for i in new_data_list:
            sql += "(%d,'%s','%s','%s','%d','%s',%d,%d,'%s',%d)," % (ids_id, MySQLdb.escape_string(i[0]), MySQLdb.escape_string(i[1]), str(i[2]), i[3], i[4],i[5],i[6],i[7],i[8])
            count += 1
            if count % 1000 == 0 or count == len(new_data_list):
                cursor.execute(sql[:-1])
                db.commit()
                sql = 'insert into file(ids_id,file,father_path,mtime,size,permission,uid,gid,stat_md5,mark) values'

if __name__ == '__main__':
    import profile
    profile.run('file().run()', "run.txt")
    import pstats
    p = pstats.Stats("run.txt")
    p.sort_stats("time").print_stats()

