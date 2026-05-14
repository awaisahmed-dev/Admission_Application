<?php

namespace frontend\modules\admission\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\admission\models\ParentModel;
use frontend\modules\admission\models\ChildModel;
use frontend\modules\admission\models\PolicyModel;

class FormController extends Controller
{
    public function actionIndex()
    {
        $parentModel = new ParentModel();
        $policyModel = new PolicyModel();

        // at least 1 child
        $children = [new ChildModel()];

        if ($parentModel->load(Yii::$app->request->post())) {

            $childrenData = Yii::$app->request->post('ChildModel', []);
            $children = [];

            foreach ($childrenData as $childData) {
                $child = new ChildModel();
                $child->load(['ChildModel' => $childData]);
                $children[] = $child;
            }

            $policyModel->load(Yii::$app->request->post());

            $post=Yii::$app->request->post('PolicyModel',[]);

            $policyModel->volunteer_cleaning =
            isset($post['volunteer_cleaning']) ? 1:0;

            $policyModel->volunteer_snacks =
            isset($post['volunteer_snacks']) ? 1:0;

            $policyModel->volunteer_supervision =
            isset($post['volunteer_supervision']) ? 1:0;

            $policyModel->volunteer_admin =
            isset($post['volunteer_admin']) ? 1:0;

            $policyModel->volunteer_teaching_quran =
            isset($post['volunteer_teaching_quran']) ? 1:0;

            $policyModel->volunteer_teaching_islamic =
            isset($post['volunteer_teaching_islamic']) ? 1:0;

            $policyModel->volunteer_teaching_urdu =
            isset($post['volunteer_teaching_urdu']) ? 1:0;

            // 🔥 TRANSACTION START
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($parentModel->save()) {

                    // SAVE CHILDREN
                    foreach ($children as $child) {
                        $child->parent_id = $parentModel->id;
                        if (!$child->save()) {
                            throw new \Exception('Child not saved');
                        }
                    }

                    // SAVE POLICY
                    $policyModel->parent_id = $parentModel->id;
                    if (!$policyModel->save()) {
                    if(!$policyModel->validate() || !$policyModel->save(false))
                        throw new \Exception('Policy not saved');
                    }

                    $transaction->commit();

                    Yii::$app->session->setFlash('success', 'Application Submitted Successfully');

                    return $this->refresh();

                } else {
                    throw new \Exception('Parent not saved');
                }

            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('index', [
            'parentModel' => $parentModel,
            'children' => $children,
            'policyModel' => $policyModel,
        ]);
    }
}