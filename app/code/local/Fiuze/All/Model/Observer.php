<?php

/**
 * Observer Model
 *
 * @category    Fiuze
 * @package     Fiuze_All
 * @author      Alena Tsareva <alena.tsareva@webinse.com>
 */
class Fiuze_All_Model_Observer{

    /**
     * Change product availability
     *
     * 'Automatically Return Credit Memo Item to Stock' should be set to 'Yes'
     * you can change this option in the Catalog->Inventory->Product Stock Options tab
     *
     * use event 'sales_order_creditmemo_save_after'
     *
     * @param Varien_Event_Observer $observer
     */
    public function returnProductToStock(Varien_Event_Observer $observer){
        $creditmemo = $observer->getEvent()->getCreditmemo();
        foreach($creditmemo->getAllItems() as $item){

            /* @var $item Mage_Sales_Model_Order_Creditmemo_Item */
            if($item->hasBackToStock()){
                if($item->getQty()){
                    $stock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($item->getProductId());
                    $stock->setData('is_in_stock', 1);
                    $stock->save();
                }
            }
        }
    }

    /**
     * Check Captcha On User Login Page
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Captcha_Model_Observer
     */
    public function checkUserLogin($observer)
    {
        $configValue = Mage::getStoreConfig('customer/captcha/enable');
        if(!$configValue){
            return;
        }
        $controller = $observer->getControllerAction();
        $this->checkCaptcha($controller, 'user_login');
    }

    /**
     * Check Captcha On create user
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Captcha_Model_Observer
     */
    public function userRegister($observer)
    {
        $configValue = Mage::getStoreConfig('customer/captcha/enable');
        if(!$configValue){
            return;
        }
        $controller = $observer->getControllerAction();
        $this->checkCaptcha($controller, 'user_create');
    }

    /**
     * Check Captcha On forgot password
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Captcha_Model_Observer
     */
    public function forgotPassword($observer)
    {
        $configValue = Mage::getStoreConfig('customer/captcha/enable');
        if(!$configValue){
            return;
        }
        $controller = $observer->getControllerAction();
        $this->checkCaptcha($controller, 'user_forgotpassword');
    }

    public function checkCaptcha($controller, $formId){
        $captchaModel = Mage::helper('captcha')->getCaptcha($formId);
        $word = $this->_getCaptchaString($controller->getRequest(), $formId);
        if (!$captchaModel->isCorrect($word)) {
            $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
            $response['error'] = 1;
            $response['message'] = $controller->__('Incorrect CAPTCHA.');
            $controller->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        }
    }





    /**
     * Get Captcha String
     *
     * @param Varien_Object $request
     * @param string $formId
     * @return string
     */
    protected function _getCaptchaString($request, $formId)
    {
        $captchaParams = $request->getPost(Mage_Captcha_Helper_Data::INPUT_NAME_FIELD_VALUE);
        return $captchaParams[$formId];
    }
} 