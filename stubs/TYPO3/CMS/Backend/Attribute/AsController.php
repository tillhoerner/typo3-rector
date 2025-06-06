<?php

namespace TYPO3\CMS\Backend\Attribute;

if (class_exists('TYPO3\CMS\Backend\Backend\Attribute\AsController')) {
    return;
}

#[\Attribute(\Attribute::TARGET_CLASS)]
final class AsController
{
    public const TAG_NAME = 'backend.controller';

    public function __construct() {}
}
