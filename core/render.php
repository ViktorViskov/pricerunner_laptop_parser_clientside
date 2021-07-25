<?php
// 
// Class for render one page
// 

class Page_Render {
    // variables
    private $page_root;
    private $item_root;
    private $nav_items;
    private $items;
    private $nav_content = "";
    private $content = "";

    // constructor
    function __construct($items, $links) {

        // items to print
        $this->items = $items;
        $this->nav_items = $links;

        // page root
        $this->page_root = file_get_contents("./patterns/index.html");

        // item root
        $this->item_root = file_get_contents("./patterns/item.html");

        // item root
        $this->nav_item_root = file_get_contents("./patterns/nav_item.html");

        // crete page content
        $this->Create_Content();

        // print page
        $this->Print_Page();
    }

    // function for create content
    private function Create_Content(){
        // navigation
        foreach ($this->nav_items as $nav_item){
            $this->Create_Navigation_Item($nav_item['url'],$nav_item['content']);
        }
        // main loop
        foreach ($this->items as $item) {
            $this->Create_Item($item['link'],$item['title'],$item['image_url'],$item['geekbench_single'],$item['geekbench_multi'],$item['battery'],$item['resolution'],$item['CPU'],$item['price_old'],$item['price']);
        }
    }

    // function for create item
    private function Create_Item($link ,$title, $image, $single, $multi, $battery, $resolution, $cpu, $price_old, $price) {

        // new item
        $new_item = $this->item_root;

        // replace LINK
        $new_item = str_ireplace("!!!LINK!!!", $link, $new_item);
        // replace TITLE
        $new_item = str_ireplace("!!!TITLE!!!", $title, $new_item);
        // replace IMAGE
        $new_item = str_ireplace("!!!IMAGE!!!", $image, $new_item);
        // replace SINGLE
        $new_item = str_ireplace("!!!SINGLE!!!", $single, $new_item);
        // replace MULTI
        $new_item = str_ireplace("!!!MULTI!!!", $multi, $new_item);
        // replace BATTERY
        $new_item = str_ireplace("!!!BATTERY!!!", $battery, $new_item);
        // replace RESOLUTION
        $new_item = str_ireplace("!!!RESOLUTION!!!", $resolution, $new_item);
        // replace CPU
        $new_item = str_ireplace("!!!CPU!!!", $cpu, $new_item);
        // replace PRICE_OLD
        $new_item = str_ireplace("!!!PRICE_OLD!!!", $price_old, $new_item);
        // replace PRICE
        $new_item = str_ireplace("!!!PRICE!!!", $price, $new_item);
        
        // deal properties
        $new_item = str_ireplace("!!!PRICE_HIDDEN!!!", floatval($price_old) != floatval($price) ? 'block' : 'none', $new_item);
        $new_item = str_ireplace("!!!DEAL_COLOR!!!", floatval($price_old) != floatval($price) ? '#ffeedd' : '#ffffff', $new_item);

        // add to content
        $this->content .= $new_item;
    }

    // function for create navigation item
    private function Create_Navigation_Item($url, $content){
        // new item
        $new_item = $this->nav_item_root;

        // replace URL
        $new_item = str_ireplace("!!!LINK!!!", $url, $new_item);
        // replace CONTENT
        $new_item = str_ireplace("!!!CONTENT!!!", $content, $new_item);

        // add to nav item
        $this->nav_content .= $new_item;
    }

    // print page
    private function Print_Page(){
        // create navigate links
        $page = str_ireplace("!!!NAVIGATION!!!", $this->nav_content, $this->page_root);

        // total number
        $page = str_ireplace("!!!COUNT!!!", count($this->items), $page);

        // replace content
        $page = str_ireplace("!!!CONTENT!!!", $this->content, $page);

        // print page
        print($page);
    }

    // function for create navigation menu
    private function Navigation(){

    }
}