<?php
/**
 * 测试str_replace与preg_replace函数的性能
 * 未优化
 * @date 2018.4.1
 */
set_time_limit(0);
require 'ubm.php';
$str = "This string is not modified";
$loops = 1000000;

micro_benchmark('str_replace', 'bm_str_replace', $loops);
micro_benchmark('preg_replace', 'bm_preg_replace', $loops);
micro_benchmark('echo', 'oo', $loops);


function bm_str_replace($loops) {
    global $str;
    for ($i = 0; $i < $loops; $i++) {
        str_replace("is not", "has been", $str);
    }
}

function bm_preg_replace($loops)
{
    global $str;
    var_dump($loops);
    for ($i = 0; $i < $loops; $i++)
    {
        preg_replace("/is not/", "has been", $str);
    }
}

function oo($loops){
    for ($i = 0; $i < $loops; $i++)
    {
        $a=1;
        $b=2;
        $c = $a+$b;
        $b=$c+$a;
    }
}