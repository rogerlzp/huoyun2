<?php namespace Huoyun\Services\Queue;

use Illuminate\Auth\AuthManager;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Log;

use Huoyun\Services\Xinge\XingeApp;
use Huoyun\Services\Xinge\Message;
use Huoyun\Services\Xinge\Style;
use Huoyun\Services\Xinge\ClickAction;
use Huoyun\Services\Xinge\TimeInterval;

class NotifyHuozhuQueue
{
	public function fire($job, $data) {
		Log::info('data='.$data['device_token']);
		$this->driverRequested($data['device_token']);
		
		$job->delete();
		
	}
	
	public function driverRequested($device_token) {
		$accessId= 2100103063;
		$secretKey = '8583b2691cfaee9d488a4c44e22381c5';
		$push = new XingeApp ( $accessId, $secretKey);
		$mess = new Message ();
	
		$mess->setTitle ( '你好' );
		$mess->setContent ( '你好' );
		$mess->setExpireTime ( 86400 );
		$mess->setType ( Message::TYPE_NOTIFICATION );
		$style = new Style ( 0 );
		// 含义：样式编号0，响铃，震动，不可从通知栏清除，不影响先前通知
		$style = new Style ( 0, 1, 1, 0, 0 );
		$action = new ClickAction ();
		$action->setActionType ( ClickAction::TYPE_URL );
		$action->setUrl ( "http://xg.qq.com" );
		// 打开url需要用户确认
		$action->setComfirmOnUrl ( 1 );
		$custom = array (
				'key1' => 'value1',
				'key2' => 'value2'
		);
		$mess->setStyle ( $style );
		$mess->setAction ( $action );
		$mess->setCustom ( $custom );
		$acceptTime1 = new TimeInterval ( 0, 0, 23, 59 );
		$mess->addAcceptTime ( $acceptTime1 );
		
		// $mess->setSendTime($sendTime);
		// $push->PushSingleDevice($deviceToken, $message)PushTokenAndroid
		$ret = $push->PushSingleDevice ( $device_token, $mess );
		Log::info('result='.$ret['ret_code']);
	
	}
	
	
}

