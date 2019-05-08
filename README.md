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

To create a new asset volume for your Amazon S3 bucket, go to Settings → Assets, create a new volume, and set the Volume Type setting to "Azure".

The following settings can be need to be environment variables. See [Environmental Configuration](https://docs.craftcms.com/v3/config/environments.html) in the Craft docs to learn more about that.

```
AZURE_STORAGE_ACCOUNT_NAME="account-name"
AZURE_STORAGE_ACCOUNT_KEY="account-key"
AZURE_STORAGE_CONTAINER_NAME="container-name"
```

## Azure Blob Remote Volume Roadmap

Some things to do, and ideas for potential features:

* Release it
* Allow saving the configs in the database and managing in the Craft CMS Control Panel. 

Brought to you by [SunnyByte, pain-free web and app development](https://sunnybyte.com).
