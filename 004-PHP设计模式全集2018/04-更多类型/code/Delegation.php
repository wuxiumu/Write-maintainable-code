<?php 
/** 
* 委托模式 示例 
* 
* @create_date: 2010-01-04 
*/ 
class PlayList 
{ 
    var $_songs = array(); 
    var $_object = null; 
    function PlayList($type) 
    { 
        $object = $type."PlayListDelegation"; 
        $this->_object = new $object(); 
    } 
    function addSong($location,$title) 
    { 
        $this->_songs[] = array("location"=>$location,"title"=>$title); 
    } 
    function getPlayList() 
    { 
        return $this->_object->getPlayList($this->_songs); 
    } 
} 

class mp3PlayListDelegation 
{ 
    function getPlayList($songs) 
    { 
        $aResult = array(); 
        foreach($songs as $key=>$item) 
        { 
            $path = pathinfo($item['location']); 
            if(strtolower($item['extension']) == "mp3") 
            { 
                $aResult[] = $item; 
            } 
        } 
        return $aResult; 
    } 
} 

class rmvbPlayListDelegation 
{ 
    function getPlayList($songs) 
    { 
        $aResult = array(); 
        foreach($songs as $key=>$item) 
        { 
            $path = pathinfo($item['location']); 
            if(strtolower($item['extension']) == "rmvb") 
            { 
                $aResult[] = $item; 
            } 
         } 
        return $aResult; 
    } 
} 

$oMP3PlayList = new PlayList("mp3"); 
$oMP3PlayList->getPlayList(); 

$oRMVBPlayList = new PlayList("rmvb"); 
$oRMVBPlayList->getPlayList(); 
?> 