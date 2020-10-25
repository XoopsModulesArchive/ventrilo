@setlocal
@pushd

jar cvfM ventrilo0.10.zip makemod

move makemod_%1.zip \backups\makemod\
start winzip \backups\makemod\makemod_%1.zip

echo "Done"

goto done


:no_param
@echo usage: makerel version_suffix
@echo 	e.g. makerel 1.00 gives "makemod_1.00.zip"

:done
@popd