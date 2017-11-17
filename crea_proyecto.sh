#!/bin/sh

if [ $# -eq 1 ]
then
    if [ -d $1 ]
    then
        echo "El directorio $1 existe"
        exit 1
    else
        mkdir $1
        if [ $? -eq 0 ]
        then
            echo "Se ha creado el directorio $1"
        else
            echo "Error al crear el directorio"
            exit 1
        fi
    fi
else
    echo "Solo se permite un parámetro"
    exit 1
fi

if [ -f /etc/hosts ]
then
    #sudo sh -c "echo '127.0.0.1	$1.local' >> /etc/hosts"
    echo "Añadida la línea '127.0.0.1 $1.local' al archivo /etc/hosts"
else
    echo "El archivo /etc/hosts no existe"
    rm -rf $1
    exit 1
fi
if [ -d /etc/apache2/sites-available ]
then
    sudo touch /etc/apache2/sites-available/$1.conf
    echo "Copiado"    
fi

exit 0
