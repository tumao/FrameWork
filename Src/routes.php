<?php 
return 
[
	[
        ['GET'],
        '/',
        'App\Services\index@index'
    ],
    //create articles
    [
        ['POST'],
        '/articles',
        'App\Services\article@create'
    ],
    //delete articles
    [
        ['DELETE'],
        '/articles/{Id}',
        'App\Services\article@delArticleById'
    ],
    //articles list
    [
        ['GET'],
        '/articles',
        'App\Services\article@articlesList'
    ]
]