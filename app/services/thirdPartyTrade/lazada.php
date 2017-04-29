<?php namespace App\services\thirdPartyTrade;
use Kacana\Lazada\Product as lazadaProduct;;

class lazada extends thirdPartyTradeAbstract  implements thirdPartyTradeInterface {
    public function postToThirdParty()
    {
        // TODO: Implement postToThirdParty() method.
    }

    public function getCategoryTree(){
        $lazadaProduct = new lazadaProduct();
        $categories = [];
        $cats = $lazadaProduct->getCategory();

        $categories[] = $cats[3]; // for fashion and travel
        $categories[] = $cats[15]; // for bagPack
        return $categories;
    }
}