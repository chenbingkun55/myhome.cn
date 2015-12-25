<?PHP
function getWeather( $cityname = null ){
    $w_path = "/public/img/weather/";
    $w_array = array();
    $cityname = isset($cityname) ? $cityname : "福州";
    $w_array = S('w_array');
    $change = ( $w_array['0'] == $cityname ) ? 1 : 0;

    if ( ! is_array($w_array) ||  ! $change ) {
        $w_array = array();
        $curl = curl_init();

        $url ='http://www.webxml.com.cn/WebServices/WeatherWebService.asmx/getWeatherbyCityName?theCityName='.$cityname;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
        $weather = curl_exec($curl);
        $array = json_decode(json_encode((array) simplexml_load_string($weather)),1);
        $w_array[] = $array['string']['1'];
        $w_array[] =  "<img src=\"" .$w_path.$array['string']['9'] . "\" title=\"".$array['string']['10']."\" >";
        $w_array[] =  $array['string']['5'];
        $w_array[] =  $array['string']['6'];
        $w_array[] =  $array['string']['11'];
        S('w_array',$w_array,60*60);
    }
    return $w_array;
}
