<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;

		$viewUsers = $auth->createPermission('viewUsers');
		$viewUsers->description = 'View users';
		$auth->add($viewUsers);

		$viewUser = $auth->createPermission('viewUser');
		$viewUser->description = 'View a user';
		$auth->add($viewUser);

		$createUser = $auth->createPermission('createUser');
		$createUser->description = 'Create a user';
		$auth->add($createUser);

		$updateUser = $auth->createPermission('updateUser');
		$updateUser->description = 'Update a user';
		$auth->add($updateUser);

		$deleteUser = $auth->createPermission('deleteUser');
		$deleteUser->description = 'Delete a user';
		$auth->add($deleteUser);

		$admin = $auth->createRole('admin');
		$auth->add($admin);
		$auth->addChild($admin, $viewUsers);
		$auth->addChild($admin, $viewUser);
		$auth->addChild($admin, $createUser);
		$auth->addChild($admin, $updateUser);
		$auth->addChild($admin, $deleteUser);

		$auth->assign($admin, 1);
	}
}