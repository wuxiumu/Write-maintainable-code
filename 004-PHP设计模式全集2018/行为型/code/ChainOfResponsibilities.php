<?php
/*
    责任链模式通过以链式方式启用多个对象来处理请求，从而将请求的发送方与其接收方解耦。
    可以动态地向链中添加各种类型的处理对象。
    使用递归组合链允许无限数量的处理对象。
*/

abstract class SocialNotifier {
    private $notifyNext = null;
    
    public function notifyNext(SocialNotifier $notifyNext) {
        $this->notifyNext = $notifyNext;
        return $this->notifyNext;
    }
    
    final public function push($message) {
        $this->publish($message);
        
        if ($this->notifyNext !== null) {
            $this->notifyNext->push($message);
        }
    }
    
    abstract protected function publish($message);
}

class TwitterSocialNotifier extends SocialNotifier {
    public function publish($message) {
        echo 'TwitterSocialNotifier_publish' . $message . '<br/>'; 
    }
}

class FacebookSocialNotifier extends SocialNotifier {
    protected function publish($message) {
        echo 'FacebookSocialNotifier_publish' . $message . '<br/>'; 
    }
}

class PinterestSocialNotifier extends SocialNotifier {
    protected function publish($message) {
        echo 'PinterestSocialNotifierr_publish' . $message . '<br/>'; 
    }
}

$notifier = new TwitterSocialNotifier();

$notifier->notifyNext(new FacebookSocialNotifier())
    ->notifyNext(new PinterestSocialNotifier());
$notifier->push('Awesome new product availiable.')


?>