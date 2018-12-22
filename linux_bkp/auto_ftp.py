#!/usr/bin/python3

import ftplib
import datetime
import os

USER = "FuzeDatabaseAdmin"
PASS = ""

PATH = "/home/pranjal/FuzeDatabaseBackups/"

BackupNodes = ['172.243.20.139']
BackupNodeOwners = ['Gaurav Tarkas']

fname = PATH + "FuzeDatabaseBackup." + datetime.datetime.now().strftime('%Y-%m-%d') + "_00:00.sql.zip"
ftpName = "FuzeDatabaseBackup_" + datetime.datetime.now().strftime('%Y_%m_%d') + ".zip"

os.system("clear")
print("\n[+] Starting Fuze Database Backup Uploader Script...")
print("\n[+] Opening backup file: %s" % fname)

f = open(fname,'rb')
cnt = 0

for ip in BackupNodes:

	print("\n[+] Attempting to connect Fail-Safe FTP Server at IP: %s [%s]" % (ip, BackupNodeOwners[cnt]))
	session = ftplib.FTP(ip,USER,PASS)

	print("\n[+] Transferring backup file %s to server..." % ftpName)
	session.storbinary('STOR %s' % ftpName, f)

	print("\n[+] Transfer complete. Disconnecting...")
	session.quit()
	cnt += 1

print("\n[+] Closing backup file: %s" % fname)
f.close()