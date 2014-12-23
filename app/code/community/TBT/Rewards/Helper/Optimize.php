<?php

/**
 * WDCA - Sweet Tooth
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the WDCA SWEET TOOTH POINTS AND REWARDS 
 * License, which extends the Open Software License (OSL 3.0).

 * The Open Software License is available at this URL: 
 * http://opensource.org/licenses/osl-3.0.php
 * 
 * DISCLAIMER
 * 
 * By adding to, editing, or in any way modifying this code, WDCA is 
 * not held liable for any inconsistencies or abnormalities in the 
 * behaviour of this code. 
 * By adding to, editing, or in any way modifying this code, the Licensee
 * terminates any agreement of support offered by WDCA, outlined in the 
 * provided Sweet Tooth License. 
 * Upon discovery of modified code in the process of support, the Licensee 
 * is still held accountable for any and all billable time WDCA spent 
 * during the support process.
 * WDCA does not guarantee compatibility with any other framework extension. 
 * WDCA is not responsbile for any inconsistencies or abnormalities in the
 * behaviour of this code if caused by other framework extension.
 * If you did not receive a copy of the license, please send an email to 
 * support@sweettoothrewards.com or call 1.855.699.9322, so we can send you a copy 
 * immediately.
 * 
 * @category   [TBT]
 * @package    [TBT_Rewards]
 * @copyright  Copyright (c) 2014 Sweet Tooth Inc. (http://www.sweettoothrewards.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Helper Optimize
 * Functionality for most of this moved to the Rewards Catalog Product model
 * @see TBT_Rewards_Model_Catalog_Product
 * 
 * @deprecated
 *
 * @category   TBT
 * @package    TBT_Rewards
 * * @author     Sweet Tooth Inc. <support@sweettoothrewards.com>
 */
class TBT_Rewards_Helper_Optimize extends Mage_Core_Helper_Abstract {
	
	/**
	 * Returns an array of the lowest possible price using points, 
	 * and the points used to obtain that price
	 * 
	 * @deprecated
	 * 
	 * @param TBT_Rewards_Model_Catalog_Product $product 
	 * @return array
	 */
	public function getRewardAdjustedPrice($product) {
		
		if ($product instanceof Mage_Catalog_Model_Product) {
			$product = TBT_Rewards_Model_Catalog_Product::wrap ( $product );
		}
		if (! ($product instanceof TBT_Rewards_Model_Catalog_Product)) {
			$product = Mage::getModel ( 'rewards/catalog_product' )->load ( $product->getId () );
		}
		$optimized_price = $product->getRewardAdjustedPrice ();
		
		return $optimized_price;
	}

}

?>