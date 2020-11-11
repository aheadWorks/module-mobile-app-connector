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
     * GET App Preferences data
     * @param null
     * @return null|array
     * @throw Exception
     */
    public function getAppPreferencesData();

}

