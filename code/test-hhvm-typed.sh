#!/bin/bash

cd `dirname $0`
hhvm --version
cmd="hhvm -d hhvm.mysql.typed_results=true -f type-test.php"
echo $cmd
$cmd
