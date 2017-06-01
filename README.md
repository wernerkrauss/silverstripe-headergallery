# silverstripe-headergallery
A very simple SilverStripe4 compatible module for a simple (header) gallery.


## Usage
in your templates you can use `$HeaderGallery` to get the gallery of the current Page

If you want fallback for parent pages or the home page you can use `$HeaderGalleryPics`

As this module adds a many-many relation to Page you can reuse Images on different Pages.


## Note
Sorting is currently broken as SortableRows is not SS4 ready yet.


## Todo
[ ] add GridfieldGalleryTheme when it's SS4 ready

[ ] add GridfieldSortableRows when it's SS4 ready

[ ] unit tests of course (at least for the fallback method)
