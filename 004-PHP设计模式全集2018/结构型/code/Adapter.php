<?php
// 老的代码     
class User {    
    private $name;    
    function __construct($name) {    
        $this->name = $name;    
    }    
    public function getName() {    
        return $this->name;    
    }    
} 

// 新代码，开放平台标准接口    
interface UserInterface {    
    function getUserName();    
}   
 
class UserInfo implements UserInterface {    
    protected $user;    
    function __construct($user) {    
        $this->user = $user;    
    }    
    public function getUserName() {    
        return $this->user->getName();    
    }    
}   

$olduser = new User('张三');    
echo $olduser->getName()."<br>";    

$newuser = new UserInfo($olduser);    
echo $newuser->getUserName()."<br>";  