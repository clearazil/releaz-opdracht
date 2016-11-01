<?php

namespace console\controllers;

use yii\console\Controller;

class SeedController extends Controller
{
	public $class;

	public function options($actionID)
	{
		return ['class'];
	}

	public function optionAliases()
	{
		return ['c' => 'class'];
	}

	public function actionIndex()
	{
		if(empty($this->class)) {
			echo 'A class needs to be provided.' . "\n";
		} else {
			$className = 'console\seeds\\' . $this->class . 'Seeder';
			$seeder = new $className;
			call_user_func_array([$seeder, 'seed'], []);
		}
	}
}