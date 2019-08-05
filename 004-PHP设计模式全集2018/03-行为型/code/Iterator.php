<?php
/**
 * 该类允许外部迭代自己内部私有属性$_test，并演示迭代过程
 *
 */
class TestIterator implements Iterator {
  /*
   * 定义要进行迭代的数组
   */
  private $_test = array('dog', 'cat', 'pig');
  /*
   * 索引游标
   */
  private $_key = 0;
  /*
   * 执行步骤
   */
  private $_step = 0;
  /**
   * 将索引游标指向初始位置
   *
   * @see TestIterator::rewind()
   */
  public function rewind() {
    echo '第'.++$this->_step.'步：执行 '.__METHOD__.'<br>';
    $this->_key = 0;
  }
  /**
   * 判断当前索引游标指向的元素是否设置
   *
   * @see TestIterator::valid()
   * @return bool
   */
  public function valid() {
    echo '第'.++$this->_step.'步：执行 '.__METHOD__.'<br>';
    return isset($this->_test[$this->_key]);
  }
  /**
   * 将当前索引指向下一位置
   *
   * @see TestIterator::next()
   */
  public function next() {
    echo '第'.++$this->_step.'步：执行 '.__METHOD__.'<br>';
    $this->_key++;
  }
  /**
   * 返回当前索引游标指向的元素的值
   *
   * @see TestIterator::current()
   * @return value
   */
  public function current() {
    echo '第'.++$this->_step.'步：执行 '.__METHOD__.'<br>';
    return $this->_test[$this->_key];
  }
  /**
   * 返回当前索引值
   *
   * @return key
   * @see TestIterator::key()
   */
  public function key() {
    echo '第'.++$this->_step.'步：执行 '.__METHOD__.'<br>';
    return $this->_key;
  }
}
$iterator = new TestIterator();
foreach($iterator as $key => $value){
  echo "输出索引为{$key}的元素".":$value".'<br><br>';
}
?>