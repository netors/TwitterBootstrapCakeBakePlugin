<?php
/**
 * Class BootstrapIconHelper
 *
 * from the old IconHelper I had, used to work with famfamfam icons..
 * it now became part of this Plugin..
 * Retrieves an appropriate icon by given mimetype or file extension.
 */
class BootstrapIconHelper extends AppHelper {

	var $name = 'BootstrapIcon';
    var $helpers = array('Html');

    /**
     * Path to fileicons in app/wwwroot/img/
     * @var String
     */
    var $pathFileicons = 'icons';

    function setFileiconsPath($pathFileicons) {
        $this->pathFileicons = $pathFileicons;
    }

    function get($type_or_ext, $extension = '') {
        $mimetype = '';

        // parse type_or_ext
        // if $extension is set, first param is interpreted as mimetype
        if (!empty($extension)) $mimetype = $type_or_ext;
        // else if first param contains slash it is interpreted as mimetype
        elseif (strpos($type_or_ext, '/') !== false)
            $mimetype = $type_or_ext;
        else
            $extension = $type_or_ext;

        $mediatype = $subtype = '';

        if (!empty($mimetype))
            list($mediatype, $subtype) = explode('/', $mimetype);

        if (substr($subtype,0,2) == 'x-') $subtype = substr($subtype,2);

        $try = array($subtype, $extension, $mediatype, 'file');

        foreach ($try as $name)
            if (!empty($name))
                if (($extension = $this->iconExists($name)) !== false)
                    return $this->Html->image($this->pathFileicons.DS.$name.'.$extension', array('alt'=>$name,'class'=>'icon'));
    }

    /**
     * Checks whether an icon of the given name exists in
     * folder pathFileicons. Tries out several extensions.
     * @param $name
     * @return mixed:
     * - false if no icon was found
     * - String $extension of the found icon
     *
     */
    private function iconExists($name) {
        $path = IMAGES . $this->pathFileicons . DS . $name;
        $extensions = array('png', 'gif', 'ico', 'jpg', 'jpeg');

        foreach($extensions as $extension)
            if (@file_exists($path . '.$extension'))
                return $extension;

        return false;
    }

	function css($name, $color = 'black') {
		return '<i class="icon-'.$name.' icon-'.$color.'"></i>';
	}

}
?>