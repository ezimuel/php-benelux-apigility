<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Conference\\V1\\Rest\\Speaker\\SpeakerResource' => 'Conference\\V1\\Rest\\Speaker\\SpeakerResourceFactory',
            'Conference\\V1\\Rest\\Talk\\TalkResource' => 'Conference\\V1\\Rest\\Talk\\TalkResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'conference.rest.speaker' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/speaker[/:speaker_id]',
                    'defaults' => array(
                        'controller' => 'Conference\\V1\\Rest\\Speaker\\Controller',
                    ),
                ),
            ),
            'conference.rest.talk' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/talk[/:talk_id]',
                    'defaults' => array(
                        'controller' => 'Conference\\V1\\Rest\\Talk\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'conference.rest.speaker',
            1 => 'conference.rest.talk',
        ),
    ),
    'zf-rest' => array(
        'Conference\\V1\\Rest\\Speaker\\Controller' => array(
            'listener' => 'Conference\\V1\\Rest\\Speaker\\SpeakerResource',
            'route_name' => 'conference.rest.speaker',
            'route_identifier_name' => 'speaker_id',
            'collection_name' => 'speaker',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Conference\\V1\\Rest\\Speaker\\SpeakerEntity',
            'collection_class' => 'Conference\\V1\\Rest\\Speaker\\SpeakerCollection',
            'service_name' => 'Speaker',
        ),
        'Conference\\V1\\Rest\\Talk\\Controller' => array(
            'listener' => 'Conference\\V1\\Rest\\Talk\\TalkResource',
            'route_name' => 'conference.rest.talk',
            'route_identifier_name' => 'talk_id',
            'collection_name' => 'talk',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Conference\\V1\\Rest\\Talk\\TalkEntity',
            'collection_class' => 'Conference\\V1\\Rest\\Talk\\TalkCollection',
            'service_name' => 'Talk',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Conference\\V1\\Rest\\Speaker\\Controller' => 'HalJson',
            'Conference\\V1\\Rest\\Talk\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Conference\\V1\\Rest\\Speaker\\Controller' => array(
                0 => 'application/vnd.conference.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Conference\\V1\\Rest\\Talk\\Controller' => array(
                0 => 'application/vnd.conference.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Conference\\V1\\Rest\\Speaker\\Controller' => array(
                0 => 'application/vnd.conference.v1+json',
                1 => 'application/json',
            ),
            'Conference\\V1\\Rest\\Talk\\Controller' => array(
                0 => 'application/vnd.conference.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Conference\\V1\\Rest\\Speaker\\SpeakerEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'conference.rest.speaker',
                'route_identifier_name' => 'speaker_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Conference\\V1\\Rest\\Speaker\\SpeakerCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'conference.rest.speaker',
                'route_identifier_name' => 'speaker_id',
                'is_collection' => true,
            ),
            'Conference\\V1\\Rest\\Talk\\TalkEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'conference.rest.talk',
                'route_identifier_name' => 'talk_id',
                'hydrator' => 'Zend\\Hydrator\\ArraySerializable',
            ),
            'Conference\\V1\\Rest\\Talk\\TalkCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'conference.rest.talk',
                'route_identifier_name' => 'talk_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Conference\\V1\\Rest\\Speaker\\Controller' => array(
            'input_filter' => 'Conference\\V1\\Rest\\Speaker\\Validator',
        ),
        'Conference\\V1\\Rest\\Talk\\Controller' => array(
            'input_filter' => 'Conference\\V1\\Rest\\Talk\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Conference\\V1\\Rest\\Speaker\\Validator' => array(),
        'Conference\\V1\\Rest\\Talk\\Validator' => array(),
    ),
);
