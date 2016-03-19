<?php namespace HotelsProviders\Expedia;

trait RequestTrait
{
    public function post($url, $params)
    {
        $url = $url.$this->baseUrl;
        $header[] = "Accept: application/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }

    public function get($url)
    {
        // if more than one url ,use multi curl.
        if (is_array($url) return $this->curlMultiRequest($url, [], true);

        $url = $url.$this->baseUrl;
        $headers = [ 
            "Accept-Encoding: gzip",
            "Accept: application/json"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'get');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function clientIp()
    {
        if (empty($_SERVER['HTTP_X_FORWARDED_FOR']))  return  \Request::getClientIp();

        $clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $ipArrays = explode(',', $clientIp);

        return $ipArrays[0];
    }

    public function curlMultiRequest($data, $options = [], $parseJson = false)
    {
        $curly = $result = [];
        // multi handle
        $mh = curl_multi_init();

        foreach ($data as $id => $d) {
            $curly[$id] = curl_init();
            $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
            curl_setopt($curly[$id], CURLOPT_URL, $url);
            curl_setopt($curly[$id], CURLOPT_HEADER, 0);
            curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);

            // post?
            if (is_array($d)) {
                if ( ! empty($d['post'])) {
                    curl_setopt($curly[$id], CURLOPT_POST, 1);
                    curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
                }
            }

            curl_multi_add_handle($mh, $curly[$id]);
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while($running > 0);

        foreach($curly as $id => $c) {
            $result[$id] = curl_multi_getcontent($c);
            if ($parseJson) $result[$id] = json_decode($result[$id]);
            curl_multi_remove_handle($mh, $c);
        }
        curl_multi_close($mh);

        return $result;
    }
}
