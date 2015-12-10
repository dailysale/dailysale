<?php

/**
 * WDCA - Sweet Tooth
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the WDCA SWEET TOOTH POINTS AND REWARDS
 * License, which extends the Open Software License (OSL 3.0).
 * The Sweet Tooth License is available at this URL:
 * https://www.sweettoothrewards.com/terms-of-service
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
 * @package    [TBT_RewardsCoreCustomer]
 * @copyright  Copyright (c) 2014 Sweet Tooth Inc. (http://www.sweettoothrewards.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Observer
 *
 * @category   TBT
 * @package    TBT_RewardsCoreCustomer
 * * @author     Sweet Tooth Inc. <support@sweettoothrewards.com>
 */
class TBT_RewardsCoreCustomer_Model_Customer_Observer extends Varien_Object
{
	/*
	 * Adds "My Points and Rewards" link in Customer Dashboard Navigation section
	 * @param Varien_Event_Observer $observer
	 */
	public function addCustomerDashboardLink($observer) {
		$block = $observer->getEvent()->getBlock();

		if (! ( $block instanceof Mage_Customer_Block_Account_Navigation ) ) {
			return $this;
		}

		// if TBT_RewardsCoreCustomer module output is disabled don't add the link
		if ( Mage::getStoreConfigFlag('advanced/modules_disable_output/TBT_RewardsCoreCustomer' )) {
			return $this;
		}

		$label = Mage::helper('rewards')->__("My Points and Rewards");
		$block->addLink("rewards", "rewards/customer/", $label);
		return $this;
	}
}
