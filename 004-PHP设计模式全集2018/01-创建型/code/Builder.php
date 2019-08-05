<?php
class UserInfo
{
    protected $_userName;
    protected $_userAge;
    protected $_userHobby;

    public function setUserName($userName)
    {
        $this->_userName = $userName;
    }

    public function setUserAge($userAge)
    {
        $this->_userAge = $userAge;
    }

    public function setUserHobby($userHobby)
    {
        $this->_userHobby = $userHobby;
    }

    public function getPeopleInfo()
    {
        echo  "<br>这个人的名字是：" . $this->_userName . "<br>年龄为：" . $this->_userAge . "<br>兴趣：" . $this->_userHobby;
    }
}

$modelUser = new UserInfo();
$modelUser->setUserName('韦小宝');
$modelUser->setUserAge('29');
$modelUser->setUserHobby('财富和美女');
$modelUser->getPeopleInfo();