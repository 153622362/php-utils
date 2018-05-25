<?php
namespace md\modules\ota\utils;

class XmlUtils
{


    /**
     * 把xml组件成soap格式
     * @param $xml
     * @return string
     */
    public static function xmlToSoap($xml)
    {
        $str = "<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">
  <soap:Body>";
        $str .=$xml;
        $str .= "</soap:Body>
</soap:Envelope>";
        return $str;
    }

    /**
     * 多节点自动生成xml格式
     * @param $arr           数组(key是xml的标签，value是xml标签内(根据@attributes来判断)或者外的值)
     * @param string $node   重复节点名
     * @return string        返回xml格式
     */
    public static function nodeFormat($arr,$node='')
    {
        $str = '';
        foreach ( $arr as $k => $v ){
            $str .= $node?"<{$node}>":'';
            $str .= ($v["@attributes"] ||  is_numeric($k) )?'':"<{$k}>";
            if( $v["@attributes"] ){
                $str .= "<{$k} ";
                foreach ( $v["@attributes"] as $kk => $vv ){
                    $str .= "{$kk}=\"{$vv}\" ";
                }
                $str .= "/>";
            }else{
                if( is_array($v) ){
                    $str .= self::nodeFormat($v,'');
                }
            }
            $str .= ($v["@attributes"] ||  is_numeric($k) )?'':"</{$k}>";
            $str .= $node?"</{$node}>":'';
        }
        return $str;
    }


    /**
     * 把soap xml格式转成数组
     * @param $xml
     * @return mixed
     */
    public static function soapXmlToArray($xml)
    {
        return self::xmlToArray($xml,$body='soap');
    }

    public static function xmlToArray($xml,$body=''){
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        $result = '';
        switch ($body){
            case 'soap':
                $xmlObj->registerXPathNamespace('soap', 'http://htng.org/2014B/HTNG_ARIAndReservationPushService#GetPMSHotelInfo');
                $result = $xmlObj->xpath("soap:Body");
                break;
            default:
                break;
        }

        $result = $result?:$xmlObj;
        $arr = json_decode( json_encode($result),true );
        return $arr;
    }

    /**
     * 数组转成xml
     * @array $data       数组
     * @param int $level 作为xml的第几层
     * @param null $prior_key 节点
     * @return string
     */
    public static function arrayToXml(&$data, $level = 0, $prior_key = NULL) {
        if($level == 0) {
            ob_start();
            echo "<?xml version=\"1.0\" encoding=\"".CHARSET."\"?>\n<root>","\n";
        }

        while(list($key, $value) = each($data)) {

            if(!strpos($key, ' attr')) {

                if(is_array($value) and array_key_exists(0, $value)) {
                    self::arrayToXml($value, $level, $key);
                } else {
                    $tag = $prior_key ? $prior_key : (is_numeric($key) ? 'item' : $key);
                    echo str_repeat("\t", $level),'<',$tag;

                    if(array_key_exists("$key attr", $data)) {
                        while(list($attr_name, $attr_value) = each($data["$key attr"])) {
                            echo ' ',$attr_name,'="',self::new_html_special_chars($attr_value),'"';
                        }
                        reset($data["$key attr"]);
                    }

                    if(is_null($value)) {
                        echo " />\n";
                    } elseif(!is_array($value)) {
                        echo '>',self::new_html_special_chars($value),"</$tag>\n";
                    } else {
                        echo ">\n",self::arrayToXml($value, $level+1),str_repeat("\t", $level),"</$tag>\n";
                    }
                }
            }
        }

        reset($data);
        if($level == 0) {
            $str = ob_get_contents();
            ob_end_clean();
            return $str.'</root>';
        }
    }

    /**
     * 返回经处理htmlspecialchars处理过的字符串的数组
     * @param $string 需要处理的字符串或者数组
     * @return array|string
     */
    public static function new_html_special_chars($string)
    {
        $encoding = 'utf-8';
        if( strtolower(CHARSET) == 'gbk' ) $encoding = 'ISO-8859-15';
        if( !is_array($string) ) return htmlspecialchars($string,ENT_QUOTES,$encoding);
        foreach ( $string as $key=>$val ) $string[$key] = self::new_html_special_chars($val);
        return $string;
    }



}