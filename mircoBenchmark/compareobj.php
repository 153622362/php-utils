<?php
/**
 * 测试函数调用与方法之间的性能
 * 未优化
 * @date 2018.4.1
 */
require 'ubm.php';
class Adder{
    function add2($a, $b) { return $a+$b;}
    function add3($a, $b, $c) {return $a+$b+$c;}
}

function adder_add2($a, $b) { return $a + $b;}
function adder_add3($a, $b,$c) {return $a + $b +$c;}

function run_oo_bm2($count) {
    $adder = new Adder();
    for ($i = 0; $i <$count; $i++) {$adder->add2(5,7);}
}
function run_oo_bm3($count) {
    $adder = new Adder();
    for ($i = 0; $i <$count; $i++) {$adder->add3(5,7,9);}
}
function run_proc_bm2($count) {
    for ($i = 0; $i <$count; $i++) { adder_add2(5,7);}
}

function run_proc_bm3($count) {
    for ($i = 0; $i <$count; $i++) { adder_add3(5,7,9);}
}

$loops = 100000000;
micro_benchmark('proc_2_args', "run_proc_bm2", $loops);
micro_benchmark('proc_3_args', "run_proc_bm3", $loops);
micro_benchmark('oo_2_args', "run_proc_bm2", $loops);
micro_benchmark('oo_3_args', "run_proc_bm3", $loops);