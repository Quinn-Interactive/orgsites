<?php

use QuinnInteractive\Orgsite\Model\Event;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\Requirements;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event as ComponentsEvent;

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
        'ical',
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

    public function ical(): ?string
    {
        if (!$this->ICalendar) {
            return null;
        }
        
        $ical = Calendar::create($this->Title);
        $lastYear = date('Y-m-d', strtotime('1 year ago'));
        $events = $this->Events()->filter('Start:GreaterThan', $lastYear);
        foreach ($events as $event) {
            $entry = ComponentsEvent::create()
            ->name($event->Title)
            ->description($event->DescriptionOrSummary())
            ->uniqueIdentifier($event->ID)
            ->createdAt(new DateTime($event->Created))
            ->startsAt(new DateTime('6 march 2019 15:00'));
        
            if ($event->End) {
                $entry->endsAt(new DateTime($event->End));
            }
            if ($event->AllDay) {
                $entry->fullDay();
            }
            /** @var Image $image */
            $image = $event->FeaturedImage();
            if ($image && $image->exists() && $image->canView()) {
                $entry->image(Director::absoluteURL($image->getURL()));
            }
            $ical->event($entry);
        }
        $file = $ical->get();
        header('Content-type:application/pdf');
        header('Content-Disposition: attachment; filename="' . $this->URLSegment . '.ics"');
        header('Content-Length: ' . strlen($file));
        header('Connection: close');
        echo $file;
    }
}
