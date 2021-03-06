<?php namespace FireflyIII\Events;

use FireflyIII\Models\TransactionJournal;
use Illuminate\Queue\SerializesModels;

/**
 * Class TransactionJournalUpdated
 *
 * @codeCoverageIgnore
 * @package FireflyIII\Events
 */
class TransactionJournalUpdated extends Event
{

    use SerializesModels;

    public $journal;

    /**
     * Create a new event instance.
     *
     * @param TransactionJournal $journal
     */
    public function __construct(TransactionJournal $journal)
    {
        //
        $this->journal = $journal;
    }

}
