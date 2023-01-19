<?php

namespace Aheadworks\MobileAppConnector\Api;

/**
 * Interface HomepageInterface
 */
interface HomepageRepositoryInterface
{
    /**
     * Save Homepage
     *
     * @param \Aheadworks\MobileAppConnector\Api\Data\HomepageInterface $homepage
     * @return \Aheadworks\MobileAppConnector\Api\Data\HomepageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save($homepage);
}
