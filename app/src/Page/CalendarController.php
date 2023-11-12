<?php

use SilverStripe\Dev\Debug;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\PaginatedList;

/**
 * Class \CalendarController
 *
 * @property \QI\App\Page\Calendar $dataRecord
 * @method \QI\App\Page\Calendar data()
 * @mixin \QI\App\Page\Calendar
 */
class CalendarController extends PageController
{
    public bool $ShowPast = false;

    protected function init()
    {
        parent::init();
        $this->ShowPast = $this->getRequest()->getVar('past') ? true : false;
    }

    public function UpcomingEvents(): DataList
    {
        return $this->Events()->filterAny([
            'Start:GreaterThanOrEqual' => date('Y-m-d'),
            'End:GreaterThanOrEqual' => date('Y-m-d'),
        ])->Sort('Start', 'ASC');
    }

    public function PastEvents(): DataList
    {
        return $this->Events()->filterAny([
            'Start:LessThan' => date('Y-m-d'),
        ])->Sort('Start', 'DESC');
    }

    /**
     * Returns a list of paginated blog posts based on the BlogPost dataList.
     *
     * @return PaginatedList
     */
    public function PaginatedList()
    {
        $events = $this->ShowPast ? $this->PastEvents() : $this->UpcomingEvents();
        $posts = PaginatedList::create($events);
        // Set appropriate page size
        if ($this->PostsPerPage > 0) {
            $pageSize = $this->PostsPerPage;
        } elseif ($count = $events->count()) {
            $pageSize = $count;
        } else {
            $pageSize = 99999;
        }
        $posts->setPageLength($pageSize);

        // Set current page
        $start = max(0, (int)$this->request->getVar($posts->getPaginationGetVar()));
        $posts->setPageStart($start);

        return $posts;
    }
}
