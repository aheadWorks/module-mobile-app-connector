<?php

namespace Aheadworks\MobileAppConnector\Api;

/**
 * Interface AppPreferencesDataManagementInterface
 * @package Aheadworks\MobileAppConnector\Api
 * @api
 */
interface AppPreferencesDataManagementInterface
{

    /**
     * Get App Preferences data
     * @param null
     * @return array
     * @throw Exception
     */
    public function getAppPreferencesData();

}

