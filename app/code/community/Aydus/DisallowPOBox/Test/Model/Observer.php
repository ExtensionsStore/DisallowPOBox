<?php

/**
 * DisallowPOBox observer test
 *
 * @category   Aydus
 * @package    Aydus_DisallowPOBox
 * @author     Aydus <davidt@aydus.com>
 */

class Aydus_DisallowPOBox_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case_Config
{    
    /**
     * Test observer
     *
     * @test
     * @loadFixture
     */
    public function checkAddressTest()
    {
        echo "\nStarting Aydus_DisallowPOBox test.";
        
        $model = Mage::getModel('aydus_disallowpobox/observer');
        $quote = Mage::getSingleton('sales/quote');
        $quote->load(1);
        $billingAddress = Mage::getModel('sales/quote_address');
        $billingAddress->load(1);
        $quote->setBillingAddress($billingAddress);
        $shippingAddress = Mage::getModel('sales/quote_address');
        $shippingAddress->load(2);
        $quote->setShippingAddress($shippingAddress);
        
        $checkoutSession = $this->getModelMock('checkout/session');
        $checkoutSession->expects($this->any())->method('getQuote')->will($this->returnValue($quote));
        $this->replaceByMock('singleton', 'checkout/session', $checkoutSession);        

        $observer = new Varien_Event_Observer();
        $event = new Varien_Event();
        $controller = Mage::app()->getFrontController();
        $response = Mage::app()->getResponse();
        $controller->setResponse($response);
        $event->setControllerAction($controller);
        $observer->setEvent($event);       
        
        $this->assertEventObserverDefined(
         'frontend', 'controller_action_postdispatch_checkout_onepage_saveBilling', 'aydus_disallowpobox/observer', 'checkAddress'
        );
        $event->setName('controller_action_postdispatch_checkout_onepage_saveBilling');
        
        $error = $model->checkAddress($observer);
        $this->assertTrue($error);
        
        $this->assertEventObserverDefined(
         'frontend', 'controller_action_postdispatch_checkout_onepage_saveShipping', 'aydus_disallowpobox/observer', 'checkAddress'
        );
        $event->setName('controller_action_postdispatch_checkout_onepage_saveShipping');
        
        $error = $model->checkAddress($observer);
        $this->assertTrue($error);
        
        echo "\nCompleted Aydus_DisallowPOBox test.";

    }

}