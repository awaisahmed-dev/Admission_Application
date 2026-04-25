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