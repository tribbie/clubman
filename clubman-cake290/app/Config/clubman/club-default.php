<?php
$config['Club'] = [
          'domain'    => 'clubman.be',
          'id'        => 'CMid',
          'name'      => 'Clubman',
          'longname'  => 'Club Management',
          'shortname' => 'CM',
          'motto'     => 'Help clubs',
          'metatags'  => 'club, sport',
          'favicon'   => 'favicon.ico',
          'logo'      => 'clubman_sports.png',
          'colors'    => [ '#333', '#999' ],
          'photoalbums' => [
            'baseurl' => 'https://goo.gl/photos/'
          ],
          'environment' => [
            'status'    => 'not-nologin',
            'base'      => 'nestorix',
            'mail'      => 'mailtrap',
            //'mail'      => 'smtp',
            //'database'  => 'default',
          ],
          'clubweb' => [
            'home'           => '/clubman-cake290',
            'theme'          => 'Clubweb-Basic',
            'bootstraptheme' => 'https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/spacelab/bootstrap.min.css'
          ],
          'clubman' => [
            'home'           => '.',
            'theme'          => 'Clubman',
            'bootstraptheme' => 'https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/spacelab/bootstrap.min.css'
          ],
          'clubmail'  => [
            'webmaster' => [
                'email' => 'webmaster@clubdomain.be',
                'name' => 'Club webmaster'
            ],
            'webmailer' => [
                'email' => 'webmailer@clubdomain.be',
                'name' => 'Club webmailer'
            ],
            'info' => [
                'email' => 'info@clubdomain.be',
                'name' => 'Club info'
            ],
            'subscriptions' => [
                'email' => 'subscriptions@clubdomain.be',
                'name' => 'Club subscriptions'
            ],
            'mailings' => [
                'email' => 'mailings@clubdomain.be',
                'name' => 'Club mailings'
            ],
            'clubman' => [
              'email' => 'clubman@clubdomain.be',
              'name' => 'Clubman'
            ]
          ]
];
