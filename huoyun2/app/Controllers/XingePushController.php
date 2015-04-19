<?php namespace Controllers;

use Illuminate\Routing\Controller;
use Huoyun\Models\User;
use Huoyun\Models\Role;
use Huoyun\Models\Horder;
use Hardywen\Yimei\Facades\YimeiFacade;
use Huoyun\Services\Xinge\XingeApp;
use Huoyun\Services\Xinge\Message;
use Huoyun\Services\Xinge\Style;
use Huoyun\Services\Xinge\ClickAction;
use Huoyun\Services\Xinge\TimeInterval;

class XingePushController extends Controller {
	
	public function driverRequested() {
		$accessId= 2100103063;
		$secretKey = '8583b2691cfaee9d488a4c44e22381c5';
		
		
	}
	
	public function testXinge() {
		$push = new XingeApp ( 2100094985, '13a6113acf2c36ea0a5071ff8c848b3e' );
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
		$ret = $push->PushSingleDevice ( 'f14e29c23d855a0047c39163548542deb02c1bce', $mess );
		// $ret= $push->PushAllDevices(0, $mess, 0);
		var_dump ( $ret );
	}
}