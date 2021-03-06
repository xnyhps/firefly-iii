<?php
use Carbon\Carbon;
use FireflyIII\Models\Account;
use FireflyIII\Models\Bill;
use FireflyIII\Models\Budget;
use FireflyIII\Models\BudgetLimit;
use FireflyIII\Models\Category;
use FireflyIII\Models\PiggyBank;
use FireflyIII\Models\Preference;
use FireflyIII\Models\Role;
use FireflyIII\Models\Rule;
use FireflyIII\Models\RuleAction;
use FireflyIII\Models\RuleGroup;
use FireflyIII\Models\RuleTrigger;
use FireflyIII\Models\Tag;
use FireflyIII\Models\Transaction;
use FireflyIII\Models\TransactionJournal;
use FireflyIII\Support\Migration\TestData;
use FireflyIII\User;
use Illuminate\Database\Seeder;


/**
 *
 * Class TestDataSeeder
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class VisualTestDataSeeder extends Seeder
{

    /** @var  User */
    protected $user;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function createRules()
    {
        // three rule groups to get started.
        $ruleGroup = new RuleGroup;
        $ruleGroup->user()->associate($this->user);
        $ruleGroup->order       = 1;
        $ruleGroup->active      = 1;
        $ruleGroup->title       = 'Default rules';
        $ruleGroup->description = 'All your rules not in a particular group.';
        $ruleGroup->save();
        unset($ruleGroup);

        $ruleGroup = new RuleGroup;
        $ruleGroup->user()->associate($this->user);
        $ruleGroup->order       = 2;
        $ruleGroup->active      = 1;
        $ruleGroup->title       = 'Empty rule group';
        $ruleGroup->description = 'Intentionally has no rules.';
        $ruleGroup->save();
        unset($ruleGroup);


        $ruleGroup = new RuleGroup;
        $ruleGroup->user()->associate($this->user);
        $ruleGroup->order       = 3;
        $ruleGroup->active      = 1;
        $ruleGroup->title       = 'Rules for bills';
        $ruleGroup->description = 'All rules for bills and recurring costs.';
        $ruleGroup->save();
        unset($ruleGroup);

        // move groceries to correct budget/category
        $rule = new Rule;
        $rule->user()->associate($this->user);
        $rule->ruleGroup()->associate(RuleGroup::find(1));
        $rule->order           = 1;
        $rule->active          = 1;
        $rule->stop_processing = 0;
        $rule->title           = 'Move groceries';
        $rule->description     = 'Move groceries to correct category and budget.';

        $rule->save();

        // initial trigger for this rule:
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 1;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'user_action';
        $ruleTrigger->trigger_value   = 'store-journal';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // content trigger for this rule.
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 2;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'description_contains';
        $ruleTrigger->trigger_value   = 'groceries';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // another
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 3;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'from_account_is';
        $ruleTrigger->trigger_value   = 'TestData Checking Account';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // actions for this rule. one, set category
        $ruleAction = new RuleAction;
        $ruleAction->rule()->associate($rule);
        $ruleAction->order           = 1;
        $ruleAction->active          = 1;
        $ruleAction->stop_processing = 0;
        $ruleAction->action_type     = 'set_category';
        $ruleAction->action_value    = 'Groceries';
        $ruleAction->save();
        unset($ruleAction);

        // actions for this rule. one, set budget
        $ruleAction = new RuleAction;
        $ruleAction->rule()->associate($rule);
        $ruleAction->order           = 2;
        $ruleAction->active          = 1;
        $ruleAction->stop_processing = 0;
        $ruleAction->action_type     = 'set_budget';
        $ruleAction->action_value    = 'Groceries';
        $ruleAction->save();
        unset($ruleAction);


        // move "gas" to "Car" and "Car"
        $rule = new Rule;
        $rule->user()->associate($this->user);
        $rule->ruleGroup()->associate(RuleGroup::find(1));
        $rule->order           = 2;
        $rule->active          = 1;
        $rule->stop_processing = 0;
        $rule->title           = 'Move gas';
        $rule->description     = null;

        $rule->save();

        // initial trigger for this rule:
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 1;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'user_action';
        $ruleTrigger->trigger_value   = 'store-journal';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // content trigger for this rule.
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 2;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'description_contains';
        $ruleTrigger->trigger_value   = 'gas';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // another
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 3;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'from_account_is';
        $ruleTrigger->trigger_value   = 'TestData Checking Account';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // actions for this rule. one, set category
        $ruleAction = new RuleAction;
        $ruleAction->rule()->associate($rule);
        $ruleAction->order           = 1;
        $ruleAction->active          = 1;
        $ruleAction->stop_processing = 0;
        $ruleAction->action_type     = 'set_category';
        $ruleAction->action_value    = 'Car';
        $ruleAction->save();
        unset($ruleAction);

        // actions for this rule. one, set budget
        $ruleAction = new RuleAction;
        $ruleAction->rule()->associate($rule);
        $ruleAction->order           = 2;
        $ruleAction->active          = 1;
        $ruleAction->stop_processing = 0;
        $ruleAction->action_type     = 'set_budget';
        $ruleAction->action_value    = 'Car';
        $ruleAction->save();
        unset($ruleAction);

        // move savings to money management
        $rule = new Rule;
        $rule->user()->associate($this->user);
        $rule->ruleGroup()->associate(RuleGroup::find(1));
        $rule->order           = 3;
        $rule->active          = 1;
        $rule->stop_processing = 0;
        $rule->title           = 'Move savings';
        $rule->description     = null;

        $rule->save();

        // initial trigger for this rule:
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 1;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'user_action';
        $ruleTrigger->trigger_value   = 'store-journal';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // is transfer
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 2;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'transaction_type';
        $ruleTrigger->trigger_value   = 'Transfer';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // content trigger for this rule.
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 3;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'description_is';
        $ruleTrigger->trigger_value   = 'Save money';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // another
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 4;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'from_account_is';
        $ruleTrigger->trigger_value   = 'TestData Checking Account';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // another
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 5;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'to_account_is';
        $ruleTrigger->trigger_value   = 'TestData Savings';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // actions for this rule. one, set category
        $ruleAction = new RuleAction;
        $ruleAction->rule()->associate($rule);
        $ruleAction->order           = 1;
        $ruleAction->active          = 1;
        $ruleAction->stop_processing = 0;
        $ruleAction->action_type     = 'set_category';
        $ruleAction->action_value    = 'Money Management';
        $ruleAction->save();
        unset($ruleAction);

        // move TV bill to "Bills" and "House"
        $rule = new Rule;
        $rule->user()->associate($this->user);
        $rule->ruleGroup()->associate(RuleGroup::find(3));
        $rule->order           = 1;
        $rule->active          = 1;
        $rule->stop_processing = 0;
        $rule->title           = 'TV Bill';
        $rule->description     = null;

        $rule->save();

        // initial trigger for this rule:
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 1;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'user_action';
        $ruleTrigger->trigger_value   = 'store-journal';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // content trigger for this rule.
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 2;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'description_contains';
        $ruleTrigger->trigger_value   = 'tv bill';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // another
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 3;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'from_account_is';
        $ruleTrigger->trigger_value   = 'TestData Checking Account';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // actions for this rule. one, set category
        $ruleAction = new RuleAction;
        $ruleAction->rule()->associate($rule);
        $ruleAction->order           = 1;
        $ruleAction->active          = 1;
        $ruleAction->stop_processing = 0;
        $ruleAction->action_type     = 'set_category';
        $ruleAction->action_value    = 'House';
        $ruleAction->save();
        unset($ruleAction);

        // actions for this rule. one, set budget
        $ruleAction = new RuleAction;
        $ruleAction->rule()->associate($rule);
        $ruleAction->order           = 2;
        $ruleAction->active          = 1;
        $ruleAction->stop_processing = 0;
        $ruleAction->action_type     = 'set_budget';
        $ruleAction->action_value    = 'Bills';
        $ruleAction->save();
        unset($ruleAction);

        // move rent to bills, rent.
        $rule = new Rule;
        $rule->user()->associate($this->user);
        $rule->ruleGroup()->associate(RuleGroup::find(3));
        $rule->order           = 2;
        $rule->active          = 1;
        $rule->stop_processing = 1;
        $rule->title           = 'Rent';
        $rule->description     = 'Do something with rent.';

        $rule->save();

        // initial trigger for this rule:
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 1;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'user_action';
        $ruleTrigger->trigger_value   = 'update-journal';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // content trigger for this rule.
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 2;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 0;
        $ruleTrigger->trigger_type    = 'description_contains';
        $ruleTrigger->trigger_value   = 'rent';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // another
        $ruleTrigger = new RuleTrigger;
        $ruleTrigger->rule()->associate($rule);
        $ruleTrigger->order           = 3;
        $ruleTrigger->active          = 1;
        $ruleTrigger->stop_processing = 1;
        $ruleTrigger->trigger_type    = 'from_account_is';
        $ruleTrigger->trigger_value   = 'TestData Checking Account';

        $ruleTrigger->save();
        unset($ruleTrigger);

        // actions for this rule. one, set category
        $ruleAction = new RuleAction;
        $ruleAction->rule()->associate($rule);
        $ruleAction->order           = 1;
        $ruleAction->active          = 1;
        $ruleAction->stop_processing = 0;
        $ruleAction->action_type     = 'set_category';
        $ruleAction->action_value    = 'House';
        $ruleAction->save();
        unset($ruleAction);

        // actions for this rule. one, set budget
        $ruleAction = new RuleAction;
        $ruleAction->rule()->associate($rule);
        $ruleAction->order           = 2;
        $ruleAction->active          = 1;
        $ruleAction->stop_processing = 1;
        $ruleAction->action_type     = 'set_budget';
        $ruleAction->action_value    = 'Bills';
        $ruleAction->save();
        unset($ruleAction);
    }

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function run()
    {
        $this->createUsers();

        // create accounts:
        TestData::createAssetAccounts($this->user);
        $this->createExpenseAccounts();
        $this->createRevenueAccounts();
        TestData::createBills($this->user);
        TestData::createPiggybanks($this->user);

        $this->createRules();

        // preference to only see account #1 on frontpage.
        $this->createPreferences();

        // dates:
        $start = Carbon::now()->subYears(2)->startOfMonth();
        $end   = Carbon::now()->endOfDay();


        $current = clone $start;
        while ($current < $end) {
            $month = $current->format('F Y');
            // create salaries:
            $this->createIncome('Salary ' . $month, $current, rand(2000, 2100));

            // pay bills:
            $this->createRent('Rent for ' . $month, $current, 800);
            $this->createWater('Water bill for ' . $month, $current, 15);
            $this->createTV('TV bill for ' . $month, $current, 60);
            $this->createPower('Power bill for ' . $month, $current, 120);


            // pay daily groceries:
            $this->createGroceries($current);

            // create tag (each type of tag, for date):
            $this->createTags($current);

            // go out for drinks:
            $this->createDrinksAndOthers($current);

            // save money every month:
            $this->createSavings($current);

            // buy gas for the car every month:
            $this->createCar($current);

            // budget limit for this month, on "Groceries".
            $this->createBudgetLimit($current, 'Groceries', 400);
            $this->createBudgetLimit($current, 'Bills', 1000);
            $this->createBudgetLimit($current, 'Car', 100);

            echo 'Created test data for ' . $month . "\n";
            $current->addMonth();
        }

    }

    /**
     * @param Carbon $current
     * @param        $name
     * @param        $amount
     */
    protected function createBudgetLimit(Carbon $current, $name, $amount)
    {
        $start  = clone $current;
        $end    = clone $current;
        $budget = $this->findBudget($name);
        $start->startOfMonth();
        $end->endOfMonth();

        BudgetLimit::create(
            [
                'budget_id'   => $budget->id,
                'startdate'   => $start->format('Y-m-d'),
                'amount'      => $amount,
                'repeats'     => 0,
                'repeat_freq' => 'monthly',
            ]
        );
    }

    /**
     * @param $date
     *
     * @return static
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function createCar($date)
    {
        // twice:
        $date        = new Carbon($date->format('Y-m') . '-10'); // paid on 10th
        $fromAccount = TestData::findAccount($this->user, 'TestData Checking Account');
        $toAccount   = TestData::findAccount($this->user, 'Shell');
        $category    = Category::firstOrCreateEncrypted(['name' => 'Car', 'user_id' => $this->user->id]);
        $budget      = Budget::firstOrCreateEncrypted(['name' => 'Car', 'user_id' => $this->user->id]);
        $amount      = rand(4000, 5000) / 100;
        $journal     = TransactionJournal::create(
            [
                'user_id'                 => $this->user->id,
                'transaction_type_id'     => 1,
                'transaction_currency_id' => 1,
                'description'             => 'Bought gas',
                'completed'               => 1,
                'date'                    => $date,
            ]
        );
        Transaction::create(
            [
                'account_id'             => $fromAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount * -1,

            ]
        );
        Transaction::create(
            [
                'account_id'             => $toAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount,

            ]
        );
        $journal->categories()->save($category);
        $journal->budgets()->save($budget);

        // and again!
        $date   = new Carbon($date->format('Y-m') . '-20'); // paid on 20th
        $amount = rand(4000, 5000) / 100;


        $journal = TransactionJournal::create(
            [
                'user_id'                 => $this->user->id,
                'transaction_type_id'     => 1,
                'transaction_currency_id' => 1,
                'description'             => 'Gas for car',
                'completed'               => 1,
                'date'                    => $date,
            ]
        );
        Transaction::create(
            [
                'account_id'             => $fromAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount * -1,

            ]
        );
        Transaction::create(
            [
                'account_id'             => $toAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount,

            ]
        );

        // and again!

        return $journal;
    }

    /**
     * @param Carbon $date
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function createDrinksAndOthers(Carbon $date)
    {
        $start = clone $date;
        $end   = clone $date;
        $today = new Carbon;
        $start->startOfMonth();
        $end->endOfMonth();
        $current = clone $start;
        while ($current < $end && $current < $today) {

            // weekly drink:
            $thisDate = clone $current;
            $thisDate->addDay();
            $fromAccount = TestData::findAccount($this->user, 'TestData Checking Account');
            $toAccount   = TestData::findAccount($this->user, 'Cafe Central');
            $category    = Category::firstOrCreateEncrypted(['name' => 'Drinks', 'user_id' => $this->user->id]);
            $budget      = Budget::firstOrCreateEncrypted(['name' => 'Going out', 'user_id' => $this->user->id]);
            $amount      = rand(1500, 3600) / 100;
            $journal     = TransactionJournal::create(
                [
                    'user_id'                 => $this->user->id,
                    'transaction_type_id'     => 1,
                    'transaction_currency_id' => 1,
                    'description'             => 'Going out for drinks',
                    'completed'               => 1,
                    'date'                    => $thisDate,
                ]
            );
            Transaction::create(
                [
                    'account_id'             => $fromAccount->id,
                    'transaction_journal_id' => $journal->id,
                    'amount'                 => $amount * -1,

                ]
            );
            Transaction::create(
                [
                    'account_id'             => $toAccount->id,
                    'transaction_journal_id' => $journal->id,
                    'amount'                 => $amount,

                ]
            );
            $journal->categories()->save($category);
            $journal->budgets()->save($budget);

            // shopping at some (online) shop:


            $current->addWeek();
        }
    }

    protected function createExpenseAccounts()
    {
        $expenses = ['Adobe', 'Google', 'Vitens', 'Albert Heijn', 'PLUS', 'Apple', 'Bakker', 'Belastingdienst', 'bol.com', 'Cafe Central', 'conrad.nl',
                     'coolblue', 'Shell',
                     'DUO', 'Etos', 'FEBO', 'Greenchoice', 'Halfords', 'XS4All', 'iCentre', 'Jumper', 'Land lord'];
        foreach ($expenses as $name) {
            // create account:
            Account::create(
                [
                    'user_id'         => $this->user->id,
                    'account_type_id' => 4,
                    'name'            => $name,
                    'active'          => 1,
                    'encrypted'       => 1,
                ]
            );
        }

    }

    /**
     * @param Carbon $date
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function createGroceries(Carbon $date)
    {
        $start = clone $date;
        $end   = clone $date;
        $today = new Carbon;
        $start->startOfMonth();
        $end->endOfMonth();

        $fromAccount  = TestData::findAccount($this->user, 'TestData Checking Account');
        $stores       = ['Albert Heijn', 'PLUS', 'Bakker'];
        $descriptions = ['Groceries', 'Bought some groceries', 'Got groceries'];
        $category     = Category::firstOrCreateEncrypted(['name' => 'Daily groceries', 'user_id' => $this->user->id]);
        $budget       = Budget::firstOrCreateEncrypted(['name' => 'Groceries', 'user_id' => $this->user->id]);

        $current = clone $start;
        while ($current < $end && $current < $today) {
            // daily groceries:
            $amount    = rand(1500, 2500) / 100;
            $toAccount = TestData::findAccount($this->user, $stores[rand(0, count($stores) - 1)]);

            $journal = TransactionJournal::create(
                [
                    'user_id'                 => $this->user->id,
                    'transaction_type_id'     => 1,
                    'transaction_currency_id' => 1,
                    'description'             => $descriptions[rand(0, count($descriptions) - 1)],
                    'completed'               => 1,
                    'date'                    => $current,
                ]
            );
            Transaction::create(
                [
                    'account_id'             => $fromAccount->id,
                    'transaction_journal_id' => $journal->id,
                    'amount'                 => $amount * -1,

                ]
            );
            Transaction::create(
                [
                    'account_id'             => $toAccount->id,
                    'transaction_journal_id' => $journal->id,
                    'amount'                 => $amount,

                ]
            );
            $journal->categories()->save($category);
            $journal->budgets()->save($budget);


            $current->addDay();
        }
    }

    /**
     * @param        $description
     * @param Carbon $date
     * @param        $amount
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     *
     * @return TransactionJournal
     */
    protected function createIncome($description, Carbon $date, $amount)
    {
        $date  = new Carbon($date->format('Y-m') . '-23'); // paid on 23rd.
        $today = new Carbon;
        if ($date >= $today) {
            return null;
        }
        $toAccount   = TestData::findAccount($this->user, 'TestData Checking Account');
        $fromAccount = TestData::findAccount($this->user, 'Job');
        $category    = Category::firstOrCreateEncrypted(['name' => 'Salary', 'user_id' => $this->user->id]);
        // create journal:

        $journal = TransactionJournal::create(
            [
                'user_id'                 => $this->user->id,
                'transaction_type_id'     => 2,
                'transaction_currency_id' => 1,
                'description'             => $description,
                'completed'               => 1,
                'date'                    => $date,
            ]
        );
        Transaction::create(
            [
                'account_id'             => $fromAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount * -1,

            ]
        );
        Transaction::create(
            [
                'account_id'             => $toAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount,

            ]
        );
        $journal->categories()->save($category);

        return $journal;

    }

    /**
     * @param        $description
     * @param Carbon $date
     * @param        $amount
     *
     * @return TransactionJournal
     */
    protected function createPower($description, Carbon $date, $amount)
    {
        $date        = new Carbon($date->format('Y-m') . '-06'); // paid on 10th
        $fromAccount = TestData::findAccount($this->user, 'TestData Checking Account');
        $toAccount   = TestData::findAccount($this->user, 'Greenchoice');
        $category    = Category::firstOrCreateEncrypted(['name' => 'House', 'user_id' => $this->user->id]);
        $budget      = Budget::firstOrCreateEncrypted(['name' => 'Bills', 'user_id' => $this->user->id]);
        $journal     = TransactionJournal::create(
            [
                'user_id'                 => $this->user->id,
                'transaction_type_id'     => 1,
                'transaction_currency_id' => 1,
                'description'             => $description,
                'completed'               => 1,
                'date'                    => $date,
            ]
        );
        Transaction::create(
            [
                'account_id'             => $fromAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount * -1,

            ]
        );
        Transaction::create(
            [
                'account_id'             => $toAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount,

            ]
        );
        $journal->categories()->save($category);
        $journal->budgets()->save($budget);

        return $journal;

    }

    protected function createPreferences()
    {
        $preference       = new Preference;
        $preference->name = 'frontPageAccounts';
        $preference->data = [1];
        $preference->user()->associate($this->user);
        $preference->save();
    }

    /**
     * @param        $description
     * @param Carbon $date
     * @param        $amount
     *
     * @return TransactionJournal
     */
    protected function createRent($description, Carbon $date, $amount)
    {
        $fromAccount = TestData::findAccount($this->user, 'TestData Checking Account');
        $toAccount   = TestData::findAccount($this->user, 'Land lord');
        $category    = Category::firstOrCreateEncrypted(['name' => 'Rent', 'user_id' => $this->user->id]);
        $budget      = Budget::firstOrCreateEncrypted(['name' => 'Bills', 'user_id' => $this->user->id]);
        $journal     = TransactionJournal::create(
            [
                'user_id'                 => $this->user->id,
                'transaction_type_id'     => 1,
                'transaction_currency_id' => 1,
                'bill_id'                 => 1,
                'description'             => $description,
                'completed'               => 1,
                'date'                    => $date,
            ]
        );
        Transaction::create(
            [
                'account_id'             => $fromAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount * -1,

            ]
        );
        Transaction::create(
            [
                'account_id'             => $toAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount,

            ]
        );
        $journal->categories()->save($category);
        $journal->budgets()->save($budget);

        return $journal;

    }

    /**
     *
     */
    protected function createRevenueAccounts()
    {
        $revenues = ['Job', 'Belastingdienst', 'Bank', 'KPN', 'Google'];
        foreach ($revenues as $name) {
            // create account:
            Account::create(
                [
                    'user_id'         => $this->user->id,
                    'account_type_id' => 5,
                    'name'            => $name,
                    'active'          => 1,
                    'encrypted'       => 1,
                ]
            );
        }
    }

    /**
     * @param Carbon $date
     *
     * @return TransactionJournal
     */
    protected function createSavings(Carbon $date)
    {
        $date        = new Carbon($date->format('Y-m') . '-24'); // paid on 24th.
        $toAccount   = TestData::findAccount($this->user, 'TestData Savings');
        $fromAccount = TestData::findAccount($this->user, 'TestData Checking Account');
        $category    = Category::firstOrCreateEncrypted(['name' => 'Money management', 'user_id' => $this->user->id]);
        // create journal:

        $journal = TransactionJournal::create(
            [
                'user_id'                 => $this->user->id,
                'transaction_type_id'     => 3,
                'transaction_currency_id' => 1,
                'description'             => 'Save money',
                'completed'               => 1,
                'date'                    => $date,
            ]
        );
        Transaction::create(
            [
                'account_id'             => $fromAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => -150,

            ]
        );
        Transaction::create(
            [
                'account_id'             => $toAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => 150,

            ]
        );
        $journal->categories()->save($category);

        return $journal;

    }

    /**
     * @param        $description
     * @param Carbon $date
     * @param        $amount
     *
     * @return TransactionJournal
     */
    protected function createTV($description, Carbon $date, $amount)
    {
        $date        = new Carbon($date->format('Y-m') . '-15'); // paid on 10th
        $fromAccount = TestData::findAccount($this->user, 'TestData Checking Account');
        $toAccount   = TestData::findAccount($this->user, 'XS4All');
        $category    = Category::firstOrCreateEncrypted(['name' => 'House', 'user_id' => $this->user->id]);
        $budget      = Budget::firstOrCreateEncrypted(['name' => 'Bills', 'user_id' => $this->user->id]);
        $journal     = TransactionJournal::create(
            [
                'user_id'                 => $this->user->id,
                'transaction_type_id'     => 1,
                'transaction_currency_id' => 1,
                'description'             => $description,
                'completed'               => 1,
                'date'                    => $date,
            ]
        );
        Transaction::create(
            [
                'account_id'             => $fromAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount * -1,

            ]
        );
        Transaction::create(
            [
                'account_id'             => $toAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount,

            ]
        );
        $journal->categories()->save($category);
        $journal->budgets()->save($budget);

        return $journal;

    }

    /**
     * @param Carbon $date
     */
    protected function createTags(Carbon $date)
    {
        Tag::create(
            [
                'user_id' => $this->user->id,
                'tag'     => 'SomeTag' . $date->month . '.' . $date->year . '.nothing',
                'tagMode' => 'nothing',
                'date'    => $date->format('Y-m-d'),


            ]
        );
    }

    /**
     *
     */
    protected function createUsers()
    {
        User::create(['email' => 'thegrumpydictator@gmail.com', 'password' => bcrypt('james'), 'reset' => null, 'remember_token' => null]);
        $this->user = User::whereEmail('thegrumpydictator@gmail.com')->first();

        // create rights:
        $role = Role::find(1);
        $this->user->roles()->save($role);

    }

    /**
     * @param        $description
     * @param Carbon $date
     * @param        $amount
     *
     * @return TransactionJournal
     */
    protected function createWater($description, Carbon $date, $amount)
    {
        $date        = new Carbon($date->format('Y-m') . '-10'); // paid on 10th
        $fromAccount = TestData::findAccount($this->user, 'TestData Checking Account');
        $toAccount   = TestData::findAccount($this->user, 'Vitens');
        $category    = Category::firstOrCreateEncrypted(['name' => 'House', 'user_id' => $this->user->id]);
        $budget      = Budget::firstOrCreateEncrypted(['name' => 'Bills', 'user_id' => $this->user->id]);
        $journal     = TransactionJournal::create(
            [
                'user_id'                 => $this->user->id,
                'transaction_type_id'     => 1,
                'transaction_currency_id' => 1,
                'description'             => $description,
                'completed'               => 1,
                'date'                    => $date,
            ]
        );
        Transaction::create(
            [
                'account_id'             => $fromAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount * -1,

            ]
        );
        Transaction::create(
            [
                'account_id'             => $toAccount->id,
                'transaction_journal_id' => $journal->id,
                'amount'                 => $amount,

            ]
        );
        $journal->categories()->save($category);
        $journal->budgets()->save($budget);

        return $journal;

    }

    /**
     * @param $name
     *
     * @return Bill|null
     */
    protected function findBill($name)
    {
        /** @var Bill $bill */
        foreach (Bill::get() as $bill) {
            if ($bill->name == $name && $this->user->id == $bill->user_id) {
                return $bill;
                break;
            }
        }

        return null;
    }

    /**
     * @param $name
     *
     * @return Budget|null
     */
    protected function findBudget($name)
    {
        /** @var Budget $budget */
        foreach (Budget::get() as $budget) {
            if ($budget->name == $name && $this->user->id == $budget->user_id) {
                return $budget;
                break;
            }
        }

        return null;
    }

    /**
     * @param $name
     *
     * @return Category|null
     */
    protected function findCategory($name)
    {

        /** @var Category $category */
        foreach (Category::get() as $category) {
            if ($category->name == $name && $this->user->id == $category->user_id) {
                return $category;
                break;
            }
        }

        return null;
    }

    /**
     * @param $name
     *
     * @return PiggyBank|null
     */
    protected function findPiggyBank($name)
    {

        /** @var Budget $budget */
        foreach (PiggyBank::get() as $piggyBank) {
            $account = $piggyBank->account()->first();
            if ($piggyBank->name == $name && $this->user->id == $account->user_id) {
                return $piggyBank;
                break;
            }
        }

        return null;
    }

    /**
     * @param $tagName
     *
     * @return Tag|null
     * @internal param $tag
     */
    protected function findTag($tagName)
    {
        /** @var Tag $tag */
        foreach (Tag::get() as $tag) {
            if ($tag->tag == $tagName && $this->user->id == $tag->user_id) {
                return $tag;
                break;
            }
        }

        return null;
    }


}
