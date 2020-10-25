@Rem copies the files to the web server
@setlocal
set modulename=ventrilo
if "%modulename%" == "" goto bad

xcopy . \www\apache2\htdocs\xoops\modules\ventrilo /s /Y /I
goto done

:bad
@echo "Error. The module was not created correctly"

:done