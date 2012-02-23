#!/bin/sh
BASEDIR=/home/apache/universibo
USER=root
GROUP=apache

chown ${USER}.${GROUP} $BASEDIR -R
find $BASEDIR -type f -exec chmod 640 {} \;
find $BASEDIR -type d -exec chmod 750 {} \;

# gli utenti devono poter caricare le immagini per il forum
chmod g+w $BASEDIR/htmls/forum/images/avatars
# gli utenti del sito devono poter inviare le loro foto
chmod g+w $BASEDIR/htmls/img/contacts
# notifiche non ancora inviate
chmod g+w $BASEDIR/universibo/notifiche.lock
# log...
chmod g+w $BASEDIR/universibo/log-universibo
# dispense etc etc
chmod g+w $BASEDIR/universibo/file-universibo
# output di smarty, per il template
chmod g+w $BASEDIR/universibo/templates_compile/black
chmod g+w $BASEDIR/universibo/templates_compile/simple
chmod g+w $BASEDIR/universibo/templates_compile/unibo