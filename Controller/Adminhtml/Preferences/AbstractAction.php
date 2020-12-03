<?php

namespace Aheadworks\MobileAppConnector\Controller\Adminhtml\Preferences;

use Magento\Backend\App\Action;

/**
 * Class AbstractAction
 */
abstract class AbstractAction extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Aheadworks_MobileAppConnector::app_preferences';
}
