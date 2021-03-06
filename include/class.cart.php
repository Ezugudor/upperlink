<?php 

	class ShoppingCart{
	     private $items = array();
	     private $grossAmount = 0;
	     private $netAmount = 0;
	     private $chargePerItem = 10;

	     function __construct($items){
	     	$this->items = $items;
	     	foreach ($items as $key => $value) {
	     		$this->netAmount += $value['price'];
	     		$this->grossAmount += $value['price'] + $this->chargePerItem;
	     	}
	     }

	     function getGrossAmount(){
              return $this->grossAmount;
	     }
	     function getNetAmount(){
	     	  return $this->netAmount;
	     }
	     function getTotalItems(){
              return count($this->items);
	     }
	     function getSavedItems(){
              global $con;
              $stmt = $con->prepare("SELECT a.id,a.name,a.descr,a.price,a.size,a.image,b.name from items a left join colors b on a.color = b.id where a.visibility = '1'");
		      $stmt->execute();
		      $stmt->bind_result($itemID,$itemName,$itemDesc,$itemPrice,$itemSize,$itemImage,$itemColor);
              while($stmt->fetch()){
           ?>  
          <div class="col-md-2">
		          <div class="inside-grid shadow">
		            <div class="img">
		              <img src="<?php printf('%s%s',IMG_PATH,$itemImage); ?>" alt="">
		            </div>
		            <h4><?php printf('%s',$itemName); ?></h4>
		            <div class="item-info">
		                 <label>price : </label>
		                 <span class="price"><?php printf('N%s',$itemPrice); ?></span>
		                 <div class="clearfix"></div>
		            </div>
		            <div class="item-info">
		                 <label>color : </label>
		                 <span class="price"><?php printf('%s',$itemColor); ?></span>
		                 <div class="clearfix"></div>
		            </div>
		            <div class="divider"></div>
		            <div class="caption">
		               <p><?php printf('%s',$itemDesc); ?></p>
		            </div>
		            <!-- <div class="divider"></div> -->
		            <a href="#" class="add-btn btn btn-default btn-sm " data-id="<?php printf('%s',$itemID); ?>">Add to Cart</a>
		          </div>
		</div>


		<?php } 
	     

	}

}

?>