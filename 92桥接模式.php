<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/12/25
 * Time: 下午9:07
 */


// 论坛给用户发信息，可以是站内信，email，手机

interface msg{
    function send($to,$content);
}


class zn implements msg{
    public function send($to, $content)
    {
        echo '站内信发送给' .$to.'。内容为：'.$content .PHP_EOL;
    }
}

class email implements msg{
    public function send($to, $content)
    {
        echo 'email发送给' .$to.'。内容为：'.$content .PHP_EOL;
    }
}

class sms implements msg{
    public function send($to, $content)
    {
        echo '短信发送给' .$to.'。内容为：'.$content .PHP_EOL;
    }
}



// 内容也分普通、加急、特急
/*class zncommon extends msg{}
class znwarn extends msg{}
class zndanger extends msg{}



class emailcommon extends email{}
class emailwarn extends email{}
class emaildanger extends email{}

.......
......
信的发送方式是一个变化因素
信的紧急程度也是一个变化因素
*/

// 桥接模式做适当的耦合
abstract class info{
    protected $send = null;

    abstract public function msg($content);

   // abstract public function send();
}

class commoninfo extends info{
    public function msg($content)
    {
        return '普通'.$content;
    }
}

class warninfo extends info{
    public function msg($content)
    {
        return '紧急'.$content;
    }
}

class dangerinfo extends info{
    public function msg($content)
    {
        return '特急'.$content;
    }
}
