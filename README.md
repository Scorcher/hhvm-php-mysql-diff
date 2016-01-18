# HHVM, PHP mysql result difference

There is a small dockerized test case return types from mysql result of HHVM, PHP-libmysql, PHP-mysqlnd.

```bash
git clone https://github.com/Scorcher/hhvm-php-mysql-diff.git .

docker-compose up -d mariadb
# wait mariadb until initialized

# HHVM with hhvm.mysql.typed_results=true
docker-compose run --rm hhvm /code/test-hhvm-typed.sh

# HHVM with hhvm.mysql.typed_results=false
docker-compose run --rm hhvm /code/test-hhvm-nottyped.sh

# PHP with libmysql
docker-compose run --rm php_mysql /code/test.sh

# PHP with mysqlnd
docker-compose run --rm php_mysqlnd /code/test.sh

docker-compose stop
docker rm mariadb
```

Result and versions below:
```
HipHop VM 3.11.0 (rel)
Compiler: tags/HHVM-3.11.0-0-g3dd564a8cde23e3205a29720d3435c771274085e
Repo schema: 52047bdda550f21c2ec2fcc295e0e6d02407be51
hhvm -d hhvm.mysql.typed_results=true -f type-test.php
mysql - 5.6.24
array(1) {
  [0]=>
  array(4) {
    ["intField"]=>
    string(3) "123"
    ["floatField"]=>
    string(7) "1234.57"
    ["strField"]=>
    string(9) "123214qwe"
    ["calc"]=>
    string(18) "10.037133193597562"
  }
}


HipHop VM 3.11.0 (rel)
Compiler: tags/HHVM-3.11.0-0-g3dd564a8cde23e3205a29720d3435c771274085e
Repo schema: 52047bdda550f21c2ec2fcc295e0e6d02407be51
hhvm -d hhvm.mysql.typed_results=false -f type-test.php
mysql - 5.6.24
array(1) {
  [0]=>
  array(4) {
    ["intField"]=>
    string(3) "123"
    ["floatField"]=>
    string(7) "1234.57"
    ["strField"]=>
    string(9) "123214qwe"
    ["calc"]=>
    string(18) "10.037133193597562"
  }
}


PHP 5.5.9-1ubuntu4 (cli) (built: Apr  9 2014 17:11:57)
Copyright (c) 1997-2014 The PHP Group
Zend Engine v2.5.0, Copyright (c) 1998-2014 Zend Technologies
    with Zend OPcache v7.0.3, Copyright (c) 1999-2014, by Zend Technologies
mysql - 5.5.35
array(1) {
  [0]=>
  array(4) {
    ["intField"]=>
    string(3) "123"
    ["floatField"]=>
    string(7) "1234.57"
    ["strField"]=>
    string(9) "123214qwe"
    ["calc"]=>
    string(18) "10.037133193597562"
  }
}


PHP 5.5.31 (cli) (built: Jan  7 2016 22:25:47)
Copyright (c) 1997-2015 The PHP Group
Zend Engine v2.5.0, Copyright (c) 1998-2015 Zend Technologies
mysql - mysqlnd 5.0.11-dev - 20120503 - $Id: 15d5c781cfcad91193dceae1d2cdd127674ddb3e $
array(1) {
  [0]=>
  array(4) {
    ["intField"]=>
    int(123)
    ["floatField"]=>
    float(1234.57)
    ["strField"]=>
    string(9) "123214qwe"
    ["calc"]=>
    float(10.037133193598)
  }
}

```

Only PHP with mysqlnd has typed results.

Links: https://github.com/facebook/hhvm/issues/6754

