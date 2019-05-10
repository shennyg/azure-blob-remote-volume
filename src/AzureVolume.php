<?php
/**
 * @copyright SunnyByte
 */

namespace shennyg\azureblobremotevolume;

use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use craft\base\FlysystemVolume;

/**
 * Class AzureVolume
 *
 * @package shennyg\craftazureblobvolume
 */
class AzureVolume extends FlysystemVolume
{
    // Static
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return 'Microsoft Azure Storage';
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createAdapter()
    {
        $endpoint = sprintf(
            'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s',
            getenv('AZURE_STORAGE_ACCOUNT_NAME'),
            getenv('AZURE_STORAGE_ACCOUNT_KEY')
        );
        $client = BlobRestProxy::createBlobService($endpoint);

        $containerName = getenv('AZURE_STORAGE_CONTAINER_NAME');
        return new AzureBlobStorageAdapter($client, $containerName);
    }
}
