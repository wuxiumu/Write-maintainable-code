<?php
//抽象同事类，家教
abstract class Tutor{
    protected $message;   //个人信息
    protected $mediator;  //为家教服务的中介机构
    function __construct($message,Mediator $mediator){
        $this->message = $message;
        $this->mediator = $mediator;
    }
    //获取个人信息
    function getMessage(){
        return $this->message;
    }
    //找学生
    abstract function findStudent();
}
//具体同事类,大学生家教
class UndergraduateTutor extends Tutor{
   //家教类型
   public $type = "UndergraduateTutor";
 
   function __construct($message,Mediator $mediator){
          parent::__construct($message,$mediator);
   }
   //找学生,让中介机构代为寻找
   function findStudent(){
         $this->mediator->matchStudent($this);
   }
}
//具体同事类,高中生家教
class SeniorStudentTutor extends Tutor{
    //家教类型
   public $type = "SeniorStudentTutor";
   
   function __construct($message,Mediator $mediator){
          parent::__construct($message,$mediator);
   }
   //找学生,让中介机构代为寻找
   function findStudent(){
         $this->mediator->matchStudent($this);
   }
}
//具体同事类,初中生家教
class MiddleStudentTutor extends Tutor{
    //家教类型
   public $type = "MiddleStudentTutor";
   
   function __construct($message,Mediator $mediator){
          parent::__construct($message,$mediator);
   }
   //找学生,让中介机构代为寻找
   function findStudent(){
         $this->mediator->matchStudent($this);
   }
}
 
//抽象中介类
abstract class AbstractMediator{
    abstract function matchStudent(Tutor $tutor);
}
//具体中介类，为家教匹配合适的学生
class Mediator extends AbstractMediator{
    //定义其服务的所有家教，不在范围内的不服务
    private $serveObject = array("UndergraduateTutor","SeniorStudentTutor","MiddleStudentTutor");
    //匹配学生  
    function matchStudent(Tutor $tutor){
         for($i=0;$i<count($this->serveObject);$i++){
              if($tutor->type == $this->serveObject[$i]){
                  $message = $tutor->getMessage();
                  echo "该家教个人信息为".print_r($message)."<br/>将为其匹配合适的学生";
                  break;
              }
         }
         if($i>=count($this->serveObject)){
             echo "该家教不在我中介机构服务范围内";
         }
    }
}
 
//测试
$mediator = new Mediator();
$undergraduateTutor = new UndergraduateTutor(array("name"=>"张三","age"=>22),$mediator);
$undergraduateTutor->findStudent();
//结果：该家教个人信息为 Array ( [name] => 张三 [age] => 22 ),将为其匹配合适的学生
 