<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/2/25
 * Time: 上午10:30
 */
class MySmarty{
    private $varr = array();

    //向模版分配变量
    public function assign($vname,$value){
        $this->varr[$vname] = $value;
    }

    //加载并编译指定模版
    public function display($tplname){
        $tpl = "./templates/".$tplname;
        $tpl_c = "./templates_c/".$tplname.'_compile.php';

        if(!file_exists($tpl_c) || filemtime($tpl_c)<filemtime($tpl)){
            $tplfile = file_get_contents($tpl);
            $preg = '/\{\s*\$([a-zA-Z_]\w*)\s*\}/';
            $replace = "<?php echo \$this->varr['\\1'];?>";
            $tpl_cfile = preg_replace($preg,$replace,$tplfile);
            file_put_contents($tpl_c,$tpl_cfile);
        }

        include_once $tpl_c;
    }
}