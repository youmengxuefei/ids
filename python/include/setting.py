#!/usr/bin/env python
#coding=utf8
import os

main_path = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
config_dir = main_path + os.path.sep + "config" + os.path.sep + "config.ini"
sensitive_word_dir = main_path + os.path.sep + "config" + os.path.sep + "sensitiveWord.txt"
process_whitelist_dir = main_path + os.path.sep + "config" + os.path.sep + "process_whitelist.txt"
process_blacklist_dir = main_path + os.path.sep + "config" + os.path.sep + "process_blacklist.txt"