<?php
namespace Puja\Alice\Model\Bob\Handler;
abstract class HandlerAbstract
{
    protected $config;
    public function __construct(\Puja\Configure\Result\Result $config)
    {
        $this->config = $config;
    }

    public function get($data)
    {

    }

    public function set($data)
    {

    }

    protected function prepareData($body)
    {
        $request = [
            'head' => $this->getHeader(),
            'body' => $body
        ];

        $data = [
            'request' => $request,
            'signature' => $this->sign($request),
        ];

        return $data;
    }

    private function getHeader()
    {
        return [
            'version' => $this->container->getConfig()->getVersion(),
            'clientId' => $this->container->getConfig()->getClientId(),
            'reqTime' => $this->container->getHelper()->formatDateWithTimezone(time()),
            'reqMsgId' => uniqid('LZD-APP-', true),
            'function' => $this->getFunction(),
            'reserve' => '',
        ];
    }

    private function sign($request)
    {
        return $this->container->getEncryption()->encrypt($request);
    }

    private function call($url, array $query, $httpMethod)
    {
        $this->lastHttpMethod = $httpMethod;
        $this->lastPostData = $query;

        $isPost = (strtoupper($httpMethod) == 'POST');
        $url    = trim($url, '/');

        $query  = $this->addReserveParam($query, $url);
        $dataStr = null;

        if ($isPost) {
            $params  = array('t' => microtime(true));
            $dataStr = json_encode($query);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->container->getLogger()->emerg(var_export($query, true), ['bin' => $this->logPath, 'component_name' => 'alipay']);
                throw new \Exception('Json encode error: ' . json_last_error_msg());
            }
        } else {
            $params['t'] = microtime(true);
        }

        $this->container->getLogger()->info($dataStr, ['bin' => 'alipay_debug_log', 'component_name' => 'alipay']);

        $queryStr = http_build_query($params, '', '&', PHP_QUERY_RFC3986);

        $headers = [
            'Content-Type: text/plain',
            'X-LZD-Instance: ' . $this->container->getHelper()->getHostname(),
        ];

        $headers = array_merge($headers, TraceHeaders::getHeaders());

        $url = $url . '?' . $queryStr;
        $con = curl_init($url);

        curl_setopt($con, CURLOPT_HEADER, true);
        if ($isPost) {
            curl_setopt($con, CURLOPT_POSTFIELDS, $dataStr);
            $headers[] = 'Content-Length: ' . strlen($dataStr);
        }

        curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($con, CURLOPT_CONNECTTIMEOUT, $this->container->getConfig()->getConnectTimeout());
        curl_setopt($con, CURLOPT_TIMEOUT, $this->container->getConfig()->getRequestTimeout());
        curl_setopt($con, CURLOPT_CUSTOMREQUEST, $httpMethod);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($con, CURLINFO_HEADER_OUT, false);

        $result = curl_exec($con);
        $this->lastHTTPCode = curl_getinfo($con, CURLINFO_HTTP_CODE);

        if ($this->lastHTTPCode != 200) {
            throw new NotOkException($this->lastHTTPCode);
        }

        if ($result === false) {
            $message = sprintf('Call to ALIPAY API failed. Requested URL: %s, Error %s, Code %s', $url, curl_error($con), curl_errno($con));
            $this->logRequest($message, $con, $dataStr);
            if (curl_errno($con) == CURLE_OPERATION_TIMEOUTED) {
                throw new TimeoutException($message);
            }
            throw new \Exception($message);
        }

        $headerSize = curl_getinfo($con, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $headerSize);
        $result = substr($result, $headerSize);
        $json = json_decode(trim($result), true);

        $this->container->getLogger()->info($result, ['bin' => 'alipay_debug_log', 'component_name' => 'alipay']);

        if (is_null($json)) {
            $message = sprintf('Request Error (Result is not Json): url %s, response headers %s, result %s', $url, $header, $result);
            $this->logRequest($message, $con, $dataStr);
            throw new \Exception($message);
        }

        $formatIpayJson = $this->container->getHelper()->extractSignedIPayResponseContent($result);
        if (!$this->container->getEncryption()->verifySignature($json['signature'], $formatIpayJson)) {
            $message = sprintf('Signature invalid: url %s, response headers %s, result %s', $url, $header, $result);
            $this->logRequest($message, $con, $dataStr);

            throw new \Exception($message);
        }

        curl_close($con);
        return $json['response'];
    }
}