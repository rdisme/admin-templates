<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if( ! function_exists('http_get'))
{
	/**
     * GET 请求
     * @param string $url
     * @return content / false
     */
	function http_get($url)
	{
		$oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
	}
}

if( ! function_exists('http_post'))
{
	/**
     * POST 请求
     * @param string $url
     * @param array $param
     * @param boolean $post_file 是否文件上传
     * @return string content / false
     */
	function http_post($url,$param,$post_file=false)
	{
		$oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (PHP_VERSION_ID >= 50500 && class_exists('\CURLFile')) {
            $is_curlFile = true;
        } else {
            $is_curlFile = false;
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, false);
            }
        }
        if (is_string($param)) {
            $strPOST = $param;
        }elseif($post_file) {
            if($is_curlFile) {
                foreach ($param as $key => $val) {
                    if (substr($val, 0, 1) == '@') {
                        $param[$key] = new \CURLFile(realpath(substr($val,1)));
                    }
                }
            }
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach($param as $key=>$val){
                $aPOST[] = $key."=".urlencode($val);
            }
            $strPOST =  join("&", $aPOST);
        }

        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($oCurl, CURLOPT_POST,true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        // log_message('error','http-post-status:'.json_encode($aStatus));
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
	}
}

if( ! function_exists('data_init'))
{
    /**
     * @param array $rows
     */
    function data_init($rows, $id='id',$pid='pid',$child='child',$root=0)
    {
        $tree = array();
        if(is_array($rows))
        {
            $array = array();
            foreach($rows as $key=>$item)
            {
                $array[$item[$id]] =& $rows[$key];
            }
            foreach($rows as $key=>$item)
            {
                $parentId = $item[$pid];
                if($root == $parentId){
                    $tree[] =& $rows[$key];
                }else{
                    if(isset($array[$parentId])){
                        $parent =& $array[$parentId];
                        $parent[$child][] =& $rows[$key];
                    }
                }
            }
        }
        return $tree;
    }
}