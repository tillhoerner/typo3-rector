<?php

namespace TYPO3\CMS\Extbase\Persistence\Generic\Qom;

if (interface_exists('TYPO3\CMS\Extbase\Persistence\Generic\Qom\AndInterface')) {
    return;
}

interface AndInterface extends ConstraintInterface
{
}
