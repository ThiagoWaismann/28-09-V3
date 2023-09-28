<?php
$piwsuserLogin = 'PIWSUSER';
$piwsuserPassword = 'run.away';
$activedirectoryLogin = 'sys-iceberg';
$activedirectoryPassword = 'xZoIdcIfuRs=';

$soapHeaders = [
    new SoapHeader('processintegration', 'user', ['login' => $piwsuserLogin, 'password' => $piwsuserPassword, 'encrypt' => 'false']),
    new SoapHeader('activedirectory', 'user', ['login' => $activedirectoryLogin, 'password' => $activedirectoryPassword, 'encrypt' => 'true'])
];

$serviceUrl = 'http://brjgs904.weg.net:8000/sap/bc/srt/wsdl/srvc_GetOrderComponents/Weg.Soa.ServiceClient.GetOrderComponents.ITF_O_S_GET_ORDER_COMPONENTS';

$options = [
    'trace' => true,  
    'exceptions' => true, 
    'cache_wsdl' => WSDL_CACHE_NONE, 
    'stream_context' => stream_context_create([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ]
    ]) 
];

try {
    $client = new SoapClient($serviceUrl, $options);
    $client->__setSoapHeaders($soapHeaders);

    $result = $client->GetOrderComponents(/* parâmetros do serviço  */);
    print_r($result);
} catch (SoapFault $e) {
    echo "Erro na chamada SOAP: " . $e->getMessage();
}
?>
