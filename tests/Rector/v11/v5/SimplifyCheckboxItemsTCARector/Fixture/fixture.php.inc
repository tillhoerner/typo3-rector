<?php

namespace Ssch\TYPO3Rector\Tests\Rector\v11\v5\SimplifyCheckboxItemsTCARector\Fixture;

return [
    'ctrl' => [],
    'columns' => [
        'workspace_perms' => [
            'exclude' => 1,
            'label' => 'workspace_perms',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
                'items' => [
                    [
                        0 => 'label',
                        1 => '',
                    ],
                ],
            ],
        ],
        'enabled' => [
            'label' => 'enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ],
                ],
            ],
        ],
        'hidden' => [
            'label' => 'hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'leave_as_is' => [
            'label' => 'Leave as is!',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        'label' => 'Enabled/Disabled',
                        'labelChecked' => 'Enabled',
                        'labelUnchecked' => 'Disabled',
                    ],
                ],
            ],
        ],
        'simpleCheckboxConfig' => [
            'label' => 'simpleCheckboxConfig',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    0 => [
                        'foo',
                        'bar',
                    ],
                ],
            ],
        ],
        'toggleCheckboxConfig' => [
            'label' => 'toggleCheckboxConfig',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    0 => [
                        'foo',
                        'bar',
                        'labelChecked' => 'Enabled',
                        'labelUnchecked' => 'Disabled',
                    ],
                ],
            ],
        ],
        'inverted_toggleCheckboxConfig' => [
            'label' => 'inverted_toggleCheckboxConfig',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    0 => [
                        'foo',
                        'bar',
                        'labelChecked' => 'Enabled',
                        'labelUnchecked' => 'Disabled',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
    ],
];
?>
-----
<?php

namespace Ssch\TYPO3Rector\Tests\Rector\v11\v5\SimplifyCheckboxItemsTCARector\Fixture;

return [
    'ctrl' => [],
    'columns' => [
        'workspace_perms' => [
            'exclude' => 1,
            'label' => 'workspace_perms',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
                'items' => [
                    [
                        0 => 'label',
                    ],
                ],
            ],
        ],
        'enabled' => [
            'label' => 'enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],
        'hidden' => [
            'label' => 'hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        0 => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'leave_as_is' => [
            'label' => 'Leave as is!',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        'label' => 'Enabled/Disabled',
                        'labelChecked' => 'Enabled',
                        'labelUnchecked' => 'Disabled',
                    ],
                ],
            ],
        ],
        'simpleCheckboxConfig' => [
            'label' => 'simpleCheckboxConfig',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    0 => [
                        0 => 'foo',
                    ],
                ],
            ],
        ],
        'toggleCheckboxConfig' => [
            'label' => 'toggleCheckboxConfig',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    0 => [
                        'foo',
                        'labelChecked' => 'Enabled',
                        'labelUnchecked' => 'Disabled',
                    ],
                ],
            ],
        ],
        'inverted_toggleCheckboxConfig' => [
            'label' => 'inverted_toggleCheckboxConfig',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    0 => [
                        'foo',
                        'bar',
                        'labelChecked' => 'Enabled',
                        'labelUnchecked' => 'Disabled',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
    ],
];
?>
