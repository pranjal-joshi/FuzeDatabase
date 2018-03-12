@ECHO OFF

set TIMESTAMP=%DATE:~10,4%%DATE:~4,2%%DATE:~7,2%

REM Export all databases into file C:\path\backup\databases.[year][month][day].sql
COLOR F
ECHO "Backing up FuzeDatabase..."
"C:\xampp\mysql\bin\mysqldump.exe" fuze_database --result-file="E:\FuzeDatabase_backups\databases.%TIMESTAMP%.sql" --user="root" --password="fuzedbpass"

REM Change working directory to the location of the DB dump file.
C:
CD E:\FuzeDatabase_backups\

REM Compress DB dump file into CAB file (use "EXPAND file.cab" to decompress).
REM MAKECAB "databases.%TIMESTAMP%.sql" "databases.%TIMESTAMP%.sql.cab"
ECHO "Compressing database file..."
COMPRESS -ZX "E:\FuzeDatabase_backups\databases.%TIMESTAMP%.sql" "E:\FuzeDatabase_backups\databases.%TIMESTAMP%.sql.zip"

REM Delete uncompressed DB dump file.
ECHO "Deleting uncompressed database file..."
DEL /q /f "E:\FuzeDatabase_backups\databases.%TIMESTAMP%.sql"

ECHO "-----------"
ECHO "    DONE   "
ECHO "-----------"
ECHO ""
PAUSE