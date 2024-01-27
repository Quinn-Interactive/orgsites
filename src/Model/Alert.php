<?php

namespace QuinnInteractive\Orgsite\Model;

use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use Page;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\TreeMultiselectField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\TagField\TagField;
use SilverStripe\Versioned\GridFieldArchiveAction;
use SilverStripe\Versioned\Versioned;
use TractorCow\Fluent\Extension\FluentVersionedExtension;

/**
 * Class \QuinnInteractive\Orgsite\Model\Alert
 *
 * @property int $Version
 * @property string $Title
 * @property bool $Active
 * @property string $AlertStyle
 * @property string $Severity
 * @property string $NotificationType
 * @property string $Content
 * @property int $LinkID
 * @method \gorriecoe\Link\Models\Link Link()
 * @method \SilverStripe\ORM\ManyManyList|\Page[] Pages()
 * @mixin \SilverStripe\Versioned\Versioned
 * @mixin \TractorCow\Fluent\Extension\FluentVersionedExtension
 */
class Alert extends DataObject
{
    private static $belongs_many_many = [
        'Pages' => Page::class,
    ];
    private static $db = [
        'Title'            => 'Varchar(128)',
        'Active'           => 'Boolean',
        'AlertStyle'       => "Enum('alert, toast, modal','alert')",
        'Severity'         => "Enum('critical, warning, notice, success','warning')",
        'NotificationType' => "Enum('session, once, always','session')",
        'Content'          => 'HTMLText',
    ];
    private static $defaults = [
        'Severity'         => 'warning',
        'NotificationType' => 'session',
    ];
    private static $extensions = [
        Versioned::class,
        FluentVersionedExtension::class,
    ];
    private static $has_one = [
        'Link' => Link::class,
    ];
    private static $owns = [
        'Link',
    ];

    private static $plural_name = 'Alerts';
    private static $singular_name = 'Alert';
    private static $summary_fields = [
        'Title'            => 'Title',
        'Severity'         => 'Type',
        'NotificationType' => 'Notify',
        'AlertStyle'       => 'Style',
        'Active'           => 'Active?',
        'Pages.Count'      => '# of Pages',
    ];
    private static $table_name = 'Alert';
    private static $versioned_gridfield_extensions = true;

    public function AlertColor(): string
    {
        switch ($this->Severity) {
            //critical, warning, notice, success
            case 'critical':
                return 'danger';
            case 'warning':
                return 'warning';
            case 'success':
                return 'success';
            case 'notice':
            default:
                return 'info';
        }
    }

    public function canCreate($member = null, $context = [])
    {
        return (bool) Permission::check(['CMS_ACCESS']);
    }

    public function canDelete($member = null, $context = [])
    {
        return $this->canCreate();
    }

    public function canEdit($member = null, $context = [])
    {
        return $this->canCreate();
    }

    public function canView($member = null, $context = [])
    {
        return true;
    }

    public function CTA(): ?Link
    {
        if ($this->Link()->exists()) {
            /** @var Link */
            $link = $this->Link();
            $link->addExtraClass("btn btn-{$this->AlertColor()} btn-sm");
            return $link;
        }
        return null;
    }

    /**
     * @return false|string
     */
    public function getAlertJSON(): string|false
    {
        return json_encode([
            'id'        => hash('md5', "alert-{$this->ID}"),
            'type'      => $this->Severity,
            'notify'    => $this->NotificationType,
            'updated'   => $this->LastEdited,
            'sessionId' => hash('md5', session_id()),
        ]);
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['LinkID']);
        $fields->addFieldToTab('Root.Main', LinkField::create('Link', 'Call to Action', $this)->setDescription(_t(Page::class . '.OPTIONAL', 'Optional')));

        // AlertStyle
        $alertStyle = $fields->dataFieldByName('AlertStyle');
        $alertDescription = <<<EOT
            <ui>
                <li><strong>alert</strong>: Bands at the top of the page. Title and CTA only.</li>
                <li><strong>toast</strong>: Small messages at the bottom right of the page.</li>
                <li><strong>modal</strong>: Popup dialog. Only the first one will show on a page.</li>
            </ui>
        EOT;
        $alertStyle->setDescription($alertDescription);

        // Content
        $content = $fields->dataFieldByName('Content')->setDescription(_t(Page::class . '.OPTIONAL', 'Optional'));
        $content->displayIf('AlertStyle')->isNotEqualTo('alert');

        // Pages
        /** @var GridField */
        if ($this->isInDB()) {
            $fields->removeByName('Pages');
            $pages = TreeMultiselectField::create('Pages', 'On these pages', SiteTree::class);
            $fields->insertAfter('Link', $pages);
        }

        return $fields;
    }
}
