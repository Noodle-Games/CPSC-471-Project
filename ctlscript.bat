@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\hypersonic\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\server\hsql-sample-database\scripts\ctl.bat START)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\ingres\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\ingres\scripts\ctl.bat START)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\mysql\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\mysql\scripts\ctl.bat START)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\postgresql\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\postgresql\scripts\ctl.bat START)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\apache\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\apache\scripts\ctl.bat START)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\openoffice\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\openoffice\scripts\ctl.bat START)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\apache-tomcat\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\apache-tomcat\scripts\ctl.bat START)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\resin\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\resin\scripts\ctl.bat START)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\jetty\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\jetty\scripts\ctl.bat START)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\subversion\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\lucene\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\lucene\scripts\ctl.bat START)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\third_application\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\third_application\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\third_application\scripts\ctl.bat STOP)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\lucene\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\subversion\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\subversion\scripts\ctl.bat STOP)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\jetty\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\jetty\scripts\ctl.bat STOP)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\hypersonic\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\resin\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\resin\scripts\ctl.bat STOP)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\apache-tomcat\scripts\ctl.bat STOP)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\openoffice\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\openoffice\scripts\ctl.bat STOP)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\apache\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\apache\scripts\ctl.bat STOP)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\ingres\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\ingres\scripts\ctl.bat STOP)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\mysql\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\mysql\scripts\ctl.bat STOP)
if exist C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\postgresql\scripts\ctl.bat (start /MIN /B C:\Users\mrnoo\Desktop\School\CPSC471\CPSC-471-Project\postgresql\scripts\ctl.bat STOP)

:end

