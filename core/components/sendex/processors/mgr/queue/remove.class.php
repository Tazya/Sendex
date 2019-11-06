<?php
/**
 * Remove a newsletter
 */
class sxQueueRemoveProcessor extends modObjectRemoveProcessor {
    public $checkRemovePermission = true;
    public $objectType = 'sxQueue';
    public $classKey = 'sxQueue';
    public $languageTopics = array('sendex');

}

return 'sxQueueRemoveProcessor';