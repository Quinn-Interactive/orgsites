<?php

use QuinnInteractive\Orgsite\Model\Event;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\PaginatedList;

/**
 * Class \CalendarController
 *
 * @property \QuinnInteractive\Orgsite\Page\Calendar $dataRecord
 * @method \QuinnInteractive\Orgsite\Page\Calendar data()
 * @mixin \QuinnInteractive\Orgsite\Page\Calendar
 */
class CalendarController extends PageController
{
    public bool $ShowPast = false;

    private static $allowed_actions = [
        'view',
    ];

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

    public function PastEvents(): DataList
    {
        return $this->Events()->filterAny([
            'Start:LessThan' => date('Y-m-d'),
        ])->Sort('Start', 'DESC');
    }

    public function UpcomingEvents(): DataList
    {
        return $this->Events()->filterAny([
            'Start:GreaterThanOrEqual' => date('Y-m-d'),
            'End:GreaterThanOrEqual'   => date('Y-m-d'),
        ])->Sort('Start', 'ASC');
    }

    public function view(HTTPRequest $r)
    {
        $id = $r->param('ID');
        /** @var Event */
        $event = $this->Events()->byID($id);
        if (!$event || !$this->canView()) {
            $this->redirect($this->Link());
        }
        $templates = array_merge($event->getViewerTemplates(), $this->getViewerTemplates());
        return $this->customise($event)->renderWith($templates);
    }

    protected function init()
    {
        parent::init();
        $this->ShowPast = $this->getRequest()->getVar('past') ? true : false;
    }
}
