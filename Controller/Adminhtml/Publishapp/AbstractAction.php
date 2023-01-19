<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Publishapp;

use Magento\Backend\App\Action;

/**
 * Class for AbstractAction
 */
abstract class AbstractAction extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    public const ADMIN_RESOURCE = 'Aheadworks_MobileAppConnector::publish_app';
}
