<?php

namespace Unm\Laravel\Azure;

use Illuminate\Support\Facades\Config;

use WindowsAzure\Common\CloudConfigurationManager;
use WindowsAzure\Common\Configuration;
use WindowsAzure\Table\TableService;
use WindowsAzure\Table\TableSettings;
use WindowsAzure\Blob\BlobService;
use WindowsAzure\Blob\BlobSettings;
use WindowsAzure\Queue\QueueService;
use WindowsAzure\Queue\QueueSettings;

use WindowsAzure\Common\ServicesBuilder;

class Azure {

    /**
     * @var WindowsAzure\Common\ServicesBuilder
     */
    private $servicesBuilder;

    /**
     * @var
     */
    private $config;

    /**
     * @param ServicesBuilder $servicesBuilder
     * @param $config
     */
    public function __construct(ServicesBuilder $sb, $config) {
        $this->servicesBuilder = $sb;
        $this->config          = $config;

        # Yes, the Azure SDK wants and environment variable. There is another way, but
        # I am just too lazy to figure it out at the moment.
        putenv("StorageConnectionString={$this->config["connection_string"]["storage"]}");

        $this->cs = CloudConfigurationManager::getConnectionString("StorageConnectionString");
    }

    /**
     * @return \WindowsAzure\Common\WindowsAzure\Table\Internal\ITable
     */
    public function createTableService()
    {
        throw new Exception("Not implemented yet.");
//        return $this->servicesBuilder->createTableService($this->cs);
    }

    /**
     * @return \WindowsAzure\Common\WindowsAzure\Queue\Internal\IQueue
     */
    public function createQueueService()
    {
        throw new Exception("Not implemented yet.");
//        return $this->servicesBuilder->createQueueService($this->cs);
    }

    /**
     * @return \WindowsAzure\Common\WindowsAzure\Blob\Internal\IBlob
     */
    public function createBlobService()
    {
        return $this->servicesBuilder->createBlobService($this->cs);
    }

    /**
     * @return \WindowsAzure\Common\WindowsAzure\ServiceBus\Internal\IServiceBus
     */
    public function createServiceBusService()
    {
        throw new Exception("Not implemented yet.");
//        return $this->servicesBuilder->createServiceBusService($this->config["connection_string"]["service_bus"]);
    }

    /**
     * @return \WindowsAzure\Common\WindowsAzure\ServiceManagement\Internal\IServiceManagement
     */
    public function createServiceManagementService()
    {
        throw new Exception("Not implemented yet.");
//        return $this->servicesBuilder->createServiceManagementService($this->config["connection_string"]["service_management"]);
    }

}