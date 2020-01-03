<?php

class ShopRepository{

    public function getAllItems(){
        
        $items = file_get_contents("./src/data/items.json");

        $items = json_decode($items);

        return $items;
        
    }
}