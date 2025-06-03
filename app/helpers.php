if (!function_exists('parse_json_api_response')) {
    /**
     * Parse json data with status code.
     *
     * @param json $data
     * @param json $data
     *
     * @return string
     */
    function parse_json_api_response($data, $statusCode, $message = '')
    {
        if (!$data || empty($data)) {
            $msg = 'Data not Found !';
            if ($message != '')
                $msg = $message;
            $response = [
                'message' => $msg,
                'success' => false,
                'data' => null,
                'status' => $statusCode
            ];
        } else {
            $msg = 'Data Found !';
            if ($message != '')
                $msg = $message;
            $response = [
                'message' => $msg,
                'success' => true,
                'data' => $data,
                'status' => $statusCode
            ];
        }

        return $response;
    }
}