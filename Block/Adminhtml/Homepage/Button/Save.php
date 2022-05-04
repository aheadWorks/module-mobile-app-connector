<?php
namespace Aheadworks\MobileAppConnector\Block\Adminhtml\Homepage\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Save
 * @package Aheadworks\MobileAppConnector\Block\Adminhtml\Homepage\Button
 */
class Save extends AbstractButton implements ButtonProviderInterface
{
    /**
     * {@inheritdoc}
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
            'sort_order' => 10
        ];
    }
}