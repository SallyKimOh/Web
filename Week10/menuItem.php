<?php

    class menuItem {
        private $itemName;
        private $description;
        private $price;
                
		function __construct($itemName, $description, $price){
				$this->setItemName($itemName);
				$this->setDescription($description);
				$this->setPrice($price);
		}

		public function getItemName(){
			return $this->itemName;
		}
		
		public function setItemName($itemName){
			$this->itemName = $itemName;
		}
		public function getDescription(){
			return $this->description;
		}
		
		public function setDescription($description){
			$this->description = $description;
		}
		public function getPrice(){
			return $this->price;
		}
		
		public function setPrice($price){
			$this->price = $price;
		}
    }


	class menu extends menuItem{
		private $menuItems;
		
		function __construct($itemName, $description, $price, $menuItems){
			parent::__construct($itemName, $description, $price);
			$this->menuItems = $menuItems;
		}
		public function getMenuItems(){
			return $this->menuItems;
		}
		
		public function setMenuItems($menuItems){
			$this->menuItems = $menuItems;
		}
	}
                             
                             
?>