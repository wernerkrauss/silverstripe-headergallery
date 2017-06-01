<?php

namespace Netwerkstatt\HeaderGallery\Extensions;


use Colymba\BulkUpload\BulkUploader;
use Netwerkstatt\HeaderGallery\Model\HeaderPicResource;
use Page;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ManyManyList;


class HeaderPicExtension extends DataExtension
{

    private static $many_many = [
        'HeaderGallery' => HeaderPicResource::class
    ];

    private static $many_many_extraFields = [
        'HeaderGallery' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $delete_permission = 'CMS_ACCESS_CMSMain';


    public function updateCMSFields(FieldList $fields)
    {

        $conf = GridFieldConfig_RelationEditor::create(10);
//        $conf->addComponent(new GridFieldSortableRows('SortOrder')); //@todo: update when module is SS4 ready
//        $conf->addComponent(new GridFieldGalleryTheme('Attachment'));//@todo: update when module is SS4 readygit
        $conf->addComponent(new BulkUploader());
        $conf->getComponentByType(BulkUploader::class)->setUfSetup('setFolderName', 'header');
        $fields->addFieldToTab(
            'Root.HeaderGalerie',
            Gridfield::create('HeaderGallery', 'Slideshow f&uuml;r Header', $this->owner->HeaderGallery(), $conf)
        );
    }

    /**
     * Method to get the HeaderGallery with fallback to parent pages or HomePage
     *
     * @return ManyManyList|null
     */
    public function getHeaderGalleryPics()
    {
        $owner = $this->owner;

        if (!$owner) {
            return;
        }

        if (isset($owner->ID) && $owner->HeaderGallery()->count() > 0) {
            return $owner->HeaderGallery();
        }

        $Parent = isset($owner->ID)
            ? $owner->Parent()
            : $Parent = $this->owner->Parent();

        if (is_object($Parent) && $Parent->ID != 0) {
            return $Parent->getHeaderGalleryPics();
        }

        //return Gallery of Home Page
        $home = Page::get()->filter(['URLSegment' => 'home'])->first();

        return $home ? $home->HeaderGallery() : null;
    }
}

