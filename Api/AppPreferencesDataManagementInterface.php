<?php

namespace Aheadworks\MobileAppConnector\Api;

/**
 * Interface AppPreferencesDataManagementInterface
 *
 * @api
 */
interface AppPreferencesDataManagementInterface
{
    /**
     * Get App Preferences data
     *
     * @param null
     * @return mixed
     * @throw Exception
     */
    public function getAppPreferencesData();
}
