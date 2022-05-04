<?php
namespace Aheadworks\MobileAppConnector\Api;


interface HomepageRepositoryInterface
{
    /**
     * @param \Aheadworks\MobileAppConnector\Api\Data\HomepageInterface $homepage
     * @return \Aheadworks\MobileAppConnector\Api\Data\HomepageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save($homepage);
}