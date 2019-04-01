<?php
namespace Frame\Vendor;
//定i最终的Pager类
final class Pager
{
    private $records;
    private $pages;
    private $pagesize;
    private $page;
    private $url;
    private $first;
    private $last;
    private $prev;
    private $next;
    public function __construct($records,$pagesize,$page,$params=array())
    {
        $this->records = $records;
        $this->pagesize = $pagesize;
        $this->pages = $this->getPages();
    }
    private function getUrl($params=array())
    {
       foreach($params as $key=>$value)
       {
           $arr[]="$key=$value";
       }
       return "?".implode("&",$arr)."&page=";
    }
    private function getPages()
    {
        return ceil($this->records/$this->pagesize);
    }

}
