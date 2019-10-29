<?php
/**
 * Create an Item
 */
class sxNewsletterCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'sxNewsletter';
	public $classKey = 'sxNewsletter';
	public $languageTopics = array('sendex');
	public $permission = 'new_document';


	/**
	 * @return bool
	 */
    public function beforeSet() {

        $required = array('name');
        foreach ($required as $tmp) {
            if (!$this->getProperty($tmp)) {
                $this->addFieldError($tmp, $this->modx->lexicon('field_required'));
            }
        }
        if (!$this->getProperty('template') && !$this->getProperty('snippet')) {
            $this->addFieldError('template', $this->modx->lexicon('sendex_newsletter_err_template'));
            $this->addFieldError('snippet', $this->modx->lexicon('sendex_newsletter_err_snipppet'));
        }
        if ($this->hasErrors()) {
            return false;
        }

        $unique = array('name');
        foreach ($unique as $tmp) {
            if ($this->modx->getCount($this->classKey, array('name' => $this->getProperty($tmp)))) {
                $this->addFieldError($tmp, $this->modx->lexicon('sendex_newsletter_err_ae'));
            }
        }

        $active = $this->getProperty('active');
        $this->setProperty('active', !empty($active) && $active != 'false');

        return !$this->hasErrors();
    }

}

return 'sxNewsletterCreateProcessor';