<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/12/24
 * Time: 下午9:45
 */



class article{
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function decorator(){
        return $this->content;
    }
}

$art = new article('好好学习');
echo $art->decorator().PHP_EOL;
echo '====================='.PHP_EOL;


//文章需要 小编加摘要，，

class BianArticle extends article{
    public function summary(){
        return $this->content.'小编加了摘要';
    }
}
$art = new BianArticle('好好学习');
echo $art->summary().PHP_EOL;
echo '====================='.PHP_EOL;


//seo人员加个description
class SEOArticle extends BianArticle{
    public function seo(){
        //.....
    }
}


//广告部加个广告

class ADArticle extends SEOArticle{
    public function ad(){
        //......
    }
}


//================装饰器模式=====================

class BaseArt{
    protected $content;
    protected $art = null;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function decorator(){
        return $this->content;
    }
}

//文章需要 小编加摘要，，

class BianArt extends BaseArt {
    public function __construct(BaseArt $art)
    {
        $this->art = $art;
        $this->decorator();
    }

    public function decorator(){
        return $this->content = $this->art->decorator().'小编加了摘要';
    }
}

//seo人员加个description
class SEOArt extends BaseArt {
    public function __construct(BaseArt $art)
    {
        $this->art = $art;
        $this->decorator();
    }

    public function decorator(){
        return $this->content = $this->art->decorator().'seo关键词';
    }
}

$b = new BianArt(new BaseArt('天天向上'));
echo $b->decorator().PHP_EOL;
echo '====================='.PHP_EOL;
$s = new SEOArt($b);
echo $s->decorator();


