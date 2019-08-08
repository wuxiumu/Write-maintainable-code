<?php

// class BaseCloth{

//     protected $content;
//     public function __construct($con){
//         $this->content = $con;
//     }
//     public function cloth(){
//         return $this->content;
//     }
// }

// // class DyeingCloth extends BaseCloth{   //染色
// //     public function dyeing(){
// //         return $this->content."  --->染上色";
// //     }
// // }

// class DyeingCloth extends BaseCloth{
//     public function dyeing(){
//         return $this->content."  --->染上色";
//     }
// }

// class StampCloth extends DyeingCloth{
//     public function stamp(){
//         return $this->content."  --->印上好看的花";
//     }
// }

// class CutCloth extends StampCloth{
//     public function cut(){
//         return $this->content."   --->根据需求裁剪";
//     }
// }

// $cloth = new BaseCloth("白布");
// $dyeing = new DyeingCloth($cloth->cloth());
// $stamp = new StampCloth($dyeing->dyeing());
// $cut = new CutCloth($stamp->stamp());
// echo $cut->cut();

class BaseCloth{
    protected $content;
    public function __construct($con){
        $this->content = $con;
    }
    public function cloth(){
        return $this->content;
    }
}

class DyeingCloth extends BaseCloth{
    public function __construct(BaseCloth $cloth){
        $this->cloth = $cloth;
        $this->cloth();
    }
    public function cloth(){
        return $this->cloth->cloth()."   --->染上色";
    }
}

class StampCloth extends BaseCloth{
    public function __construct(BaseCloth $cloth){
        $this->cloth = $cloth;
        $this->cloth();
    }
    public function cloth(){
        return $this->cloth->cloth()."   --->印上花";
    }
}

class CutCloth extends BaseCloth{
    public function __construct(BaseCloth $cloth){
        $this->cloth = $cloth;
        $this->cloth();
    }
    public function cloth(){
        return $this->cloth->cloth()."   --->根据需求裁剪";
    }
}

$con = new CutCloth(new DyeingCloth(new BaseCloth("白色布")));
echo $con->cloth();