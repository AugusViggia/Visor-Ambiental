#! /bin/bash
echo Fetching tags
# Traigo los tags que existan en develop
git fetch origin --tags

# Busco si existe un tag que coincida con el último commit realizado
gitTag=`git describe --exact-match HEAD`

# Si se encuentra una versión del tipo x.x.x se usa esa versión
# sino se usa una combinación de la fecha actual más el hash
# corto del último commit realizado.
if expr match "$gitTag" '.*\([0-9]\+\.[0-9]\+\.[0-9]\+\)'  1>/dev/null; then
  actualVersion=$gitTag
else
  actualVersion=`date +%d-%m-%Y`"|"`git rev-parse --short HEAD`
fi

echo "Selected version tag: $actualVersion"
echo "Now replacing the version entry in the .env file..."
# Valor a buscar en el archivo .env
search=VERSION=.*
# Valor a remplazar en el archivo .env
versionName="VERSION=$actualVersion"
# Archivo en cuestión
configFile='.env'
# Remplazo el valor buscado por el actual generando un backup del anterior
sed -i.bkp s/"$search"/"$versionName"/  $configFile
echo "Finished!"
