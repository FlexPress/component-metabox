<?php

namespace FlexPress\Components\MetaBox;

abstract class AbstractMetaBox
{

    /**
     *
     * Returns the title for the meta box
     *
     * @return mixed
     * @author Tim Perry
     *
     */
    abstract public function getTitle();

    /**
     *
     * Callback for the meta box used to output its content
     *
     * @return mixed
     * @author Tim Perry
     *
     */
    abstract public function getCallback();

    /**
     *
     * Callback for save post
     *
     * @param $postID
     * @return mixed
     * @author Tim Perry
     */
    abstract public function savePostCallback($postID);

    /**
     *
     * Returns an array of post types it should be shown on
     *
     * @return string
     * @author Tim Perry
     *
     */
    public function getSupportedPostTypes()
    {
        return array('page');
    }

    /**
     *
     * Returns the id for the meta box, defaults to the
     * namespace class name formatted with hyphens
     *
     * @return mixed
     * @author Tim Perry
     *
     */
    public function getID()
    {
        return str_replace("\\", "-", get_class($this));
    }

    /**
     *
     * Gets the context for the meta box, defaults to advanced
     *
     * @return string
     * @author Tim Perry
     *
     */
    public function getContext()
    {
        return 'advanced';
    }

    /**
     *
     * Returns the priority of the meta box, defaults to default
     *
     * @return string
     * @author Tim Perry
     *
     */
    public function getPriority()
    {
        return 'default';
    }

    /**
     *
     * Returns the callback args, defaults to null
     *
     * @return null
     * @author Tim Perry
     *
     */
    public function getCallbackArgs()
    {
        return null;
    }
}
