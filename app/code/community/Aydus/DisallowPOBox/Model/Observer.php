<?php

/**
 * DisallowPOBox observer
 *
 * @category    Aydus
 * @package     Aydus_DisallowPOBox
 * @author      Aydus <davidt@aydus.com>
 */
class Aydus_DisallowPOBox_Model_Observer 
{

	/**
	 * PO Boxes are validated on front end js
	 * Additional check for PO Boxes
	 *
	 * @param Varien_Event_Observer $observer
	 */	
	public function checkAddress(Varien_Event_Observer $observer)
	{
        $storeId = Mage::app()->getStore()->getId();
	    $event = $observer->getEvent();
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $address = Mage::getModel('customer/address');
        $disallowPOBoxes = false;
        	
        if ($event->getName() == 'controller_action_postdispatch_checkout_onepage_saveBilling') {
            	
            $address = $quote->getBillingAddress();
            $disallowPOBoxes = Mage::getStoreConfig('customer/address/disallow_poboxes', $storeId);
            
        } else {
            
            $address = $quote->getShippingAddress();
            $disallowPOBoxes = Mage::getStoreConfig('shipping/option/disallow_poboxes', $storeId);
        }
        
        if ($disallowPOBoxes){
            
            $streets = $address->getStreet();
            
            $streets = (is_array($streets)) ? $streets : array($streets);
            $pattern = Aydus_DisallowPOBox_Model_DisallowPOBox::POBOX_PATTERN;
            
            foreach ($streets as $street){
                
                if (preg_match($pattern, $street)){
                
                    $message = Mage::helper('aydus_disallowpobox')->__('P.O. Boxes are not allowed.');
                    Mage::throwException($message);
                }                    
            }
            
        }
	    
	    return $this;
		
	}
	
}


