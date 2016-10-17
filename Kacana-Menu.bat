@ECHO OFF
TITLE Kacana-Multiple Choice Menu
:home
CLS
ECHO.
ECHO Select a task:
ECHO ==============
ECHO.
ECHO 1) Start Kacana Project
ECHO 2) Grunt
ECHO 3) Grunt JS
ECHO 4) Grunt CSS
ECHO 5) Start Redis
ECHO 6) Stop Redis
Echo 7) Exit
ECHO.
set /p web=Type option:
if "%web%"=="1" goto start-kacana
if "%web%"=="2" goto grunt
if "%web%"=="3" goto grunt-js
if "%web%"=="4" goto grunt-css
if "%web%"=="5" net start redis
if "%web%"=="6" net stop redis
if "%web%"=="7" exit
pause
goto home
:start-kacana
net start redis
goto grunt
:grunt
cd /D D:\kacana.com\cli\grunt
start kacana-grunt.bat
pause
goto home
:grunt-js
cd /D D:\kacana.com\cli\grunt
start kacana-grunt-js.bat
pause
goto home
:grunt-css
cd /D D:\kacana.com\cli\grunt
start kacana-grunt-css.bat
pause
goto home
