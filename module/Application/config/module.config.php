<?php

return [
    'router'          => [
        'routes' => [
            'home'        => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
            'get_registry_offices'        => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/get/registry_offices',
                    'defaults' => [
                        'controller' => 'Application\Controller\Registry',
                        'action'     => 'getAllRegistryOffices',
                    ],
                ]
            ],
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => [
                'type'          => 'Literal',
                'options'       => [
                    'route'    => '/application',
                    'defaults' => [
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'       => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults'    => [],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
        ],
        'aliases'   => [
            'translator' => 'MvcTranslator',
        ],
    ],
    'translator'      => [
        'locale'                    => 'pt_BR',
        'translation_file_patterns' => [
            [
                'type'     => 'PhpArray',
                'base_dir' => __DIR__ . '/../languages/',
                'pattern'  => '%s/Zend_Validate.php',
            ],
        ],
    ],
    'controllers'     => [
        'invokables' => [
            'Application\Controller\Index' => \Application\Controller\IndexController::class,
            'Application\Controller\Registry' => \Application\Controller\RegistryController::class,
        ],
    ],
    'view_helpers'    => [
        'invokables' => [

        ],
    ],
    'view_manager'    => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack'      => [
            __DIR__ . '/../view',
        ],
        'strategies'               => [
            'ViewJsonStrategy',
        ],
    ],
    'doctrine'        => [
        'driver' => [
            "Application_driver" => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__."/../src/Application/Entity"]
            ],
            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => 'Application_driver'
                ]
            ]
        ],
        'configuration' => [
            'orm_default' => [
                'datetime_functions' => [
                    'date'          => \DoctrineExtensions\Query\Mysql\Date::class,
                    'date_format'   => \DoctrineExtensions\Query\Mysql\DateFormat::class,
                    'dateadd'       => \DoctrineExtensions\Query\Mysql\DateAdd::class,
                    'datediff'      => \DoctrineExtensions\Query\Mysql\DateDiff::class,
                    'day'           => \DoctrineExtensions\Query\Mysql\Day::class,
                    'dayname'       => \DoctrineExtensions\Query\Mysql\DayName::class,
                    'last_day'      => \DoctrineExtensions\Query\Mysql\LastDay::class,
                    'minute'        => \DoctrineExtensions\Query\Mysql\Minute::class,
                    'second'        => \DoctrineExtensions\Query\Mysql\Second::class,
                    'strtodate'     => \DoctrineExtensions\Query\Mysql\StrToDate::class,
                    'time'          => \DoctrineExtensions\Query\Mysql\Time::class,
                    'timestampadd'  => \DoctrineExtensions\Query\Mysql\TimestampAdd::class,
                    'timestampdiff' => \DoctrineExtensions\Query\Mysql\TimestampDiff::class,
                    'week'          => \DoctrineExtensions\Query\Mysql\Week::class,
                    'weekday'       => \DoctrineExtensions\Query\Mysql\WeekDay::class,
                    'year'          => \DoctrineExtensions\Query\Mysql\Year::class,
                ],
                'numeric_functions'  => [
                    'acos'    => \DoctrineExtensions\Query\Mysql\Acos::class,
                    'asin'    => \DoctrineExtensions\Query\Mysql\Asin::class,
                    'atan2'   => \DoctrineExtensions\Query\Mysql\Atan2::class,
                    'atan'    => \DoctrineExtensions\Query\Mysql\Atan::class,
                    'cos'     => \DoctrineExtensions\Query\Mysql\Cos::class,
                    'cot'     => \DoctrineExtensions\Query\Mysql\Cot::class,
                    'hour'    => \DoctrineExtensions\Query\Mysql\Hour::class,
                    'pi'      => \DoctrineExtensions\Query\Mysql\Pi::class,
                    'power'   => \DoctrineExtensions\Query\Mysql\Power::class,
                    'quarter' => \DoctrineExtensions\Query\Mysql\Quarter::class,
                    'rand'    => \DoctrineExtensions\Query\Mysql\Rand::class,
                    'round'   => \DoctrineExtensions\Query\Mysql\Round::class,
                    'sin'     => \DoctrineExtensions\Query\Mysql\Sin::class,
                    'std'     => \DoctrineExtensions\Query\Mysql\Std::class,
                    'tan'     => \DoctrineExtensions\Query\Mysql\Tan::class,
                ],
                'string_functions'   => [
                    'binary'        => \DoctrineExtensions\Query\Mysql\Binary::class,
                    'char_length'   => \DoctrineExtensions\Query\Mysql\CharLength::class,
                    'concat_ws'     => \DoctrineExtensions\Query\Mysql\ConcatWs::class,
                    'countif'       => \DoctrineExtensions\Query\Mysql\CountIf::class,
                    'crc32'         => \DoctrineExtensions\Query\Mysql\Crc32::class,
                    'degrees'       => \DoctrineExtensions\Query\Mysql\Degrees::class,
                    'field'         => \DoctrineExtensions\Query\Mysql\Field::class,
                    'find_in_set'   => \DoctrineExtensions\Query\Mysql\FindInSet::class,
                    'group_concat'  => \DoctrineExtensions\Query\Mysql\GroupConcat::class,
                    'ifelse'        => \DoctrineExtensions\Query\Mysql\IfElse::class,
                    'ifnull'        => \DoctrineExtensions\Query\Mysql\IfNull::class,
                    'match_against' => \DoctrineExtensions\Query\Mysql\MatchAgainst::class,
                    'md5'           => \DoctrineExtensions\Query\Mysql\Md5::class,
                    'month'         => \DoctrineExtensions\Query\Mysql\Month::class,
                    'monthname'     => \DoctrineExtensions\Query\Mysql\MonthName::class,
                    'nullif'        => \DoctrineExtensions\Query\Mysql\NullIf::class,
                    'radians'       => \DoctrineExtensions\Query\Mysql\Radians::class,
                    'regexp'        => \DoctrineExtensions\Query\Mysql\Regexp::class,
                    'replace'       => \DoctrineExtensions\Query\Mysql\Replace::class,
                    'sha1'          => \DoctrineExtensions\Query\Mysql\Sha1::class,
                    'sha2'          => \DoctrineExtensions\Query\Mysql\Sha2::class,
                    'soundex'       => \DoctrineExtensions\Query\Mysql\Soundex::class,
                    'uuid_short'    => \DoctrineExtensions\Query\Mysql\UuidShort::class,
                    'date'          => \DoctrineExtensions\Query\Mysql\Date::class,
                    'date_format'   => \DoctrineExtensions\Query\Mysql\DateFormat::class,
                    'dateadd'       => \DoctrineExtensions\Query\Mysql\DateAdd::class,
                    'datediff'      => \DoctrineExtensions\Query\Mysql\DateDiff::class,
                    'day'           => \DoctrineExtensions\Query\Mysql\Day::class,
                    'dayname'       => \DoctrineExtensions\Query\Mysql\DayName::class,
                    'last_day'      => \DoctrineExtensions\Query\Mysql\LastDay::class,
                    'minute'        => \DoctrineExtensions\Query\Mysql\Minute::class,
                    'second'        => \DoctrineExtensions\Query\Mysql\Second::class,
                    'strtodate'     => \DoctrineExtensions\Query\Mysql\StrToDate::class,
                    'time'          => \DoctrineExtensions\Query\Mysql\Time::class,
                    'timestampadd'  => \DoctrineExtensions\Query\Mysql\TimestampAdd::class,
                    'timestampdiff' => \DoctrineExtensions\Query\Mysql\TimestampDiff::class,
                    'week'          => \DoctrineExtensions\Query\Mysql\Week::class,
                    'weekday'       => \DoctrineExtensions\Query\Mysql\WeekDay::class,
                    'year'          => \DoctrineExtensions\Query\Mysql\Year::class,
                ],
            ],
        ],
    ],
];
