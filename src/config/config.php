<?php

return array(

    # If you are using development storage, then set this to true:
    # http://blogs.msdn.com/b/windowsazurestorage/archive/2012/10/30/windows-azure-storage-emulator-1-8.aspx
    "dev_storage" => "UseDevelopmentStorage=false",

    "connection_string" => array(
        # For accessing a live storage service (tables, blobs, queues):
        "storage" => "DefaultEndpointsProtocol=[http|https];AccountName=[yourAccount];AccountKey=[yourKey]",

        #For accessing the Service Bus:
        "service_bus" => "Endpoint=[yourEndpoint];SharedSecretIssuer=[yourWrapAuthenticationName];SharedSecretValue=[yourWrapPassword]",

        # For accessing Service Management APIs:
        "service_management" => "SubscriptionID=[yourSubscriptionId];CertificatePath=[filePathToYourCertificate]"
    )
);
