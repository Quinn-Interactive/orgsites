<?php

use Psr\SimpleCache\CacheInterface;
use QuinnInteractive\Orgsite\Model\Event;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Flushable;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\PaginatedList;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event as ComponentsEvent;
use Spatie\IcalendarGenerator\Components\Timezone;

/**
 * Class \CalendarController
 *
 * @property \QuinnInteractive\Orgsite\Page\Calendar $dataRecord
 * @method \QuinnInteractive\Orgsite\Page\Calendar data()
 * @mixin \QuinnInteractive\Orgsite\Page\Calendar
 */
class CalendarController extends PageController implements Flushable
{
    public bool $ShowPast = false;

    private static $allowed_actions = [
        'event',
        'event_ical',
        'ical',
    ];

    public function ical(): void
    {
        if (!$this->ICalendar) {
            return;
        }

        $cache = self::get_cache();
        $key = $this->getCalendarClearKey();
        if ($key && $cache && $cache->has($key)) {
            $file = $cache->get($key);
        } else {
            $ical = Calendar::create($this->Title);
            if ($this->Timezone) {
                $timezone = Timezone::create($this->Title);
                $ical->timezone($timezone);
            } else {
                $ical->withoutTimezone();
            }
            $lastYear = date('Y-m-d', strtotime('1 year ago'));
            $events = $this->Events()->filter('Start:GreaterThan', $lastYear);
            foreach ($events as $event) {
                $ical->event($event->iCal());
            }
            $file = $ical->get();
            $cache->set($key, $file);
        }

        header('Content-type:application/pdf');
        header('Content-Disposition: attachment; filename="' . $this->URLSegment . '.ics"');
        header('Content-Length: ' . strlen($file));
        header('Connection: close');
        echo $file;
    }

    /**
     * Returns a list of paginated blog posts based on the BlogPost dataList.
     *ac
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

    public function event(HTTPRequest $r)
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

    public function event_ical(HTTPRequest $r): mixed
    {
        $id = $r->param('ID');
        if (!$id) {
            return $this->redirect($this->Link());
        }
        if (!$this->ICalendar) {
            return $this->redirect($this->Link());
        }
        
        /** @var Event */
        $event = $this->Events()->byID($id);
        if (!$event || !$this->canView()) {
            return $this->redirect($this->Link());
        }

        $cache = self::get_cache();
        $key = $this->getCalendarClearKey('event-' . $event->ID);
        if ($key && $cache && $cache->has($key)) {
            $file = $cache->get($key);
        } else {
            $ical = Calendar::create($this->Title);
            if ($this->Timezone) {
                $timezone = Timezone::create($this->Title);
                $ical->timezone($timezone);
            } else {
                $ical->withoutTimezone();
            }
            $ical->event($event->iCal());
            $file = $ical->get();
            $cache->set($key, $file);
        }

        header('Content-type:application/pdf');
        header('Content-Disposition: attachment; filename="' . $event->getSlug() . '.ics"');
        header('Content-Length: ' . strlen($file));
        header('Connection: close');
        echo $file;
        return null;
    }

    protected function init()
    {
        parent::init();
        $this->ShowPast = $this->getRequest()->getVar('past') ? true : false;
    }

    public static function flush()
    {
        $cache = self::get_cache();
        $cache->clear();
    }

    private static function get_cache()
    {
        return Injector::inst()->get(CacheInterface::class . '.calendarCache');
    }

    public function getCalendarClearKey($name = 'calendar'): ?string
    {
        return "$name-{$this->ID}-" . hash('md5', $this->ClearKey('Calendar'));
    }

}
