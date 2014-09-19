<?php

class ApiController extends AppController
{

    function test()
    {
        $result = ['status' => 'complete', 'fruits' => ['apple', 'orange', 'banana']];
        $this->viewClass = 'Json';
        $this->set(compact('result'));
        $this->set('_serialize', 'result');
    }
}