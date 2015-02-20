<?php

/**
 * DisallowPOBox model
 *
 * @category    Aydus
 * @package     Aydus_DisallowPOBox
 * @author      Aydus <davidt@aydus.com>
 */

class Aydus_DisallowPOBox_Model_DisallowPOBox extends Mage_Core_Model_Abstract
{
    const POBOX_PATTERN = '/^box[^a-z]|(p[-. ]?o.?[- ]?|post office )b(.|ox)/i';
}


