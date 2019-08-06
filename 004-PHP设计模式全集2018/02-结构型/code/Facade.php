<?php
class Camera {
  
    /**
     * 打开录像机
     */
    public function turnOn() {
        echo 'Turning on the camera.<br />';
    }

    /**
     * 关闭录像机
     */
    public function turnOff() {
        echo 'Turning off the camera.<br />';
    }

    /**
     * 转到录像机
     * @param <type> $degrees
     */
    public function rotate($degrees) {
        echo 'rotating the camera by ', $degrees, ' degrees.<br />';
    }
}

class Light {

    /**
     * 开灯
     */
    public function turnOn() {
        echo 'Turning on the light.<br />';
    }

    /**
     * 关灯
     */
    public function turnOff() {
        echo 'Turning off the light.<br />';
    }

    /**
     * 换灯泡
     */
    public function changeBulb() {
        echo 'changing the light-bulb.<br />';
    }
}

class Sensor {

    /**
     * 启动感应器
     */
    public function activate() {
        echo 'Activating the sensor.<br />';
    }

    /**
     * 关闭感应器
     */
    public function deactivate() {
        echo 'Deactivating the sensor.<br />';
    }

    /**
     * 触发感应器
     */
    public function trigger() {
        echo 'The sensor has been trigged.<br />';
    }
}

class Alarm {

    /**
     * 启动警报器
     */
    public function activate() {
        echo 'Activating the alarm.<br />';
    }

    /**
     * 关闭警报器
     */
    public function deactivate() {
        echo 'Deactivating the alarm.<br />';
    }

    /**
     * 拉响警报器
     */
    public function ring() {
        echo 'Ring the alarm.<br />';
    }

    /**
     * 停掉警报器
     */
    public function stopRing() {
        echo 'Stop the alarm.<br />';
    }
}

/**
 * 门面类
 */
class SecurityFacade {

    /* 录像机 */
    private $_camera1, $_camera2;

    /* 灯 */
    private $_light1, $_light2, $_light3;

    /* 感应器 */
    private $_sensor;

    /* 警报器 */
    private $_alarm;

    public function __construct() {
        $this->_camera1 = new Camera();
        $this->_camera2 = new Camera();

        $this->_light1 = new Light();
        $this->_light2 = new Light();
        $this->_light3 = new Light();

        $this->_sensor = new Sensor();
        $this->_alarm = new Alarm();
    }

    public function activate() {
        $this->_camera1->turnOn();
        $this->_camera2->turnOn();

        $this->_light1->turnOn();
        $this->_light2->turnOn();
        $this->_light3->turnOn();

        $this->_sensor->activate();
        $this->_alarm->activate();
    }

    public function deactivate() {
        $this->_camera1->turnOff();
        $this->_camera2->turnOff();

        $this->_light1->turnOff();
        $this->_light2->turnOff();
        $this->_light3->turnOff();

        $this->_sensor->deactivate();
        $this->_alarm->deactivate();
    }
}


/**
 * 客户端
 */
class Client {

    private static $_security;
    /**
     * Main program.
     */
    public static function main() {
        self::$_security = new SecurityFacade();
        self::$_security->activate();
    }
}
  
Client::main();
?>