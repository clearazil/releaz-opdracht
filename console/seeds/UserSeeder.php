<?php

namespace console\seeds;

use tebazil\yii2seeder\Seeder;
use Yii;

class UserSeeder
{
	public function seed()
	{
		$seeder = new Seeder();

		$users = [
			[
				'username' => 'admin',
				'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
				'email' => 'derkvanderheide@hotmail.com',
				'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
				'created_at' => time(),
				'updated_at' => time(),
			],
		];

		$seeder->table('user')->data($users)->rowQuantity(count($users));

		$seeder->refill();
	}
}