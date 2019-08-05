<?php
  /**
   * Generic Factory class
   * This Factory will remember all operations you perform on it,
   * and apply them to the object it instantiates.
   */
  class FruitFactory {
    private $history, $class, $constructor_args;
    /**
     * Create a factory of given class. Accepts extra arguments to be passed to
     * class constructor.
     */
    function __construct( $class ) {
      $args = func_get_args();
      $this->class = $class;
      $this->constructor_args = array_slice( $args, 1 );
    }
    function __call( $method, $args ) {
      $this->history[] = array(
        'action'  => 'call',
        'method'  => $method,
        'args'  => $args
      );
    }
    function __set( $property, $value ) {
      $this->history[] = array(
        'action'  => 'set',
        'property'  => $property,
        'value'    => $value
      );
    }
    /**
     * Creates an instance and performs all operations that were done on this MagicFactory
     */
    function instance() {
      # use Reflection to create a new instance, using the $args
      $reflection_object = new ReflectionClass( $this->class ); 
      $object = $reflection_object->newInstanceArgs( $this->constructor_args ); 
      # Alternative method that doesn't use ReflectionClass, but doesn't support variable
      # number of constructor parameters.
      //$object = new $this->class();
      # Repeat all remembered operations, apply to new object.
      foreach( $this->history as $item ) {
        if( $item['action'] == 'call' ) {
          call_user_func_array( array( $object, $item['method'] ), $item['args'] );
        }
        if( $item['action'] == 'set' ) {
          $object->{$item['property']} = $item['value'];
        }
      }
      # Done
      return $object;
    }
  }
  class Fruit {
    private $name, $color;
    public $price;
    function __construct( $name, $color ) {
      $this->name = $name;
      $this->color = $color;
    }
    function setName( $name ) {
      $this->name = $name;
    }
    function introduce() {
      print "Hello, this is an {$this->name} {$this->sirname}, its price is {$this->price} RMB.";
    }
  }
  # Setup a factory
  $fruit_factory = new FruitFactory('Fruit', 'Apple', 'Gonn');
  $fruit_factory->setName('Apple');
  $fruit_factory->price = 2;
  # Get an instance
  $apple = $fruit_factory->instance();
  $apple->introduce();
?>