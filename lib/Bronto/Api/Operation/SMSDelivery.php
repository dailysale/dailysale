<?php
/**
 * This file was generated by the ConvertToLegacy class in bronto-legacy.
 * The purpose of the conversion was to maintain PSR-0 compliance while
 * the main development focuses on modern styles found in PSR-4.
 *
 * For the original:
 * @see src/Bronto/Api/Operation/SMSDelivery.php
 */


/**
 * Bronto_Api_Operation_SMSDelivery specific Bronto_Api_Operation
 *
 * @author Philip Cali <philip.cali@bronto.com>
 */
class Bronto_Api_Operation_SMSDelivery extends Bronto_Api_Operation
{
    /**
     * @see parent
     */
    public function __construct(Bronto_Api $api)
    {
        parent::__construct($api, 'SMSDelivery');
    }

    /**
     * @see parent
     * @return string
     */
    protected function _resolvedWriteKey($method)
    {
        return 'deliveries';
    }

    /**
     * @see parent
     * @return Bronto_Api_Read
     */
    public function createRead(array $readData = array(), array $requestFields = array())
    {
        return parent::createRead($readData, $requestFields)
            ->setRequestFields(array(
                'includeContent' => true,
                'includeRecipients' => true
            ));
    }
}
