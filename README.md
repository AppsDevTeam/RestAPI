rest-api
========
Basic configuration in <b>config.neon:</b>
<pre>
class Application implements Adt\RestAPI\IApplicationService {
  
  function getApplicationSecret($appId) {
    // your code
  }
  
}
</pre>
<pre>
services:
  # only server side configuration
  - Application
  - ADT\Rest\ApiSignature
  
  # only client side configuration
  - ADT\Rest\Service\Api
  - ADT\Rest\Signature(appId, appSecret)
</pre>
