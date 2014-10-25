#!/bin/bash
 
tests=( "test-get-remote-ip-sh.sh" )


testcount=${#tests[@]}
testcount=$(echo $testcount - 1 | bc)

for i in `seq 0 $testcount`;
do
  ret=$(tests/${tests[$i]})
  result=$?
  echo "result = $result"
done

exit $result
