<?php
	
	$http = new swoole_http_server("0.0.0.0", 9502);
    $http->on('request', function ($request, $response) {
        $db = new swoole_mysql;
        $server = array(
            'host' => 'rm-m5e73nm4c2zooyyw0.mysql.rds.aliyuncs.com',
            'port' => 3306,
            'user' => 'quhecha',
            'password' => 'quhecha3819Q',
            'database' => 'quhecha',
            'charset' => 'utf8', //指定字符集
            'timeout' => 2,  // 可选：连接超时时间（非查询超时时间），默认为SW_MYSQL_CONNECT_TIMEOUT（1.0）
        );
        
        $db->connect($server, function ($db, $r) use($response){
            if ($r === false) {
                var_dump($db->connect_errno, $db->connect_error);
                die;
            }
            $sql = 'show tables';
            $db->query($sql, function(swoole_mysql $db, $r) use($response){
                if ($r === false)
                {
                    var_dump($db->error, $db->errno);
                }
                elseif ($r === true )
                {
                    var_dump($db->affected_rows, $db->insert_id);
                }
                var_dump($r);
                $db->close();
                
                $response->end(json_encode($r));
            });
        });
        
    });

    
    $http->start();
?>