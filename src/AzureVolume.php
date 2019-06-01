<?php
/**
 * @copyright SunnyByte
 */

namespace shennyg\azureblobremotevolume;

use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use craft\base\FlysystemVolume;
use Craft;

/**
 * Class AzureVolume
 *
 * @package shennyg\craftazureblobvolume
 */
class AzureVolume extends FlysystemVolume
{
    // Properties
    // =========================================================================

    /**
     * @var string the type of storage, currently we are only implementing blob
     *
     * See https://docs.microsoft.com/en-us/azure/storage/common/storage-decide-blobs-files-disks
     */
    public $azureStorageType = 'blob';

    /**
     * @var string Azure Storage Account Name
     */
    public $accountName = '';

    /**
     * @var string Azure Storage Account Key
     */
    public $accountKey = '';

    /**
     * @var string Azure Storage Container Name
     */
    public $containerName = '';

    /**
     * @var string Subfolder to use
     */
    public $subfolder = '';
    
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
            $this->accountName,
            $this->accountKey
        );
        $client = BlobRestProxy::createBlobService($endpoint);

        $containerName = $this->containerName;
        return new AzureBlobStorageAdapter($client, $containerName, $this->_subfolder());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [[
            'accountName',
            'accountKey',
            'containerName'
        ], 'required'];

        return $rules;
    }

    // Public Methods
    // =========================================================================

    public function getRootUrl()
    {
        if (($rootUrl = parent::getRootUrl()) !== false) {
            $rootUrl .= $this->_subfolder();
        }
        return $rootUrl;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('azure-blob-remote-volume/volumeSettings', [
            'volume' => $this,
        ]);
    }

    // Private Methods
    // =========================================================================

    /**
     * Returns the parsed subfolder path
     *
     * @return string|null
     */
    private function _subfolder(): string
    {
        if ($this->subfolder && ($subfolder = rtrim($this->subfolder, '/')) !== '') {
            return $subfolder . '/';
        }
        return '';
    }
}
