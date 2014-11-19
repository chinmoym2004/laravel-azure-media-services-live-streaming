<?php

namespace Chew\Laravel\Azure;

use Illuminate\Support\Facades\Config;

// use WindowsAzure\Common\CloudConfigurationManager;
// use WindowsAzure\Common\Configuration;
// use WindowsAzure\Table\TableService;
// use WindowsAzure\Table\TableSettings;
// use WindowsAzure\Blob\BlobService;
// use WindowsAzure\Blob\BlobSettings;
// use WindowsAzure\Queue\QueueService;
// use WindowsAzure\Queue\QueueSettings;

// use WindowsAzure\Common\ServicesBuilder;
// use WindowsAzure\Common\ServiceException;

// require __DIR__ . '/../vendor/autoload.php';

use Guzzle\Http\Client;
use Guzzle\Http\Url;
use Guzzle\Stream;

use Guzzle\Azure\AzureClient;

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

        // dd($this->config);

        // $this->cs = CloudConfigurationManager::getConnectionString("StorageConnectionString");
        // $this->cs = $this->config['connection_string']['storage'];

        // @todo: get these working
        // $this->config is currently the included file for some reason??
        $this->cs =  "DefaultEndpointsProtocol=https;AccountName=".getenv("AZURE_ACCOUNT_NAME").";AccountKey=".getenv("AZURE_PRIMARY_ACCESS_KEY");
        $this->cssm =  "SubscriptionID=".getenv("AZURE_SUBSCRIPTION_ID").";CertificatePath=".getenv("AZURE_PATH_TO_CERTIFICATE");
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
        // dd($this->cs);
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



    /**
     * @return \WindowsAzure\Common\WindowsAzure\ServiceManagement\Internal\IServiceManagement
     */
    public function listBlobs($container)
    {
        // throw new Exception("Not implemented yet.");
        // return $this->servicesBuilder->listContainers($this->cs);

        // Create blob REST proxy.
        $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($this->cs);


        try {
            // List blobs.
            $blob_list = $blobRestProxy->listBlobs($container);
            $blobs = $blob_list->getBlobs();

            foreach($blobs as $blob)
            {
                $return[] = $blob->getName().": ".$blob->getUrl();
            }
        }
        catch(ServiceException $e){
            // Handle exception based on error codes and messages.
            // Error codes and messages are here: 
            // http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code.": ".$error_message."<br />";
        }
    }


    ///////// Media Services Functions
    /**
     * @return \WindowsAzure\Common\WindowsAzure\BLAH\BLAH\IServiceManagement
     */
    public function listContent()
    {

// c1c87568-e292-4506-898a-ef0d6cee3227.pem

        // Connect...
        $client = new \Guzzle\Http\Client();
        // Get results:

        $request = $client->post('https://wamsprodglobal001acs.accesscontrol.windows.net/v2/OAuth2-13'); // https://wamsprodglobal001acs.accesscontrol.windows.net/v2/OAuth2-13
        $request->addHeader('x-ms-version', '2.7');
        $request->addHeader('Content-Type', 'application/x-www-form-urlencoded');
        $request->setBody('grant_type=client_credentials&client_id='.getenv('AZURE_ACCOUNT_NAME').'&client_secret='.urlencode( getenv('AZURE_PRIMARY_MEDIA_SERVICE_ACCESS_KEY') ).'&scope=urn%3aWindowsAzureMediaServices');


        // $request->setResponseBody('string');
        // dd($response);
        $response = $request->send();

        // dd( $response->getHeaders() );
        // dd( $response->getStatusCode() );

        ////// A

        echo $response->getStatusCode() . '<hr />';
        // "200"
        echo $response->getHeader('content-type') . '<hr />';
        // 'application/json; charset=utf8'
        echo $response->getBody() . '<hr />';
        // {"type":"User"...'
        $response_array = $response->json();

        // dd($response_array);

        // $token = $response->getBody();

        // dd( $response->getBody() );

        $token = $response_array['access_token'];

        // echo '<hr />';
        // Outputs the JSON decoded data
        // dd( $response->getBody() );

        echo '<hr />';


        // dd( $token );






        $request = $client->post('https://wamsdubclus001rest-hs.cloudapp.net/api/Channels');

        // Moved here atm...
        $request->addHeader('x-ms-version', '2.7');
        $request->addHeader('Accept', 'application/json;odata=minimalmetadata');
        $request->addHeader('Content-Type', 'application/json;odata=minimalmetadata');
        $request->addHeader('Authorization', 'Bearer '.$token);
        $request->setBody('
{
    "Id": null,
    "Name": "testchannelRTMP",
    "Description": "Test Description",
    "Created": "0001-01-01T00:00:00",
    "LastModified": "0001-01-01T00:00:00",
    "State": null,
    "Input": {
        "KeyFrameInterval": null,
        "StreamingProtocol": "RTMP",
        "AccessControl": {
            "IP": {
                "Allow": [{
                    "Name": "testName1",
                    "Address": "1.1.1.1",
                    "SubnetPrefixLength": 24
                }]
            }
        },
        "Endpoints": []
    },
    "Preview": {
        "AccessControl": {
            "IP": {
                "Allow": [{
                    "Name": "testName1",
                    "Address": "1.1.1.1",
                    "SubnetPrefixLength": 24
                }]
            }
        },
        "Endpoints": []
    },
    "Output": {
        "Hls": {
            "FragmentsPerSegment": 1
        }
    },
    "CrossSiteAccessPolicies": {
        "ClientAccessPolicy": null,
        "CrossDomainPolicy": null
    }
}
            ');

        try {
            $response = $request->send();
        } catch (Exception $e) {
           dd($e); 
        }

        unset($request);

        echo $response->getStatusCode() . '<hr />';
        // "200"
        echo $response->getHeader('content-type') . '<hr />';
        // 'application/json; charset=utf8'
        echo $response->getBody() . '<hr />';


        dd('don');


        // Atempt to use AzureClient from guzzle-azure

        // $client = new \Guzzle\Azure\AzureClient( 'https://media.windows.net/API/', getenv("AZURE_SUBSCRIPTION_ID"), getenv("AZURE_PATH_TO_CERTIFICATE") );

        // $request = $client->get('https://media.windows.net/api/Channels');

        // // Moved here atm...
        // $request->addHeader('x-ms-version', '2.7');
        // $request->setBody('{"Id":null,"Name":"testchannel001","Description":"Test Description","Created":"0001-01-01T00:00:00","LastModified":"0001-01-01T00:00:00","State":null,"Input":{"KeyFrameInterval":null,"StreamingProtocol":"FragmentedMP4","AccessControl":{"IP":{"Allow":[{"Name":"testName1","Address":"1.1.1.1","SubnetPrefixLength":24}]}},"Endpoints":[]},"Preview":{"AccessControl":{"IP":{"Allow":[{"Name":"testName1","Address":"1.1.1.1","SubnetPrefixLength":24}]}},"Endpoints":[]},"Output":{"Hls":{"FragmentsPerSegment":1}},"CrossSiteAccessPolicies":{"ClientAccessPolicy":null,"CrossDomainPolicy":null}}');

        // $response = $request->send();

        // dd( $response->getStatusCode() );

        // dd( $response->getBody() );

        // dd($request);




        // Generic client...
        // $client = new \Guzzle\Http\Client();
        // // Get results:

        // $request = $client->get('http://stream-fingerprint.chew.tv:8080');

        // // $request->setResponseBody('string');
        // // dd($response);
        // $response = $request->send();

        // // dd( $response->getStatusCode() );
        // dd( $response->getBody() );

        // throw new Exception("Not implemented yet.");
        // return $this->servicesBuilder->listContainers($this->cs);



        // Create blob REST proxy.
        // $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($this->cs);


        // try {
        //     // List blobs.
        //     $blob_list = $blobRestProxy->listBlobs($container);
        //     $blobs = $blob_list->getBlobs();

        //     foreach($blobs as $blob)
        //     {
        //         $return[] = $blob->getName().": ".$blob->getUrl();
        //     }
        // }
        // catch(ServiceException $e){
        //     // Handle exception based on error codes and messages.
        //     // Error codes and messages are here: 
        //     // http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
        //     $code = $e->getCode();
        //     $error_message = $e->getMessage();
        //     echo $code.": ".$error_message."<br />";
        // }
    }

    /**
     * @return \WindowsAzure\Common\WindowsAzure\\BLAH\BLAH\'Internal\IServiceBus
     */
    public function createChannel($channelName)
    {
        throw new Exception("Not implemented yet.");
//        return $this->servicesBuilder->createServiceBusService($this->config["connection_string"]["service_bus"]);
    }



}