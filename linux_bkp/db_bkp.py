#!/usr/bin/python3

import os
import sys
import subprocess as sp
import datetime

os.system("clear")

print("\n")
print("[+] Starting Fuze-Database maintainance engine...")
print("[+] Please wait..")

home = "/home/pranjal"
path = "/opt/lampp/bin"

t = datetime.datetime.now().strftime('%Y-%m-%d_%H:%M')

cmd = (("cd %s;" % path)+
	('sudo ./mysql -u root --password="fuzedbpass" fuze_database < "/opt/lampp/htdocs/FuzeDatabase/auto_inc_reset.sql";') +
	('sudo ./mysqldump fuze_database --result-file="/home/pranjal/FuzeDatabaseBackups/FuzeDatabaseBackup.%s.sql" --user="root" --password="fuzedbpass";' % t) + 
	('sleep 1; cd /home/pranjal/FuzeDatabaseBackups/; sudo zip -r FuzeDatabaseBackup.%s.sql.zip FuzeDatabaseBackup.%s.sql; sudo rm FuzeDatabaseBackup.%s.sql;' % (t, t, t)) + 
	('cd /home/pranjal; sudo ./auto_ftp.sh /home/pranjal/FuzeDatabaseBackups/FuzeDatabaseBackup.%s.sql.zip;' % (t)) +
	('ftp -n 172.243.14.59<<END_SCRIPT; quote USER FuzeDatabaseAdmin; quote PASS ; binary; hash; put FuzeDatabaseBackup.%s.sql.zip; quit; END_SCRIPT; ' % (t))
	)

print("\n[+] Executing command: "+cmd+"\n\n")

os.system(cmd)

print("\n")
print("[+] Maintainance engine executed succesfully.")
print("[+] Exiting normally..")

sys.exit(0)
