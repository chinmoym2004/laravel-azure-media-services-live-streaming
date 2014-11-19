laravel-azure-media-services-live-streaming
===========================================

A Laravel 4.1 service provider package that uses guzzle to access the Preview Live Streaming APIs that currently aren't in the native sdk.

## Installation

To install with Composer add the following to your require section.

	"chewcode/laravel-azure-media-services-live-streaming": "*",

In the app.php config file you need to add the following to the providers array:

	'Chew\Laravel\Azure\AzureServiceProvider',

and the following to the aliases:

	'AzureLive' => 'Chew\Laravel\Azure\AzureFacade',

## Usage

Functions have yet to be written but will go here...

