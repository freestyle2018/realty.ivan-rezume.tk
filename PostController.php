<?php

namespace app\controllers;

use app\models\Kvartira;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use bupy7\xml\constructor\XmlConstructor;



use Biplane\YandexDirect\Api\V5\Contract\AdFieldEnum;
use Biplane\YandexDirect\Api\V5\Contract\AdsSelectionCriteria;
use Biplane\YandexDirect\Api\V5\Contract\GetAdsRequest;
use Biplane\YandexDirect\Api\V5\Contract\StateEnum;
use Biplane\YandexDirect\User;


class PostController extends \yii\web\Controller
{
    public $layout='index';
	
	public function actionIndex()
    {
        
		
		
		
		$xml = new XmlConstructor();
		$in = [
			[
				'tag' => 'root',
				'elements' => [
					[
						'tag' => 'tag1',
						'attributes' => [
							'attr1' => 'val1',
							'attr2' => 'val2',
						],
					],
					[
						'tag' => 'tag2',
						'content' => 'content2',
					],
					[
						'tag' => 'tag3',
						'elements' => [
							[
								'tag' => 'tag4',
								'content' => 'content4',
							],
						],
					],
				],
			],
		];
		
		//echo $xml->fromArray($in)->toOutput();
		
		
		
		
		
		
		//echo User::LOCALE_RU;
		//exit();
		
		
		//"access_token", "invoker", "locale", "login", "master_token", "retry_factor", "retry_max_attempts", "retry_max_delay", "sandbox", "soap_options", "use_operator_units".
		
		$user = new User([
			'access_token' => 'AQAAAAAhqJMJAAUQ6T-pLUmyKEQ0o3oxtlx8DZs',
			'login' => 'webartagency',
			'locale' => User::LOCALE_RU,
			'sandbox' => true,
		]);
		
		
		$criteria = AdsSelectionCriteria::create()
			->setStates([
			]);
		

		$payload = GetAdsRequest::create()
			->setSelectionCriteria($criteria)
			->setFieldNames([
				AdFieldEnum::ID
			]);

		$response = $user->getCampaignsService()->get($payload);
		
		//var_dump($payload);

		foreach ($response->getAds() as $ad) {
			echo $ad;
			// here $ad is instance of Biplane\YandexDirect\Api\V5\Contract\AdGetItem
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		return $this->render('post');
		
    }

}






















