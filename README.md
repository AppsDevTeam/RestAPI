rest-api
========
Basic configuration in <b>config.neon:</b>

<pre>
services:
  # only server side configuration
  - ADT\Rest\Service\Application
  - ADT\Rest\ApiSignature
  
  # only client side configuration
  - ADT\Rest\Service\Api
  - ADT\Rest\Signature(appId, appSecret)
</pre>
