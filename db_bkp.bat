@ECHO OFF

set TIMESTAMP=%DATE:~10,4%%DATE:~4,2%%DATE:~7,2%
COLOR F

ECHO ""
ECHO ** Message from FuzeDatabase Admin **
ECHO ** Contact: pranjaljoshi@bel.co.in **
ECHO ""
ECHO ** Starting - Daily database backup process..
ECHO ""

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

REM Delete uncompressed DB dump file.
ECHO Deleting uncompressed database file...
DEL /q /f "E:\FuzeDatabase_backups\fuze_database.%TIMESTAMP%.sql"

ECHO -----------
ECHO     DONE   
ECHO -----------
ECHO 
PAUSE