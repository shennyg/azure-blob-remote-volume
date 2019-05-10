<?php
/**
 * Azure Blob Remote Volume plugin for Craft CMS 3.x
 *
 * @link      https://sunnybyte.com
 * @copyright Copyright (c) 2019 SunnyByte
 */

namespace shennyg\azureblobremotevolume;


use Craft;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Plugins;
use craft\events\PluginEvent;

use craft\services\Volumes;
use yii\base\Event;

/**
 * Class AzureBlobRemoteVolume
 *
 * @author    Shen DeShayne
 * @package   AzureBlobRemoteVolume
 * @since     0.1.0
 *
 */
class AzureBlobRemoteVolume extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var AzureBlobRemoteVolume
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '0.1.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::info(
            Craft::t(
                'azure-blob-remote-volume',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );

        Event::on(
            Volumes::class,
            Volumes::EVENT_REGISTER_VOLUME_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = AzureVolume::class;
            }
        );
    }
}
