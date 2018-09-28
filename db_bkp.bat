@ECHO OFF

REM set TIMESTAMP=%DATE:~10,4%%DATE:~4,2%%DATE:~7,2%
set TIMESTAMP=%DATE%
COLOR F

ECHO ""
ECHO ** Message from FuzeDatabase Admin **
ECHO ** Contact: pranjaljoshi@bel.co.in **
ECHO ""
ECHO ** Starting - Daily database backup process..
ECHO ""

REM - start maintainance of tables - Alter tables for reseting AUTO_INCREMENT
C:\xampp\mysql\bin\mysql.exe -u root --password=fuzedbpass fuze_database < "C:\xampp\htdocs\FuzeDatabase\auto_inc_reset.sql"

REM Export all databases into file C:\path\backup\databases.[year][month][day].sql
ECHO Backing up FuzeDatabase...
"C:\xampp\mysql\bin\mysqldump.exe" fuze_database --result-file="E:\FuzeDatabase_backups\fuze_database.%TIMESTAMP%.sql" --user="root" --password="fuzedbpass"

REM Change working directory to the location of the DB dump file.
C:
CD E:\FuzeDatabase_backups\

REM Compress DB dump file into CAB file (use "EXPAND file.cab" to decompress).
REM MAKECAB "fuze_database.%TIMESTAMP%.sql" "fuze_database.%TIMESTAMP%.sql.cab"
ECHO Compressing database file...
PowerShell -NoProfile -ExecutionPolicy Bypass -Command "Compress-Archive -Path 'E:\FuzeDatabase_backups\fuze_database.%TIMESTAMP%.sql' -DestinationPath 'E:\FuzeDatabase_backups\fuze_database.%TIMESTAMP%.zip' -Update"

ECHO Backing up on FTP Server for extra backup..
@ECHO OFF
ECHO user FuzeDatabaseAdmin> ftpcmd.dat
ECHO >> ftpcmd.dat
ECHO bin>> ftpcmd.dat
ECHO hash>> ftpcmd.dat
REM ECHO hash>> ftpcmd.dat
ECHO put E:\FuzeDatabase_backups\fuze_database.%TIMESTAMP%.zip>> ftpcmd.dat
ECHO quit>> ftpcmd.dat
REM ftp -n -s:ftpcmd.dat 192.168.100.225
REM ftp -n -s:ftpcmd.dat 192.168.100.146
ftp -n -s:ftpcmd.dat 172.243.14.59			REM GauravTarkas-IP
REM Change this IP to intranet FTP Server later.. It should be on diffrent machine than the webserver!
DEL ftpcmd.dat

REM Delete uncompressed DB dump file.
ECHO Deleting uncompressed database file...
DEL /q /f "E:\FuzeDatabase_backups\fuze_database.%TIMESTAMP%.sql"

ECHO -----------
ECHO     DONE   
ECHO -----------
ECHO 
PAUSE