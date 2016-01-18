#!/bin/bash

cd `dirname $0`
php --version
php -i | grep "mysql - "
php -f type-test.php
