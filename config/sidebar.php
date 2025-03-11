<?php

return [
    'menu_items' => [
        // Dashboard
        [
            'icon' => 'bi bi-grid fs-2',
            'title' => 'Dashboards',
            'route_in' => 'dashboard.index',
            'submenu' => [
                [
                    'title' => 'Default',
                    'link' => 'dashboard.index',
                    'is_route' => true,
                    'icon' => 'bi bi-house fs-2'
                ]
            ]
        ],

        // Section Title
        [
            'is_heading' => true,
            'title' => "Web Pages",
        ],

        // User Profile Menu
        [
            'icon' => 'bi bi-person-lines-fill fs-2',
            'title' => 'User',
            'route_in' => 'dashboard.users.*',
            'submenu' => [
                [
                    'title' => 'Overview',
                    'link' => 'dashboard.users.index',
                    'is_route' => true,
                    'icon' => 'bi bi-person fs-2'
                ],
                [
                    'title' => 'Instructors',
                    'link' => 'dashboard.users.instructors.index',
                    'is_route' => true,
                    'icon' => 'bi bi-person-video3 fs-2'
                ],
            ]
        ],

        [
            'icon' => 'bi bi-journals fs-2',
            'title' => 'Courses',
            'route_in' => 'dashboard.courses.*',
            'submenu' => [
                [
                    'title' => 'Overview',
                    'link' => 'dashboard.courses.index',
                    'is_route' => true,
                    'icon' => 'bi bi-book fs-2'
                ],
                [
                    'title' => "Extensions",
                    'link' => 'dashboard.courses.extensions.index',
                    'is_route' => true,
                    'icon' => 'bi bi-bookmarks fs-2'
                ],
                [
                    'title' => "Resources",
                    'link' => 'dashboard.courses.resources.index',
                    'is_route' => true,
                    'icon' => 'bi bi-file-earmark-text fs-2'
                ],
                [
                    'title' => "Related Channels",
                    'link' => 'dashboard.courses.relatedChannels.index',
                    'is_route' => true,
                    'icon' => 'bi bi-link fs-2'
                ],
                [
                    'title' => "Lessons",
                    'link' => 'dashboard.courses.lessons.index',
                    'is_route' => true,
                    'icon' => 'bi bi-journal-code fs-2'
                ],
                [
                    'title' => "Documents",
                    'link' => 'dashboard.courses.documents.index',
                    'is_route' => true,
                    'icon' => 'bi bi-journal-bookmark fs-2'
                ]
            ]
        ],

        [
            'icon' => 'bi bi-braces-asterisk fs-2',
            'title' => 'Quiz',
            'route_in' => 'dashboard.quiz.*',
            'submenu' => [
                [
                    'title' => 'Overview',
                    'link' => 'dashboard.quiz.overview.index',
                    'is_route' => true,
                    'icon' => 'bi bi-cup fs-2'
                ],
                [
                    'title' => 'Question Bank',
                    'icon' => 'bi bi-question-circle fs-2',
                    'route_in' => 'dashboard.quiz.questions.*',
                    'submenu' => [
                        [
                            'title' => 'Question',
                            'link' => 'dashboard.quiz.questions.overview.index',
                            'is_route' => true,
                            'icon' => 'bi bi-patch-question fs-2'
                        ],
                        [
                            'title' => 'Answer',
                            'link' => 'dashboard.quiz.questions.answers.index',
                            'is_route' => true,
                            'icon' => 'bi bi-check-circle fs-2'
                        ],
                        [
                            'title' => 'Responses',
                            'link' => 'dashboard.quiz.questions.responses.index',
                            'is_route' => true,
                            'icon' => 'bi bi-check2-circle fs-2'
                        ],
                        [
                            'title' => 'Categories',
                            'link' => 'dashboard.quiz.questions.categories.index',
                            'is_route' => true,
                            'icon' => 'bi bi-tag-fill fs-2'
                        ]
                    ]
                ],
                [
                    'title' => 'Attempts',
                    'link' => 'dashboard.quiz.attempts.index',
                    'is_route' => true,
                    'icon' => 'bi bi-check2-circle fs-2'
                ],
                [
                    'title' => 'Time Settings',
                    'link' => 'dashboard.quiz.durations.index',
                    'is_route' => true,
                    'icon' => 'bi bi-clock fs-2'
                ],
                [
                    'title' => 'Difficulty Levels',
                    'link' => 'dashboard.quiz.difficultylevels.index',
                    'is_route' => true,
                    'icon' => 'bi bi-boxes fs-2'
                ]
            ]
        ],

        [
            'is_heading' => true,
            'title' => 'Privileges',
        ],
        // privileges
        [
            'icon' => 'bi bi-lock fs-2',
            'title' => 'Roles',
            'route_in' => 'dashboard.roles.*',
            'submenu' => [
                [
                    'title' => 'Overview',
                    'link' => 'dashboard.roles.index',
                    'is_route' => true,
                    'icon' => 'bi bi-body-text fs-2'
                ],
                [
                    'title' => 'User Role',
                    'link' => 'dashboard.roles.users.index',
                    'is_route' => true,
                    'icon' => 'bi bi-person-lock fs-2'
                ]
            ]
        ],

        // permissions
        [
            'icon' => 'bi bi-shield-check fs-2',
            'title' => 'Permissions',
            'route_in' => 'dashboard.permissions.*',
            'submenu' => [
                [
                    'title' => 'Overview',
                    'link' => 'dashboard.permissions.index',
                    'is_route' => true,
                    'icon' => 'bi bi-body-text fs-2'
                ],
                [
                    'title' => 'User Permissions',
                    'link' => 'dashboard.permissions.users.index',
                    'is_route' => true,
                    'icon' => 'bi bi-person-lock fs-2'
                ]
            ]
        ]

    ]
];
