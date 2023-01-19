<?php
namespace Aheadworks\MobileAppConnector\Block\Adminhtml\Preferences\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class for Save
 */
class Save implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save'
            ],
            'sort_order' => 50
        ];
    }
}
