<?php
namespace Kacana\Lazada;

class Product extends BaseLazada {
    public function createProduct(){

    }

    public function getCategory(){
        return $this->getCategoryTree();
    }

}