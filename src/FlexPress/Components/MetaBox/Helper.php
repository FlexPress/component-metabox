<?php

namespace FlexPress\Components\MetaBox;

class Helper
{

    /**
     * @var \SplObjectStorage
     */
    protected $metaBoxes;

    public function __construct(\SplObjectStorage $metaBoxes, array $metaBoxesArray)
    {
        $this->metaBoxes = $metaBoxes;

        if (!empty($metaBoxesArray)) {

            foreach ($metaBoxesArray as $metaBox) {

                if (!$metaBox instanceof AbstractMetaBox) {

                    $message = "One or more of the meta boxes you have passed to ";
                    $message .= get_class($this);
                    $message .= " does not extend the AbstractMetaBox class";

                    throw new \RuntimeException($message);

                }

                $this->metaBoxes->attach($metaBox);

            }

        }

    }

    /**
     *
     * Simply adds the action to register all the meta boxes
     * using WordPress' add_meta_box hook
     *
     * @author Tim Perry
     *
     */
    public function init()
    {
        add_action('add_meta_boxes', array($this, 'addMetaBoxes'));
        $this->setupSavePostActions();
    }

    /**
     *
     * Adds all the hooks to the save post actions
     * cannot be done when adding the meta boxes as that is too late
     *
     * @author Tim Perry
     *
     */
    protected function setupSavePostActions()
    {
        $this->metaBoxes->rewind();
        while ($this->metaBoxes->valid()) {

            $metaBox = $this->metaBoxes->current();
            add_action('save_post', array($metaBox, 'savePostCallback'));

            $this->metaBoxes->next();

        }
    }

    /**
     * Registers all the meta boxes added
     * @author Tim Perry
     */
    public function addMetaBoxes()
    {

        $this->metaBoxes->rewind();
        while ($this->metaBoxes->valid()) {

            $metaBox = $this->metaBoxes->current();

            foreach ($metaBox->getSupportedPostTypes() as $postType) {

                add_meta_box(
                    $metaBox->getID(),
                    $metaBox->getTitle(),
                    array(
                        $metaBox,
                        'getCallback'
                    ),
                    $postType,
                    $metaBox->getContext(),
                    $metaBox->getPriority(),
                    $metaBox->getCallbackArgs()
                );

                add_action('save_post', array($metaBox, 'savePostCallback'));

            }

            $this->metaBoxes->next();

        }

    }
}
