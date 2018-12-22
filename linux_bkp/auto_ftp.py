#!/usr/bin/python3

import ftplib
import datetime
import os
import sys

class clr:
	HEADER = '\033[95m'
	OKBLUE = '\033[94m'
	OKGREEN = '\033[92m'
	WARNING = '\033[93m'
	FAIL = '\033[91m'
	END = '\033[0m'
	BOLD = '\033[1m'
	UNDERLINE = '\033[4m'

USER = "FuzeDatabaseAdmin"
PASS = ""

PATH = "/home/pranjal/FuzeDatabaseBackups/"

BackupNodes = ['172.243.20.139', '172.243.20.145', '172.243.20.151']
BackupNodeOwners = ['Gaurav Tarkas', 'Lalit Patil', 'Ganesh Upare']

fname = PATH + "FuzeDatabaseBackup." + datetime.datetime.now().strftime('%Y-%m-%d') + "_00:00.sql.zip"
warnFname = "/opt/lampp/htdocs/FuzeDatabase/WARNING.txt"

ftpName = "FuzeDatabaseBackup_" + datetime.datetime.now().strftime('%Y_%m_%d') + ".zip"

os.system("clear")
print(clr.HEADER + clr.BOLD + "\n[+] Starting Fuze Database Backup Uploader Script..." + clr.END)

cnt = 0

for ip in BackupNodes:
	try:
		try:
			print(clr.OKBLUE + "\n[+] Opening backup file: %s" % fname + clr.END)
			f = open(fname,'rb')
			wf = open(warnFname,'rb')
		except:
			print(clr.FAIL + clr.BOLD + "\n[-] Failed to open backup file: %s\n[-] Exiting Abnormally!" % fname + clr.END)
			sys.exit(1)

		print(clr.WARNING + clr.BOLD + "[+] Attempting to connect Fail-Safe FTP Server at IP: %s [%s]" % (ip, BackupNodeOwners[cnt]) + clr.END)
		session = ftplib.FTP(ip,USER,PASS)

		print(clr.BOLD + clr.OKBLUE + "[+] Transferring backup file %s to server..." % ftpName + clr.END)
		session.storbinary('STOR %s' % ftpName, f)
		session.storbinary('STOR WARNING.txt', wf)

		print(clr.BOLD + clr.OKGREEN + "[+] Transfer complete. Disconnecting..." + clr.END)
		session.quit()

		print(clr.FAIL + "[+] Closing backup file: %s" % fname + clr.END)
		f.close()
		wf.close()
	except OSError:
		print(clr.BOLD + clr.FAIL + "[-] Failed to connect: %s [%s]\n[-] Ignoring IP [%s] for this time..." %  (ip, BackupNodeOwners[cnt], ip) + clr.END)
	cnt += 1


print(clr.OKGREEN + clr.BOLD + "\n[+] Exiting normally..\n" + clr.END)
sys.exit(0)