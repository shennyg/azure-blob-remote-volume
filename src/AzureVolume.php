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

    /**
     * @var string Azure Storage Blob Endpoint Host Name
     */
    public $blobEndpointHostName = '';

    /**
     * @var bool Azure Storage Blob Endpoint HTTPS Enabled
     */
    public $httpsEnabled = true;

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
        $scheme = $this->httpsEnabled ? 'https' : 'http';

        $endpoint = sprintf(
            'DefaultEndpointsProtocol=%s;AccountName=%s;AccountKey=%s',
            $scheme,
            Craft::parseEnv($this->accountName),
            Craft::parseEnv($this->accountKey)
        );

        if (isset($this->blobEndpointHostName))
        {
            // Chopping off the http or https part at the beginning of the hostname in case the user added it in.
            $finalBlobEndpointHostName = preg_replace('/^https?\:\/\//', '', Craft::parseEnv($this->blobEndpointHostName));

            if (trim($finalBlobEndpointHostName) !== '')
            {
                $blobEndpointSuffix = sprintf(
                    ';BlobEndpoint=%s://%s',
                    $scheme,
                    $finalBlobEndpointHostName
                );
                $endpoint .= $blobEndpointSuffix;
            }
        }

        $client = BlobRestProxy::createBlobService($endpoint);

        $containerName = Craft::parseEnv($this->containerName);
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
        if (
            Craft::parseEnv($this->subfolder) &&
            ($subfolder = rtrim(Craft::parseEnv($this->subfolder), '/')) !== ''
        ) {
            return $subfolder . '/';
        }
        return '';
    }
}
