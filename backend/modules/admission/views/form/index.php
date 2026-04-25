<?php

$this->title = 'Admission Application';

echo $this->render('_form', [
    'parentModel' => $parentModel,
    'children' => $children,
    'policyModel' => $policyModel,
]);