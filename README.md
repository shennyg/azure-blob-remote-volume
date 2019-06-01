# Azure Blob Remote Volume plugin for Craft CMS 3.x

Azure Blob Remote Volume plugin for Craft CMS 3.x

![Microsoft Blob Icon](resources/img/blob-icon.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “Azure Blob Remote Volume”. Then click on the “Install” button in its modal window.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require shennyg/azure-blob-remote-volume

# tell Craft to install the plugin
./craft install/plugin azure-blob-remote-volume
```

## Setup

To create a new asset volume for your Azure Blob container, go to Settings → Assets, create a new volume, and set the Volume Type setting to "Azure". Toggle "Assets in this volume have public URLs" on and enter the base URL. Normally something like https://AZURE_STORAGE_ACCOUNT_NAME.blob.core.windows.net/AZURE_STORAGE_CONTAINER_NAME/ or use the https://AZURE_CDN_NAME.azureedge.net/AZURE_STORAGE_CONTAINER_NAME/ if you have a Azure CDN setup.

You will also need to enter the Azure Storage Account Name, Account Key and Container Name.

## Azure Blob Remote Volume Roadmap

Some things to do, and ideas for potential features:

* Force newer version of Craft CMS to allow for using autosuggestField in the New Volume page allowing backwards compatibility to v0.1.1. 

Brought to you by [SunnyByte, pain-free web and app development](https://sunnybyte.com).
