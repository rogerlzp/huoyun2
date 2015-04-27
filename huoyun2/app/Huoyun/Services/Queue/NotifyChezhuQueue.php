<?php namespace Huoyun\Services\Queue;

use Illuminate\Auth\AuthManager;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Log;

use Huoyun\Services\Xinge\XingeApp;
use Huoyun\Services\Xinge\Message;
use Huoyun\Services\Xinge\Style;
use Huoyun\Services\Xinge\ClickAction;
use Huoyun\Services\Xinge\TimeInterval;

class NotifyChezhuQueue
{
	public function fire($job, $data) {
		Log::info('data='.$data['device_token']);
		$this->HuozhuConfirmed($data['device_token']);
		
		$job->delete();
		
	}
	
	public function HuozhuConfirmed($device_token) {
		$accessId= 2100094985;
		$secretKey = '13a6113acf2c36ea0a5071ff8c848b3e';
		$push = new XingeApp ( $accessId, $secretKey);
		$mess = new Message ();
	
		$mess->setTitle ( '货主选择您了' );
		$mess->setContent ( '恭喜，货主确定由您来承接该单，请尽快去查看' );
		$mess->setExpireTime ( 86400 );
		$mess->setType ( Message::TYPE_NOTIFICATION );
		// 含义：样式编号0，响铃，震动，不可从通知栏清除，不影响先前通知
		$style = new Style ( 0, 1, 1, 0, 0 );
		$action = new ClickAction ();
		$action->setActionType ( ClickAction::TYPE_ACTIVITY );
		$action->setActivity("MainActivity");
		// 打开url需要用户确认
	//	$action->setComfirmOnUrl ( 1 );
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

