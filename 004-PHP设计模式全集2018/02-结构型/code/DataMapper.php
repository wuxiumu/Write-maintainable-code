<?php  

//领域抽象类  

abstract class DomainObject {  

    private $id = -1;  

    function __construct( $id=null ) {  

        if ( is_null( $id ) ) {  

            $this->markNew();  

        } else {  

            $this->id = $id;  

        }  

    }  

    function getId( ) {  

        return $this->id;  

    }  

    static function getCollection( $type ) {  

        //这里通过一个工广生成此对象对应的数组数据对象  

        return HelperFactory::getCollection( $type );   

    }  

    function collection() {  

        return self::getCollection( get_class( $this ) );  

    }  

    function finder() {  

        return self::getFinder( get_class( $this ) );  

    }  

    static function getFinder( $type ) {  

        //这里通过一个工厂生成此对象对应的map对象  

        return HelperFactory::getFinder( $type );   

    }  

    function setId( $id ) {  

        $this->id = $id;  

    }  

    function __clone() {  

        $this->id = -1;  

    }  

}  

   

//场所类  

class Venue extends DomainObject {  

    private $name;  

    private $spaces;  

    function __construct( $id=null, $name=null ) {  

        $this->name = $name;  

        parent::__construct( $id );  

    }  

    function setSpaces( SpaceCollection $spaces ) {  

        $this->spaces = $spaces;  

    }   

    function getSpaces() {  

        if ( ! isset( $this->spaces ) ) {  

            //创建对应的SpaceMapper对象  

            $finder = self::getFinder( 'Space' );   

            $this->spaces = $finder->findByVenue( $this->getId() );  

            //$this->spaces = self::getCollection("Space");  

        }  

        return $this->spaces;  

    }   

    function addSpace( Space $space ) {  

        $this->getSpaces()->add( $space );  

        $space->setVenue( $this );  

    }  

    function setName( $name_s ) {  

        $this->name = $name_s;  

    }  

    function getName( ) {  

        return $this->name;  

    }  

    static function findAll() {  

        $finder = self::getFinder( __CLASS__ );   

        return $finder->findAll();  

    }  

    static function find( $id ) {  

        $finder = self::getFinder( __CLASS__ );   

        return $finder->find( $id );  

    }  
}  

abstract class Mapper{  

    protected static $PDO;   

    function __construct() {  

        if ( ! isset(self::$PDO) ) {   

            //此处可加缓存  

            self::$PDO = new PDO( $dsn );  

            self::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

        }  

    }  

    private function getFromMap( $id ) {  

        //从内存取出此$id的DomainObject对象  

    }  

    private function addToMap( DomainObject $obj ) {  

        //将此DomainObject对象加入到内存  

    }  

    function find( $id ) {  

        $old = $this->getFromMap( $id );  

        if ( $old ) { return $old; }  

        $this->selectstmt()->execute( array( $id ) );  

        $array = $this->selectstmt()->fetch( );   

        $this->selectstmt()->closeCursor( );  

        if ( ! is_array( $array ) ) { return null; }  

        if ( ! isset( $array['id'] ) ) { return null; }  

        $object = $this->createObject( $array );  

        return $object;   

    }  

    function findAll( ) {  

        $this->selectAllStmt()->execute( array() );  

        return $this->getCollection( $this->selectAllStmt()->fetchAll( PDO::FETCH_ASSOC ) );  

    }  

    function createObject( $array ) {  

        $old = $this->getFromMap( $array['id']);  

        if ( $old ) { return $old; }  

        $obj = $this->doCreateObject( $array );  

        $this->addToMap( $obj );  

        return $obj;  

    }  

    function insert( DomainObject $obj ) {  

        $this->doInsert( $obj );   

        $this->addToMap( $obj );  

    }  

    protected abstract function getCollection( array $raw );  

    protected abstract function doCreateObject( array $array );  

    protected abstract function doInsert( DomainObject $object );  

    protected abstract function targetClass();  

    protected abstract function selectStmt( );  

    protected abstract function selectAllStmt( );  

}  

class VenueMapper extends Mapper {  

    function __construct() {  

        parent::__construct();  

        $this->selectAllStmt = self::$PDO->prepare(   

                            "SELECT * FROM venue");  

        $this->selectStmt = self::$PDO->prepare(   

                            "SELECT * FROM venue WHERE id=?");  

        $this->updateStmt = self::$PDO->prepare(   

                            "UPDATE venue SET name=?, id=? WHERE id=?");  

        $this->insertStmt = self::$PDO->prepare(   

                            "INSERT into venue ( name )   

                             values( ? )");  

    }   

       

    function getCollection( array $raw ) {  

        //这里简单起见用个对象数组  

        $ret = array();  

        foreach ($raw as $value) {  

            $ret[] = $this->createObject($value);  

        }  

        return $ret;  

    }  

    protected function doCreateObject( array $array ) {  

        $obj = new Venue( $array['id'] );  

        $obj->setname( $array['name'] );  

        //$space_mapper = new SpaceMapper();  

        //$space_collection = $space_mapper->findByVenue( $array['id'] );  

        //$obj->setSpaces( $space_collection );  

        return $obj;  

    } 

    protected function targetClass() {  

        return "Venue";  

    }  

    protected function doInsert( DomainObject $object ) {  

        $values = array( $object->getname() );   

        $this->insertStmt->execute( $values );  

        $id = self::$PDO->lastInsertId();  

        $object->setId( $id );  

    }  

    function update( DomainObject $object ) {  

        $values = array( $object->getname(), $object->getid(), $object->getId() );   

        $this->updateStmt->execute( $values );  

    }  

    function selectStmt() {  

        return $this->selectStmt;  

    }  

    function selectAllStmt() {  

        return $this->selectAllStmt;  

    }  
}  

   

//client代码  

$venue = new venue();  

$venue->setName("XXXXXXX");  

//插入一条数据  

$mapper = new VenueMapper();  

$mapper->insert($venue);  

//获取刚插入的数据  

$venueInfo = $mapper->find($venue->getId());  

//修改数据   

$venue->setName('OOOOOOOOOOO');  

$mapper->update($venue);  

// 代码省略了一些辅助类，保留最主要的领域对象和数据映射器。
// 数据映射器模式最强大的地方在于消除了领域层和数据库操作之间的耦合。
// Mapper对象在幕后运作，可以应用于各种对象关系映射。
// 而与之带来的是需要创建大量具体的映射器类。
// 不过现在框架都可以通过程序自动生成了。
?>