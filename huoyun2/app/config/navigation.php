<?php

// Defining menu structure here
// the items that need to appear when user is logged in should have logged_in set as true
return array(

	'menu' => array(
		array(
			'label' => '浏览',
			'route' => 'home',
			'active' => array('/','popular','comments')
		),
		array(
			'label' => '分类',
			'route' => 'home',
			'active' => array('categories*')
		),
		array(
			'label' => '标签',
			'route' => 'home',
			'active' => array('tags*')
		),
		array(
			'label' => '新建trick',
			'route' => 'home',
			'active' => array('user/tricks/new'),
			// 'logged_in' => true
		),
		array(
					'label' => '上传本地图片',
					'route' => 'home',
					'active' => array('user/image/new'),
					// 'logged_in' => true
		),
		array(
					'label' => '抓取网络图片',
					'route' => 'home',
					'active' => array('user/image/new_net'),
					// 'logged_in' => true
			),
		array(
			'label' => '图片',
			'route' => 'home',
			'active' => array('image*'),
				// 'logged_in' => true
		),
		array(
				'label' => '产品',
				'route' => 'home',
				'active' => array('product*'),
				// 'logged_in' => true
		),
		array(
				'label' => '购物车',
				'route' => 'home',
				'active' => array('cart*'),
				// 'logged_in' => true
		),
	),

	'browse' => array(
		array(
			'label' => '最新',
			'route' => 'home',
			'active' => array('/')
		),
		array(
			'label' => '最流行',
			'route' => 'home',
			'active' => array('popular')
		),
		array(
			'label' => '推荐',
			'route' => 'home',
			'active' => array('comments')
		),
	),

);
