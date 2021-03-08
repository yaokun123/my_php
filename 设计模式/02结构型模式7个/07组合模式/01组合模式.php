<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午3:52
 */


/**
 * 组合模式（有时候又叫做部分-整体模式），将对象组合成树形结构以表示“部分整体”的层次结构。
 * 组合模式使得用户对单个对象和组合对象的使用具有一致性。
 * 它使我们树型结构的问题中，模糊了简单元素和复杂元素的概念，客户程序可以像处理简单元素一样来处理复杂元素,
 * 从而使得客户程序与复杂元素的内部结构解耦。
 */



/**抽象结构角色          公司
 * Class Company
 */
abstract class Company
{
    protected $name;

    function __construct($name)
    {
        $this->name=$name;
    }

    /**增加
     * @param Company $company    子公司，部门
     * @return mixed
     */
    abstract function Add(Company $company);

    /**移除
     * @param Company $company   子公司，部门
     * @return mixed
     */
    abstract function Remove(Company $company);

    /**显示公司及部门结构
     * @param $depth
     * @return mixed
     */
    abstract function Display($depth);

}

/**枝节点               子公司
 * Class Beijing
 */
class SubCompany extends Company
{

    private $sub_companys=array();

    function __construct($name)
    {
        parent::__construct($name);
    }

    function Add(Company $company)
    {
        $this->sub_companys[]=$company;
    }

    function Remove(Company $company)
    {
        $key=array_search($company,$this->sub_companys);
        if($key!==false)
        {
            unset($this->sub_companys[$key]);
        }
    }

    function Display($depth)
    {
        $pre="";
        for($i=0;$i<$depth;$i++)
        {
            $pre.="-";
        }
        $pre.=$this->name."<br/>";
        echo $pre;

        foreach($this->sub_companys as $v)
        {
            $v->Display($depth+2);
        }
    }

}

/**叶子节点                    财务部
 * Class DeptCompany
 */
class MoneyDept extends Company
{

    function __construct($name)
    {
        parent::__construct($name);
    }

    /**增加
     * @param Company $company 子公司，部门
     * @return mixed
     */
    function Add(Company $company)
    {
        echo "叶子节点，不能继续添加节点。。。。。。。。。。<br/>";
    }

    /**移除
     * @param Company $company 子公司，部门
     * @return mixed
     */
    function Remove(Company $company)
    {
        echo "叶子节点，不能删除节点。。。。。。。。。。<br/>";
    }

    /**显示公司及部门结构
     * @param $depth
     * @return mixed
     */
    function Display($depth)
    {
        $pre="";
        for($i=0;$i<$depth;$i++)
        {
            $pre.="-";
        }
        $pre.=$this->name."<br/>";
        echo $pre;
    }

}

/**叶子节点                    技术部门
 * Class DeptCompany
 */
class TechnologyDept extends Company
{

    function __construct($name)
    {
        parent::__construct($name);
    }

    /**增加
     * @param Company $company 子公司，部门
     * @return mixed
     */
    function Add(Company $company)
    {
        echo "叶子节点，不能继续添加节点。。。。。。。。。。<br/>";
    }

    /**移除
     * @param Company $company 子公司，部门
     * @return mixed
     */
    function Remove(Company $company)
    {
        echo "叶子节点，不能删除节点。。。。。。。。。。<br/>";
    }

    /**显示公司及部门结构
     * @param $depth
     * @return mixed
     */
    function Display($depth)
    {
        $pre="";
        for($i=0;$i<$depth;$i++)
        {
            $pre.="-";
        }
        $pre.=$this->name."<br/>";
        echo $pre;
    }

}



// 测试代码：
$root=new SubCompany("北京总公司");
$root->Add(new MoneyDept("总公司财务部"));
$root->Add(new TechnologyDept("总公司技术部"));

$shanghai=new SubCompany("上海分公司");
$shanghai->Add(new TechnologyDept("上海分公司技术部"));
$shanghai->Add(new MoneyDept("上海分公司财务部"));

$root->Add($shanghai);

$root->Display(1);

echo "<hr/>";

$root->Remove($shanghai);
$root->Display(3);
