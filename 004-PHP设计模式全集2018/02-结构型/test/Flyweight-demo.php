<?php

interface Shape{
    public function draw();
}

class Circle implements Shape {
    private $color;
    private $radius;
    
    public function __construct($color) {
        $this->color = $color;
    }
    
    public function draw() {
        echo sprintf('Color %s, radius %s <br/>', $this->color,
            $this->radius);
    }
    
    public function setRadius($radius) {
        $this->radius = $radius;
    }
}

class ShapeFactory {
    private $circleMap;
    
    public function getCircle($color) {
        if (!isset($this->cicrleMap[$color])) {
            $circle = new Circle($color);
            $this->circleMap[$color] = $circle;
        }
        return $this->circleMap[$color];
    }
}

$shapeFactory = new ShapeFactory();
$circle = $shapeFactory->getCircle('yellow');
$circle->setRadius(10);
$circle->draw();

$shapeFactory = new ShapeFactory();
$circle = $shapeFactory->getCircle('orange');
$circle->setRadius(15);
$circle->draw();

$shapeFactory = new ShapeFactory();
$circle = $shapeFactory->getCircle('yellow');
$circle->setRadius(20);
$circle->draw();