<?php
    $fib =function($n)use(&$fib) {
        if($n == 0 || $n == 1) return 1;
        return $fib($n - 1) + $fib($n - 2);
    };
 
   echo $fib(2) . "\n";// 2
   $lie =$fib;
   $fib =function(){die('error');};//rewrite $fib variable 
   echo $lie(5);// error   because $fib is referenced by closure