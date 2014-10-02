<?php

class TM_NewsletterBooster_Block_Adminhtml_Template_Edit extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('newsletterbooster/email/template/edit.phtml');
    }

    protected function _prepareLayout()
    {
        $this->setChild('back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('adminhtml')->__('Back'),
                        'onclick' => "window.location.href = '" . $this->getUrl('*/*') . "'",
                        'class'   => 'back'
                    )
                )
        );

        $this->setChild('delete_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('adminhtml')->__('Delete'),
                        'onclick' => 'templateControl.deleteTemplate();',
                        'class'   => 'delete'
                    )
                )
        );

        $this->setChild('to_plain_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('adminhtml')->__('Convert to Plain Text'),
                        'onclick' => 'templateControl.stripTags();',
                        'id'      => 'convert_button'
                    )
                )
        );


        $this->setChild('to_html_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('adminhtml')->__('Return Html Version'),
                        'onclick' => 'templateControl.unStripTags();',
                        'id'      => 'convert_button_back',
                        'style'   => 'display:none'
                    )
                )
        );

        $this->setChild('toggle_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('adminhtml')->__('Toggle Campaign'),
                        'onclick' => 'templateControl.toggleEditor();',
                        'id'      => 'toggle_button'
                    )
                )
        );


        $this->setChild('preview_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('adminhtml')->__('Preview'),
                        'onclick' => 'templateControl.preview();'
                    )
                )
        );

        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('adminhtml')->__('Save'),
                        'onclick' => 'templateControl.save();',
                        'class'   => 'save'
                    )
                )
        );

        $this->setChild('load_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('adminhtml')->__('Load Template'),
                        'onclick' => 'templateControl.load();',
                        'type'    => 'button',
                        'class'   => 'save'
                    )
                )
        );

        $url = Mage::helper("adminhtml")->getUrl("*/*/sendCampaign");
        $urlSuccess = Mage::helper("adminhtml")->getUrl("*/*/edit", array('id'=>$this->getRequest()->getParam('id')));

        $this->setChild('send_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('newsletterbooster')->__('Send Test'),
                        'class'   => 'save',
                        'onclick'   => "
                            function sendRequest(clearSession) {
                                var params = $('email_template_edit_form').serialize(true);
                                params['clear_session'] = clearSession;
                                new Ajax.Request('".$url."', {
                                    method: 'post',
                                    parameters: params,
                                    onSuccess: showResponse
                                });
                            }

                            function showResponse(response) {
                                var response = response.responseText.evalJSON();
                                if (!response.completed) {
                                    sendRequest(0);
                                    var imageSrc = $('loading_mask_loader').select('img')[0].src;
                                    $('loading_mask_loader').innerHTML = '<img src=\'' + imageSrc + '\'/><br/>' + response.message;
                                } else {
                                    window.location = '" . $urlSuccess . "'
                                }
                            }
                            sendRequest(1);
                        ",
                    )
                )
        );

        if ($this->getEmailTemplate()->getCampaignId()) {
            $queueUrl = Mage::helper("adminhtml")->getUrl(
                "*/newsletterbooster_queue/edit",
                array('campaign' => $this->getEmailTemplate()->getCampaignId())
            );

            $this->setChild('queue_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(
                        array(
                            'label'   => Mage::helper('newsletterbooster')->__('Queue'),
                            'onclick' => "window.location.href = '" . $queueUrl . "'",
                            'class'   => 'save'
                        )
                    )
            );
        }
        
        $this->setChild('queue_save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'   => Mage::helper('newsletterbooster')->__('Save and Queue'),
                        'onclick' => "templateControl.saveQueue();",
                        'class'   => 'save'
                    )
                )
        );

        $this->setChild('form',
            $this->getLayout()->createBlock('newsletterbooster/adminhtml_template_edit_form')
        );

        if (!$this->getRequest()->isXmlHttpRequest()) {
            if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
                $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            }
        }

        return parent::_prepareLayout();
    }

    public function getBackButtonHtml()
    {
        return $this->getChildHtml('back_button');
    }

    public function getToggleButtonHtml()
    {
        return $this->getChildHtml('toggle_button');
    }


    public function getResetButtonHtml()
    {
        return $this->getChildHtml('reset_button');
    }

    public function getToPlainButtonHtml()
    {
        return $this->getChildHtml('to_plain_button');
    }

    public function getToHtmlButtonHtml()
    {
        return $this->getChildHtml('to_html_button');
    }

    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('save_button');
    }

    public function getSendButtonHtml()
    {
        return $this->getChildHtml('send_button');
    }

    public function getPreviewButtonHtml()
    {
        return $this->getChildHtml('preview_button');
    }

    public function getDeleteButtonHtml()
    {
        return $this->getChildHtml('delete_button');
    }

    public function getLoadButtonHtml()
    {
        return $this->getChildHtml('load_button');
    }

    public function getQueueButtonHtml()
    {
        return $this->getChildHtml('queue_button');
    }
    
    public function getQueueSaveButtonHtml()
    {
        return $this->getChildHtml('queue_save_button');
    }

    /**
     * Return edit flag for block
     *
     * @return boolean
     */
    public function getEditMode()
    {
        return $this->getEmailTemplate()->getCampaignId();
    }

    /**
     * Return header text for form
     *
     * @return string
     */
    public function getHeaderText()
    {
        if($this->getEditMode()) {
          return Mage::helper('newsletterbooster')->__('Edit Campaign - %s', $this->getEmailTemplate()->getTemplateCode());
        }

        return  Mage::helper('newsletterbooster')->__('New Campaign');
    }


    /**
     * Return form block HTML
     *
     * @return string
     */
    public function getFormHtml()
    {
        return $this->getChildHtml('form');
    }

    /**
     * Return action url for form
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array('_current' => true));
    }

    public function getSendUrl()
    {
        return $this->getUrl('*/*/sendCampaign');
    }

    /**
     * Return preview action url for form
     *
     * @return string
     */
    public function getPreviewUrl()
    {
        return $this->getUrl('*/*/preview');
    }

    public function isTextType()
    {
        return $this->getEmailTemplate()->isPlain();
    }

    /**
     * Return delete url for customer group
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array('_current' => true));
    }

    /**
     * Retrive email template model
     *
     * @return Mage_Core_Model_Email_Template
     */
    public function getEmailTemplate()
    {
        return Mage::registry('current_email_template');
    }

    public function getLocaleOptions()
    {
        return Mage::app()->getLocale()->getOptionLocales();
    }

    public function getTemplateOptions()
    {
        return TM_NewsletterBooster_Model_Campaign::getEmailTemplatesAsOptionsArray();
    }

    public function getCurrentLocale()
    {
        return Mage::app()->getLocale()->getLocaleCode();
    }

    /**
     * Load template url
     *
     * @return string
     */
    public function getLoadUrl()
    {
        return $this->getUrl('*/*/defaultTemplate');
    }

    /**
     * Get paths of where current template is used as default
     *
     * @param bool $asJSON
     * @return string
     */
    public function getUsedDefaultForPaths($asJSON = true)
    {
        $paths = $this->getEmailTemplate()->getSystemConfigPathsWhereUsedAsDefault();
        $pathsParts = $this->_getSystemConfigPathsParts($paths);
        if($asJSON){
            return Mage::helper('core')->jsonEncode($pathsParts);
        }
        return $pathsParts;
    }

    /**
     * Get paths of where current template is currently used
     *
     * @param bool $asJSON
     * @return string
     */
    public function getUsedCurrentlyForPaths($asJSON = true)
    {
        $paths = $this->getEmailTemplate()->getSystemConfigPathsWhereUsedCurrently();
        $pathsParts = $this->_getSystemConfigPathsParts($paths);
        if($asJSON){
            return Mage::helper('core')->jsonEncode($pathsParts);
        }
        return $pathsParts;
    }

    /**
     * Convert xml config pathes to decorated names
     *
     * @param array $paths
     * @return array
     */
    protected function _getSystemConfigPathsParts($paths)
    {
        $result = $urlParams = $prefixParts = array();
        $scopeLabel = Mage::helper('adminhtml')->__('GLOBAL');
        if ($paths) {
            // create prefix path parts
            $prefixParts[] = array(
                'title' => Mage::getSingleton('admin/config')->getMenuItemLabel('system'),
            );
            $prefixParts[] = array(
                'title' => Mage::getSingleton('admin/config')->getMenuItemLabel('system/config'),
                'url' => $this->getUrl('adminhtml/system_config/'),
            );

            $pathParts = $prefixParts;
            foreach ($paths as $id => $pathData) {
                list($sectionName, $groupName, $fieldName) = explode('/', $pathData['path']);
                $urlParams = array('section' => $sectionName);
                if (isset($pathData['scope']) && isset($pathData['scope_id'])) {
                    switch ($pathData['scope']) {
                        case 'stores':
                            $store = Mage::app()->getStore($pathData['scope_id']);
                            if ($store) {
                                $urlParams['website'] = $store->getWebsite()->getCode();
                                $urlParams['store'] = $store->getCode();
                                $scopeLabel = $store->getWebsite()->getName() . '/' . $store->getName();
                            }
                            break;
                        case 'websites':
                            $website = Mage::app()->getWebsite($pathData['scope_id']);
                            if ($website) {
                                $urlParams['website'] = $website->getCode();
                                $scopeLabel = $website->getName();
                            }
                            break;
                        default:
                            break;
                    }
                }
                $pathParts[] = array(
                    'title' => Mage::getSingleton('adminhtml/config')->getSystemConfigNodeLabel($sectionName),
                    'url' => $this->getUrl('adminhtml/system_config/edit', $urlParams),
                );
                $pathParts[] = array(
                    'title' => Mage::getSingleton('adminhtml/config')->getSystemConfigNodeLabel($sectionName, $groupName)
                );
                $pathParts[] = array(
                    'title' => Mage::getSingleton('adminhtml/config')->getSystemConfigNodeLabel($sectionName, $groupName, $fieldName),
                    'scope' => $scopeLabel
                );
                $result[] = $pathParts;
                $pathParts = $prefixParts;
            }
        }
        return $result;
    }

    /**
     * Return original template code of current template
     *
     * @return string
     */
    public function getOrigTemplateCode()
    {
        return $this->getEmailTemplate()->getOrigTemplateCode();
    }
    
    public function getEmailTemplateId()
    {
        if ($this->getEmailTemplate()->getCampaignId()) {
            return true;
        }
        return false;
    }
}
