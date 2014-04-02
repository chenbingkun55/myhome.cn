<?PHP
function getWeather(){
    $w_path = "/public/img/weather/";
    $w_array = array();

    if ( ! S('w_array')) {
        $curl = curl_init();

        $fuzhou_url ='http://www.webxml.com.cn/WebServices/WeatherWebService.asmx/getWeatherbyCityName?theCityName=%E7%A6%8F%E5%B7%9E';
        curl_setopt($curl, CURLOPT_URL, $fuzhou_url);
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
        $fuzhou_weather = curl_exec($curl);
        $fuzhou_array = json_decode(json_encode((array) simplexml_load_string($fuzhou_weather)),1);
        $w_array[] = $fuzhou_array['string']['1'];
        $w_array[] =  "<img src=\"" .$w_path.$fuzhou_array['string']['9'] . "\" >";
        $w_array[] =  $fuzhou_array['string']['5'];
        $w_array[] =  $fuzhou_array['string']['6'];
        $w_array[] =  $fuzhou_array['string']['10'];
        $w_array[] =  $fuzhou_array['string']['11'];
        S('w_array',$w_array,60*60*2);
    } else {
        $w_array = S('w_array');
    }
    return $w_array;
}
