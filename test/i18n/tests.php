<?php

use welcome\components\i18n\Translator;

function eq($a, $b)
{
    if ($a !== $b) {
        throw new \Exception('False');
    }
}

function itemInOut(Translator $t) {
    $t->setAlias('social.home', '@social')->useAlias('@social');
    eq($t->t('foo.bar'), 'Social Foo Bar');
    $t->setAlias('home', '@home')->useAlias('@home');
    eq($t->t('foo.bar'), 'FooBar');
}

function changesAliases(Translator $t)
{
    $t->setAlias('social.home', '@social');
    eq($t->t('foo.bar', '@social'), 'Social Foo Bar');
    $t->setAlias('social.home');
    eq($t->t('foo.bar', '@social'), 'Social Foo Bar');
    eq($t->t('foo.bar'), 'Social Foo Bar');
    $t->setAlias('home');
    eq($t->t('foo.bar'), 'FooBar');
    eq($t->t('foo.bar', '@social'), 'Social Foo Bar');
    $t->useAlias('@social');
    eq($t->t('foo.bar'), 'Social Foo Bar');
}

function commons(Translator $t)
{
    $t->setAlias('social.home', '@social')->useAlias('@social');
    eq($t->t('maroow.tree'), 'Haskey tree marrow');
    $t->setAlias('home', '@home')->useAlias('@home');
    eq($t->t('maroow.tree'), 'Haskey tree marrow in general');
    $t->useAlias('@social');
    eq($t->t('maroow.tree'), 'Haskey tree marrow');
    eq($t->t('maroow.tree'), 'Haskey tree marrow');
    $t->useAlias('@home');
    eq($t->t('maroow.tree'), 'Haskey tree marrow in general');
}

function switches(Translator $t)
{
    $t->setAlias('social.home', '@social')->useAlias('@social');
    eq($t->t('title'), 'Social Haskey');
    eq($t->t('foo.bar'), 'Social Foo Bar');
    eq($t->t('title'), 'Social Haskey');
    eq($t->t('env'), 'Haskey Environment');
    eq($t->t('title'), 'Social Haskey');
    $t->setAlias('home', '@home')->useAlias('@home');
    eq($t->t('env'), 'Haskey Environment');
    $t->setAlias('errors', '@errors')->useAlias('@errors');
    eq($t->t('env'), 'Haskey Environment');
    eq($t->t('image.size_small'), 'Picture is so small');
    eq($t->t('env'), 'Haskey Environment');
    $t->setAlias('social.home', '@social')->useAlias('@social');
    eq($t->t('env'), 'Haskey Environment');
}

function changes(Translator $t)
{
    $t->setAlias('home', '@home')->useAlias('@home');
    eq($t->t('reclame.info.title'), 'Select us now!');
    eq($t->t('ca.cb'), 'CAB');
    $t->setAlias('errors', '@errors')->useAlias('@errors');
    eq($t->t('ca.cb'), 'CAB');
    $t->setAlias('social.home', '@social')->useAlias('@social');
    eq($t->t('ca.cb'), 'CAB');
}