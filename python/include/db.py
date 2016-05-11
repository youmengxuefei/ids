#!/usr/bin/env python
#coding=utf8
import MySQLdb
db = MySQLdb.connect("127.0.0.1","root","123456o","ids",charset="utf8",use_unicode=False)
cursor = db.cursor()