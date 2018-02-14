<?php

class Omnify_Widget_Api
{
    /**
     * Api url
     *
     * @since    2.0.0
     * @access   protected
     * @var      string $api_url .
     */
    protected $url;
    protected $token;
    protected $business;

    /**
     * Initialize the class and set its properties.
     *
     * @since    2.0.0
     * @param $api_url
     */
    public function __construct($api_url)
    {
        $this->url = $api_url;
        $this->token = get_option('token');
        $this->business = get_option('business');
    }

    public function get_api()
    {
        return $this->url;
    }

    public function get_business()
    {
        return $this->business;
    }

    public function get_token()
    {
        return $this->token;
    }

    public function delete_widget($widget_id)
    {
        $endpoint = $this->get_api() . "/extv1/businesses/" . $this->get_business() . "/widgets/" . $widget_id . "/?apikey=" . $this->get_token();
        return $this->request($endpoint, 'DELETE');
    }

    public function create_widget($data, $page = 'home', $width, $name, $type = 'iframe', $team, $services)
    {
        $data = stripslashes($data);
        $data = json_decode($data, true);

        $request = [];
        $request['params'] = [];
        $request['params']['page'] = $page;
        $request['params']['blocks'] = [];
        foreach ($data as $block => $value) {
            $request['params']['blocks'][$block] = $value == 1 ? true : false;
        }
        $request['params']['services'] = [];
        foreach ($services as $service) {
            $request['params']['services'][$service] = $service;
        }
        $request['params']['trainers'] = [];
        foreach ($team as $member) {
            $request['params']['trainers'][$member] = $member;
        }
        $request['params']['prefilter'] = $data['showfilteres'] == 1 ? false : true;
        $request['name'] = $name;
        $request['type'] = $type;
        $request['style'] = $width;

        $endpoint = $this->get_api() . "/extv1/businesses/" . $this->get_business() . "/widgets/?apikey=" . $this->get_token();

        return $this->request($endpoint, 'POST', json_encode($request));
    }

    public function update_widget($data, $widget_id, $page = 'home', $width, $name, $type = 'iframe', $team, $services)
    {
        $data = stripslashes($data);
        $data = json_decode($data, true);

        $request = [];
        $request['params'] = [];
        $request['params']['page'] = $page;
        $request['params']['blocks'] = [];
        foreach ($data as $block => $value) {
            $request['params']['blocks'][$block] = $value == 1 ? true : false;
        }
        $request['params']['services'] = [];
        foreach ($services as $service) {
            $request['params']['services'][$service] = $service;
        }
        $request['params']['trainers'] = [];
        foreach ($team as $member) {
            $request['params']['trainers'][$member] = $member;
        }
        $request['params']['prefilter'] = $data['showfilteres'] == 1 ? false : true;
        $request['name'] = $name;
        $request['type'] = $type;
        $request['style'] = $width;
        $endpoint = $this->get_api() . "/extv1/businesses/" . $this->get_business() . "/widgets/" . $widget_id . "/?apikey=" . $this->get_token();

        return $this->request($endpoint, 'PUT', json_encode($request));
    }

    public function get_widget($widget_id, $array = false)
    {
        $endpoint = $this->get_api() . "/extv1/businesses/" . $this->get_business() . "/widgets/" . $widget_id . "?apikey=" . $this->get_token();
        $request = $this->request($endpoint, 'GET');
        if ($array) {
            return json_decode($request, true);
        }
        return $request;
    }

    public function get_staff($array = false)
    {
        $endpoint = $this->get_api() . "/extv1/businesses/" . $this->get_business() . "/staff/?apikey=" . $this->get_token();
        $request = $this->request($endpoint, 'GET');
        if ($array) {
            return json_decode($request, true);
        }
        return $request;
    }


    public function request($url, $method = 'GET', $request = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if ($request) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        }
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
