<?php
/**
 * BudgetControllerTest.php
 * Copyright (C) 2016 Sander Dorigo
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */


/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-19 at 15:39:27.
 */
class BudgetControllerTest extends TestCase
{
    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::amount
     */
    public function testAmount()
    {
        $args = [
            'amount' => 1200,
        ];
        $this->be($this->user());

        $this->call('POST', '/budgets/amount/1', $args);
        $this->assertResponseStatus(200);
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::create
     */
    public function testCreate()
    {
        $this->be($this->user());
        $this->call('GET', '/budgets/create');
        $this->assertResponseStatus(200);
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::delete
     */
    public function testDelete()
    {
        $this->be($this->user());
        $this->call('GET', '/budgets/delete/1');
        $this->assertResponseStatus(200);
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::destroy
     */
    public function testDestroy()
    {
        $this->be($this->user());

        $this->session(['budgets.delete.url' => 'http://localhost']);
        $this->call('POST', '/budgets/destroy/2');
        $this->assertSessionHas('success');
        $this->assertResponseStatus(302);
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::edit
     */
    public function testEdit()
    {
        $this->be($this->user());
        $this->call('GET', '/budgets/edit/1');
        $this->assertResponseStatus(200);
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::index
     */
    public function testIndex()
    {
        $this->be($this->user());
        $this->call('GET', '/budgets');
        $this->assertResponseStatus(200);
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::noBudget
     */
    public function testNoBudget()
    {
        $this->be($this->user());
        $this->call('GET', '/budgets/list/noBudget');
        $this->assertResponseStatus(200);
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::postUpdateIncome
     */
    public function testPostUpdateIncome()
    {
        $args = [
            'amount' => 1200,
        ];
        $this->be($this->user());

        $this->call('POST', '/budgets/income', $args);
        $this->assertResponseStatus(302);
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::show
     */
    public function testShow()
    {
        $this->be($this->user());
        $this->call('GET', '/budgets/show/1');
        $this->assertResponseStatus(200);
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::store
     */
    public function testStore()
    {
        $this->be($this->user());
        $this->session(['budgets.create.url' => 'http://localhost']);
        $args = [
            'name'   => 'Some kind of test budget.',
        ];

        $this->call('POST', '/budgets/store', $args);
        $this->assertResponseStatus(302);
        $this->assertSessionHas('success');
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::update
     */
    public function testUpdate()
    {
        $this->be($this->user());
        $this->session(['budgets.edit.url' => 'http://localhost']);
        $args = [
            'name'   => 'Some kind of test budget.',
        ];

        $this->call('POST', '/budgets/update/1', $args);
        $this->assertResponseStatus(302);
        $this->assertSessionHas('success');
    }

    /**
     * @covers FireflyIII\Http\Controllers\BudgetController::updateIncome
     */
    public function testUpdateIncome()
    {
        $this->be($this->user());
        $this->call('GET', '/budgets/income');
        $this->assertResponseStatus(200);
    }
}
