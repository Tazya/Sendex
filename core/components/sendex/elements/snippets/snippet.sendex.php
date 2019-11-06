<?php
/** @var array $scriptProperties */
/** @var Sendex $Sendex */

$Sendex = $modx->getService('sendex','Sendex',$modx->getOption('sendex_core_path',null,$modx->getOption('core_path').'components/sendex/').'model/sendex/',$scriptProperties);
if (!($Sendex instanceof Sendex)) return '';

/** @var pdoTools $pdoTools */
$pdoTools = $modx->getService('pdoTools');

if (!($Sendex instanceof Sendex) || !($pdoTools instanceof pdoTools)) return '';

if (!$modx->user->isAuthenticated($modx->context->key)) {
	return $modx->lexicon('sendex_err_auth_req');
} elseif (empty($id) || !$newsletter = $modx->getObject('sxNewsletter', $id)) {
	return $modx->lexicon('sendex_newsletter_err_ns');
}

/** @var sxNewsletter $newsletter */
if (!$newsletter->active && empty($showInactive)) {
	return $modx->lexicon('sendex_newsletter_err_disabled');
}

if ($newsletter->isSubscribed($modx->user->id)) {
	return !empty($tplUnsubscribeForm)
	? $pdoTools->getChunk($tplUnsubscribeForm, $newsletter->toArray())
	: 'Parameter "tplUnsubscribeForm" is empty';
}
elseif (!$newsletter->isSubscribed($modx->user->id)) {
	return !empty($tplSubscribeForm)
	? $pdoTools->getChunk($tplSubscribeForm, $newsletter->toArray())
	: 'Parameter "tplSubscribeForm" is empty'; 
}

/**
 * Do your snippet code here. This demo grabs 5 items from our custom table.
 */
$tpl = $modx->getOption('tpl',$scriptProperties,'Item');
$sortBy = $modx->getOption('sortBy',$scriptProperties,'name');
$sortDir = $modx->getOption('sortDir',$scriptProperties,'ASC');
$limit = $modx->getOption('limit',$scriptProperties,5);
$outputSeparator = $modx->getOption('outputSeparator',$scriptProperties,"\n");

/* build query */
$c = $modx->newQuery('SendexItem');
$c->sortby($sortBy,$sortDir);
$c->limit($limit);
$items = $modx->getCollection('SendexItem',$c);

/* iterate through items */
$list = array();
/* @var SendexItem $item */
foreach ($items as $item) {
	$itemArray = $item->toArray();
	$list[] = $Sendex->getChunk($tpl,$itemArray);
}

/* output */
$output = implode($outputSeparator,$list);
$toPlaceholder = $modx->getOption('toPlaceholder',$scriptProperties,false);
if (!empty($toPlaceholder)) {
	/* if using a placeholder, output nothing and set output to specified placeholder */
	$modx->setPlaceholder($toPlaceholder,$output);
	return '';
}
/* by default just return output */
return $output;