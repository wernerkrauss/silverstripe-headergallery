<?php

namespace Netwerkstatt\HeaderGallery\Model;


use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FileHandleField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;


/**
 * Class HeaderPicRessource
 */
class HeaderPicResource extends DataObject
{


    private static $db = [
        'Title' => 'Text',
        'Content' => 'HTMLText'
    ];

    private static $has_one = [
        'Attachment' => Image::class, //Needs to be an image
    ];

    private static $belongs_many_many = [
        'ResourcePage' => 'Page'
    ];


    private static $default_sort = 'SortOrder ASC';

    private static $delete_permission = "CMS_ACCESS_CMSMain";

    private static $translate = ['Title', 'Content'];

    public function getCMSFields()
    {
        $fields = new FieldList(
            TextField::create('Title', 'Titel')->setDescription('Nur für das Backend'),
            new HtmlEditorField('Content', 'Inhalt'),

            $imageField = Injector::inst()->create(FileHandleField::class, 'Attachment')
        );
        /** @var UploadField $imageField */
        $imageField
            ->setAllowedFileCategories('image/supported')
            ->setFolderName('header');

        $this->extend('updateCMSFields', $fields);

        return $fields;

    }

    public function canDelete($member = null)
    {
        return Permission::check($this->stat('delete_permission'));
    }

    public function canView($member = null)
    {
        return true;
    }

    public function canCreate($member = null, $context = [])
    {
        return Permission::check($this->stat('delete_permission'));
    }

    public function canEdit($member = null)
    {
        return Permission::check($this->stat('delete_permission'));
    }
}
