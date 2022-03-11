<?php

declare(ticks=1);

namespace Danito\Soft\Laravel\Api;

use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Framework\HTTP\Client\Curl;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Request\Http;

class Helper
{
   /**
     * @var CurlFactory
     */
    private $curlFactory;

    /**
     * @var LoggerInterface
     */
    private $log;

    public function __construct(
        CurlFactory $curlFactory,
        LoggerInterface $log
    ) {
        $this->curlFactory = $curlFactory;
        $this->log = $log;
    }

    /**
     * create flight
     * @param Http $request
     * @return mixed
     */
    public function createFlight(Http $request)
    {
        $response = null;
        try {
            $params = $request->getParams();
            unset($params['form_key']);
            if (!empty($request->getFiles('destination_image')) && !empty($request->getFiles('destination_image')['name'])) {
                $params['files']['destination_image']['name'] = $request->getFiles('destination_image')['name'];
                $params['files']['destination_image']['content'] = base64_encode(file_get_contents($request->getFiles('destination_image')['tmp_name']));
            }

            if (!empty($request->getFiles('destination_data')) && !empty($request->getFiles('destination_data')['name'])) {
                $params['files']['destination_data']['name'] = $request->getFiles('destination_data')['name'];
                $params['files']['destination_data']['content'] = base64_encode(file_get_contents($request->getFiles('destination_data')['tmp_name']));
            }

            $client = $this->getClient();
            if (!empty($params['id'])) {
                $client->post("http://laravellocal.com/api/flights/" . $params['id'], json_encode($params));
            } else {
                $client->post("http://laravellocal.com/api/flights", json_encode($params));
            }

            if ($client->getStatus()) {
                $response = json_decode($client->getBody(), true);
            }
        } catch (\Exception $e) {
            $this->log->error($e->getMessage());
            //die($e->getMessage());
        }
        return $response;
    }

    /**
     * get flights
     * @return array
     */
    public function getFlights(): array
    {
        $flights = [];
        try {
            $curl = $this->getClient();
            $curl->get("http://laravellocal.com/api/flights");
            $response = json_decode($curl->getBody());
            if (!empty($response)) {
                $flights = $response;
            }
        } catch (\Exception $e) {
            $this->log->error($e->getMessage());
            //die($e->getMessage());
        }
        return $flights;
    }

    /**
     * get client
     * @return Curl
     */
    private function getClient()
    {
        $curl = $this->curlFactory->create();
        $curl->addHeader("content-type", "application/json");
        $curl->addHeader("authorization", "Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6InFEQURDb2Y1TnNkWUt3MDFPY3MwWSJ9.eyJpc3MiOiJodHRwczovL2Rldi0tMDc0ZWQ3ci51cy5hdXRoMC5jb20vIiwic3ViIjoiNDlaUG5yMTZFUEdqQ0tGV0o5eG9GMEV1WFBjRmdRNk5AY2xpZW50cyIsImF1ZCI6Imh0dHA6Ly9sYXJhdmVsbG9jYWwuY29tL2FwaS9mbGlnaHRzIiwiaWF0IjoxNjQ2ODI4OTMwLCJleHAiOjE2NDY5MTUzMzAsImF6cCI6IjQ5WlBucjE2RVBHakNLRldKOXhvRjBFdVhQY0ZnUTZOIiwiZ3R5IjoiY2xpZW50LWNyZWRlbnRpYWxzIn0.A_GBPHfoSzjieXHrrz-dv8b80wmbOjy11lldKhhb2f2xZmw6kUZkPG6MyAJFP9X3GrYOqqqSAH_bnX-iRSXaMvlYXTI6DnM0QPJDJY1YpAbqioI-eMH-mDchTAAkKvl1ASbOiD56tPjYCcssqqngFTxc9bNFlLgK8SiagQ1EAWNjMmoJ1WSmM5AklQ4yPo85VwzKD-_30G8aQbyJPHrDJgarbk95hsy_R8Z13Tg28n0bnUynwOeEiyL9H6OS_XZMNHtEJx-9MHg6u8EbZLQiibr4XP2717ZxOQLmzkxfi6LQN5mefEFaCS2sa-b6DdMqv4aeX4IU8VvO2bAQyOZr2g");
        return $curl;
    }

    /**
     * get flight from rest api
     * @param int $id
     * @return arrray
     */
    public function getFlight(int $id): array
    {
        $flight = [];
        try {
            $curl = $this->getClient();
            $curl->get("http://laravellocal.com/api/flights/" . $id);
            $response = json_decode($curl->getBody(), true);
            if (!empty($response)) {
                $flight = $response;
            }
        } catch (\Exception $e) {
            $this->log->error($e->getMessage());
            //die($e->getMessage());
        }
        return $flight;
    }
}