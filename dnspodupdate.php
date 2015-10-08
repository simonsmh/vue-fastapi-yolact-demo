<?php
error_reporting(0);
set_time_limit(0);
header('Content-type:text/html; charset=utf-8');
 
if(!$_GET['username']||!$_GET['password']||!$_GET['domain']){
	exit(json_encode(array('msg'=>'username,password,domain 参数必选')));
}
 
$domain = explode("@", $_GET['domain']);
 
$config = array(
	'login_email' => $_GET['username'],
	'login_password' => $_GET['password'],
	'sub_domain' => $domain[0],
	'domain' => $domain[1],
	'record_line' => $_GET['line']?$_GET['line']:'默认',
	'ttl' => 600,
	'format' => 'json',
	'lang' => 'cn',
	'error_on_empty' => 'no',
);
 
$dnspod = new dnspod($config);
$config['ip'] = $_GET['myip']?$_GET['myip']:$_SERVER['REMOTE_ADDR'];
$dnspod->updateRecordIp($config['ip']);
class dnspod {
	var $config;
	var $domain;
	var $sub_domain;
	var $record_line;
	function __construct($config)
	{
		$this->config = $config;
		$this->domain = $config['domain'];
		$this->sub_domain = $config['sub_domain'];
		$this->record_line = $config['record_line'];
		
	}
	public function api_call($api, $data) {
		if ($api == '' || !is_array($data)) {
			exit(json_encode(array('msg'=>'内部错误：参数错误')));
		}
		
		$api = 'https://dnsapi.cn/' . $api;
 
		$data = array_merge($data,$this->config);
		
		$result = $this->post_data($api, $data);
		if (!$result) {
			exit(json_encode(array('msg'=>'内部错误：调用失败')));
		}
		
		$results = @json_decode($result, 1);
		if (!is_array($results)) {
			exit(json_encode(array('msg'=>'内部错误：返回错误')));
		}
		
		if ($results['status']['code'] != 1) {
			exit(json_encode(array('msg'=>$results['status']['message'])));
		}
		
		return $results;
	}
	public function updateRecordDdns(){
		$record = $this->getRecordInfo();
		//判断IP是否改变
		if($record['records'][0]['value'] == $_SERVER['REMOTE_ADDR']){
			exit(json_encode(array('msg'=>'记录不需要更新')));
		}
		
		$response = $this->api_call('Record.Ddns', array('record_id'=>$record['records'][0]['id'],'record_line'=>$this->record_line));
		if($response){
			exit(json_encode($response));
		}else{
			exit(json_encode(array('msg'=>'更新失败')));
		}
	}
	//获取域名信息
	public function getDomainInfo(){
		$response = $this->api_call('Domain.Info', array('domain' =>$this->domain));
		return $response;
	}
	//获取记录
	function getRecordInfo(){
		$response = $this->api_call('Record.List', array('sub_domain'=>$this->sub_domain,'domain' =>$this->domain));
		return $response;
	}
	//修改A记录IP
	function updateRecordIp($ip){
		$record = $this->getRecordInfo();
		//判断IP是否改变
		if($record['records'][0]['value']==$ip){
			exit(json_encode(array('msg'=>'记录不需要更新')));
		}
		
		$response = $this->api_call('Record.Modify', array('record_id'=>$record['records'][0]['id'],'record_line'=>$this->record_line,'record_type'=>'A','value'=>$ip));
		return $response;
	}
	
	private function post_data($url, $data) {
		if ($url == '' || !is_array($data)) {
			return false;
		}
		
		$ch = @curl_init();
		if (!$ch) {
			exit(json_encode(array('msg'=>'内部错误：服务器不支持CURL')));
		}
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_USERAGENT, 'DNSPod MYDDNS/0.1 (i@biner.me)');
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
}