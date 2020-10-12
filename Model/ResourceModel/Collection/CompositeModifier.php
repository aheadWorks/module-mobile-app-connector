<?php
namespace Aheadworks\MobileAppConnector\Model\ResourceModel\Collection;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\ConfigurationMismatchException;
use Magento\Framework\UrlInterface;

/**
 * Class CompositeModifier
 *
 * @package Aheadworks\MobileAppConnector\Model\ResourceModel\Collection
 */
class CompositeModifier implements ModifierInterface
{
    /**
     * @var ModifierInterface[]
     */
    private $modifiers;
    /**
     * @var UrlInterface
     */
    private $urlBuilder;
    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @param UrlInterface $urlBuilder
     * @param ResourceConnection $resource
     * @param ModifierInterface[] $modifiers
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ResourceConnection $resource,
        array $modifiers = []
    ) {
        $this->modifiers = $modifiers;
        $this->urlBuilder = $urlBuilder;
        $this->resource = $resource;
    }

    /**
     * {@inheritdoc}
     * @throws ConfigurationMismatchException
     */
    public function modifyData($item)
    {
        foreach ($this->modifiers as $modifier) {
            if (!$modifier instanceof ModifierInterface) {
                throw new ConfigurationMismatchException(
                    __('Collection item modifier must implement %1', ModifierInterface::class)
                );
            }
            $item = $modifier->modifyData($item);
        }
        if (isset($item['order_item_id'])) {
            $item['product_name'] = $this->getProductName($item['order_item_id']);
        }

        if (isset($item['product_id'])) {
            if ($this->getProductImageUrl($item['product_id'])) {
                $item['product_image_url'] =  $this->urlBuilder->getUrl('media/catalog/product', ['_secure' =>true]) . $this->getProductImageUrl($item['product_id']);
            }
        }
        if (isset($item['link_file'])) {
            $item['view_url'] = $this->urlBuilder->getUrl(
                'downloadable/download/link',
                ['id' => $item['link_hash'], '_secure' => true]
            );
        }
        return $item;
    }

    /**
     * @param $orderProductId
     * @return mixed
     */
    public function getProductImageUrl($orderProductId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
                ->from(['val' =>$connection->getTableName('catalog_product_entity_media_gallery_value')])
                ->joinLeft(
                    ['gal'=>$connection->getTableName('catalog_product_entity_media_gallery')],
                    'gal.value_id = val.value_id',
                    ['product_image_url' =>'gal.value']
                )
                ->where('val.entity_id = ?', $orderProductId);

        $row = $connection->fetchRow($select);
        return $row['product_image_url'];
    }

    /**
     * @param $orderItemId
     * @return mixed
     */
    public function getProductName($orderItemId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
                ->from($connection->getTableName('downloadable_link_purchased'))
                ->where('order_item_id = ?', $orderItemId);

        $row = $connection->fetchRow($select);
        return $row['product_name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection()
    {
        return $this->resource->getConnection();
    }
}
