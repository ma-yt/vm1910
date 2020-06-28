<?php

    $redis = new Redis();  //实例化redis

    //连接redis
    $redis->connect('127.0.0.1',6379);

    $k1 = 'name2';

      echo $redis->get($k1);