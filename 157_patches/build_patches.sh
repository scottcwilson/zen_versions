#!/bin/bash
FRESH=/Users/scott/Sites/old_gh_demo_157
BASE=/Users/scott/zen_versions/zen-cart-v1.5.7-06232020
LIST=/tmp/copy 
if [ -f $LIST ]; then 
   echo "Delete $LIST then re-run" 
   exit
fi
for f in includes admin 
do 
  cd $FRESH/$f 
  for i in `find . -type f`
  do
     diff -q $i $BASE/$f/$i 1>/dev/null 
     if [ $? -ne 0 ]; then 
        echo $f/$i >> $LIST
     fi
  done
  cd - 1>/dev/null 
done 
echo "Build zip from " $LIST " in " $FRESH
echo "zip -qr /tmp/up.zip `cat $LIST`" 
echo "Then unzip here and run ./cleanup_patches.sh" 
