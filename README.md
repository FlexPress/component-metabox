# FlexPress metabox component

## Install via Pimple
The metabox component uses two classes
- AbstractMetaBox - Used to create the meta boxes
- Helper - Used to register the meta boxes

Lets create the pimple config for the metabox and helper:

```
$pimple['helloWorldMetaBox'] = function() {
  return new HelloWorld();
};

$pimple['metaBoxHelper'] = function ($c) {
    return new MetaBoxHelper($c['objectStorage'], array(
        $c['pageTypeMetaBox']
    ));
};
```

Note the objectStorage is the SPLObjectStorage class.

## Creating a concreate class that extends the AbstractMetaBox class

You need to create a class that extends the AbstractMetaBox, which means implementing the methods, so lets create that now:
```
class HelloWorld extends AbstractMetaBox {

    public function getTitle()
    {
        return "Hello world"
    }

    public function getCallback()
    {
        echo "<p>Hello world</p>";
    }

    public function savePostCallback($postID)
    {
        update_post_meta($postID, "fp_hello_world", time());
    }
}
```

This is the bare minimum of what you must implement, the next example it the other extreme, implementing all available methods:

```
class HelloWorld extends AbstractMetaBox {

    public function getTitle()
    {
        return "Hello world"
    }

    public function getCallback()
    {
        echo "<p>Hello world</p>";
    }

    public function savePostCallback($postID)
    {
        update_post_meta($postID, "fp_hello_world", time());
    }

    public function getSupportedPostTypes()
    {
        return array('page', 'post');
    }

    public function getID()
    {
        return "helloWorldMetaBox";
    }

    public function getContext()
    {
        return 'side';
    }

    public function getPriority()
    {
        return 'high';
    }

    public function getCallbackArgs()
    {
        return null;
    }

}
```

## Usage
Once you have setup the pimple config you are able to use the MetaBoxHelper like this:

$helper = $pimple['metaBoxHelper'];
$helper->init();

## Public methods - helper
- init() - Adds the hook to be able to register the metaboxes and setup the save_post hooks.
- addMetaBoxes() - Adds all the metaboxes added to the helper.

## Protected methods - helper
- setupSavePostActions() - Used to add the save_post hooks, used by the public init method.

## Public methods - AbstractMetaBox
- getTitle() - Title of the edit screen section, visible to user.
- getCallback() - Used to output the metabox.
- savePostCallback($postID) - This is called when the save_post hook is called, you are passed the postID so you can save your metabox.
- getSupportedPostTypes() - The type of Write screen on which to show the edit screen section.
- getID() - HTML 'id' attribute of the edit screen section
- getContext() - The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side').
- getPriority() - The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
- getCallbackArgs() - Arguments to pass into your callback function. The callback will receive the $post object and whatever parameters are passed through this variable.
