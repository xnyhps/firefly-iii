<?php

namespace FireflyIII\Support\Search;


use Auth;
use FireflyIII\Models\Budget;
use FireflyIII\Models\Category;
use FireflyIII\Models\TransactionJournal;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;

/**
 * Class Search
 *
 * @package FireflyIII\Search
 */
class Search implements SearchInterface
{
    /**
     * @param array $words
     *
     * @return Collection
     */
    public function searchAccounts(array $words)
    {
        return Auth::user()->accounts()->with('accounttype')->where(
            function (EloquentBuilder $q) use ($words) {
                foreach ($words as $word) {
                    $q->orWhere('name', 'LIKE', '%' . e($word) . '%');
                }
            }
        )->get();
    }

    /**
     * @param array $words
     *
     * @return Collection
     */
    public function searchBudgets(array $words)
    {
        /** @var Collection $set */
        $set    = Auth::user()->budgets()->get();
        $newSet = $set->filter(
            function (Budget $b) use ($words) {
                $found = 0;
                foreach ($words as $word) {
                    if (!(strpos(strtolower($b->name), strtolower($word)) === false)) {
                        $found++;
                    }
                }

                return $found > 0;
            }
        );

        return $newSet;
    }

    /**
     * @param array $words
     *
     * @return Collection
     */
    public function searchCategories(array $words)
    {
        /** @var Collection $set */
        $set    = Auth::user()->categories()->get();
        $newSet = $set->filter(
            function (Category $c) use ($words) {
                $found = 0;
                foreach ($words as $word) {
                    if (!(strpos(strtolower($c->name), strtolower($word)) === false)) {
                        $found++;
                    }
                }

                return $found > 0;
            }
        );

        return $newSet;
    }

    /**
     *
     * @param array $words
     *
     * @return Collection
     */
    public function searchTags(array $words)
    {
        return new Collection;
    }

    /**
     * @param array $words
     *
     * @return Collection
     */
    public function searchTransactions(array $words)
    {
        // decrypted transaction journals:
        $decrypted = Auth::user()->transactionjournals()->withRelevantData()->where('encrypted', 0)->where(
            function (EloquentBuilder $q) use ($words) {
                foreach ($words as $word) {
                    $q->orWhere('description', 'LIKE', '%' . e($word) . '%');
                }
            }
        )->get();

        // encrypted
        $all      = Auth::user()->transactionjournals()->withRelevantData()->where('encrypted', 1)->get();
        $set      = $all->filter(
            function (TransactionJournal $journal) use ($words) {
                foreach ($words as $word) {
                    $haystack = strtolower($journal->description);
                    $word     = strtolower($word);
                    if (!(strpos($haystack, $word) === false)) {
                        return $journal;
                    }
                }

                return null;

            }
        );
        $filtered = $set->merge($decrypted);
        $filtered = $filtered->sortBy(
            function (TransactionJournal $journal) {
                return intval($journal->date->format('U'));
            }
        );

        $filtered = $filtered->reverse();

        return $filtered;
    }
} 
