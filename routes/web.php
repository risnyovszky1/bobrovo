<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --------
// | PagesController / General pages
// --------

Route::get('/', [
  'uses' => 'PagesController@getHomePage',
  'as' => 'homepage'
]);

Route::post('/', [
  'uses' => 'PagesController@postHomePage',
  'as' => 'homepage'
]);

Route::get('/registracia', [
  'uses' => 'PagesController@getRegisterPage',
  'as' => 'register'
]);

Route::post('/registracia', [
  'uses' => 'PagesController@postRegisterPage',
  'as' => 'register'
]);

Route::get('/novinky', [
  'uses' => 'PagesController@getNewsPage',
  'as' => 'newspage'
]);
Route::get('/novinky/{id}', [
  'uses' => 'PagesController@getNewsOnePage',
  'as' => 'newsonepage'
])->where('id', '[0-9]+');;

Route::get('/vseobecne-podmienky', [
  'uses' => 'PagesController@getDefaultConditionPage',
  'as' => 'default_cond'
]);

Route::get('/faq', [
  'uses' => 'PagesController@getFAQPage',
  'as' => 'faq'
]);



// --------
// | TestController / Pages for students
// --------

Route::get('/prihlasenie-student', [
  'uses' => 'TestController@getLoginStudentPage',
  'as' => 'login_student',
]);





// --------
// | BobrovoController / admin pages
// --------

Route::get('/prihlasenie-ucitel', [
  'uses' => 'BobrovoController@getLoginTeacherPage',
  'as' => 'login_teacher',
  'middleware' => 'guest'
]);

Route::post('/prihlasenie-ucitel', [
  'uses' => 'BobrovoController@postLoginTeacherPage',
  'as' => 'login_teacher',
  'middleware' => 'guest'
]);


Route::group(['prefix' => 'ucitel', 'middleware'=>'auth'], function(){
  Route::get('/', [
    'uses' => 'BobrovoController@getUcitelAdminPage',
    'as' => 'admin'
  ]);
  Route::get('/odhlasit', [
    'uses' => 'BobrovoController@getLogut',
    'as' => 'logout'
  ]);

  Route::get('/nespravny-link', [
    'uses' => 'BobrovoController@getBadLinkPage',
    'as' => 'badlink'
  ]);

  Route::group(['prefix' => 'novinky'], function(){
    Route::get('/', [
      'uses' => 'BobrovoController@getAllNewsPage',
      'as' => 'news.all'
    ]);

    Route::get('/pridaj', [
      'uses' => 'BobrovoController@getAddNewsPage',
      'as' => 'news.addnew'
    ]);
    Route::post('/pridaj', [
      'uses' => 'BobrovoController@postAddNewsPage',
      'as' => 'news.addnew'
    ]);

    Route::get('/upravit/{news_id}', [
      'uses' => 'BobrovoController@getEditNewsPage',
      'as' => 'news.edit'
    ])->where('nesw_id', '[0-9]+');
    Route::post('/upravit/{news_id}', [
      'uses' => 'BobrovoController@postEditNewsPage',
      'as' => 'news.edit'
    ])->where('nesw_id', '[0-9]+');

    Route::get('/vymazat/{news_id}', [
      'uses' => 'BobrovoController@getDeleteNews',
      'as' => 'news.delete'
    ])->where('nesw_id', '[0-9]+');
  });


  Route::group(['prefix' => 'faq'], function(){
    Route::get('/', [
      'uses' => 'BobrovoController@getAllFAQPage',
      'as' => 'faq.all'
    ]);

    Route::get('/pridaj', [
      'uses' => 'BobrovoController@getAddFAQPage',
      'as' => 'faq.addnew'
    ]);
    Route::post('/pridaj', [
      'uses' => 'BobrovoController@postAddFAQPage',
      'as' => 'faq.addnew'
    ]);

    Route::get('/upravit/{id}', [
      'uses' => 'BobrovoController@getEditFAQPage',
      'as' => 'faq.edit'
    ])->where('id', '[0-9]+');
    Route::post('/upravit/{id}', [
      'uses' => 'BobrovoController@postEditFAQPage',
      'as' => 'faq.edit'
    ])->where('id', '[0-9]+');

    Route::get('/vymazat/{id}', [
      'uses' => 'BobrovoController@getDeleteFAQ',
      'as' => 'faq.delete'
    ])->where('id', '[0-9]+');
  });


  Route::group(['prefix' => 'spravy'], function(){
    Route::get('/', [
      'uses' => 'BobrovoController@getMessagesPage',
      'as' => 'msg.all'
    ]);
    Route::get('/poslat', [
      'uses' => 'BobrovoController@getSendMessagePage',
      'as' => 'msg.send'
    ]);
    Route::post('/poslat', [
      'uses' => 'BobrovoController@postSendMessagePage',
      'as' => 'msg.send'
    ]);

    Route::get('/posta/{id}', [
      'uses' => 'BobrovoController@getOneMessagePage',
      'as' => 'msg.one'
    ])->where('id', '[0-9]+');

    Route::get('/odpovedat/{id}', [
      'uses' => 'BobrovoController@getAnswerPage',
      'as' => 'msg.answer'
    ])->where('id', '[0-9]+');
    Route::post('/odpovedat/{id}', [
      'uses' => 'BobrovoController@postAnswerPage',
      'as' => 'msg.answer'
    ])->where('id', '[0-9]+');

    Route::get('/vymazat/{id}', [
      'uses' => 'BobrovoController@getDeleteMessagePage',
      'as' => 'msg.delete'
    ])->where('id', '[0-9]+');
  });

  
  Route::group(['prefix' => 'skupiny'], function(){
    Route::get('/', [
      'uses' => 'BobrovoController@getGroupsPage',
      'as' => 'groups.all'
    ]);

    Route::get('/{id}', [
      'uses' => 'BobrovoController@getGroupOnePage',
      'as' => 'groups.one'
    ])->where('id', '[0-9]+');

    Route::get('/pridat', [
      'uses' => 'BobrovoController@getAddGroupPage',
      'as' => 'groups.add'
    ]);
    Route::post('/pridat', [
      'uses' => 'BobrovoController@postAddGroupPage',
      'as' => 'groups.add'
    ]);

    Route::get('/vymazat/{id}', [
      'uses' => 'BobrovoController@getDeleteGroup',
      'as' => 'groups.delete'
    ])->where('id', '[0-9]+');

    Route::get('/upravit/{id}', [
      'uses' => 'BobrovoController@getEditGroupPage',
      'as' => 'groups.edit'
    ])->where('id', '[0-9]+');

    Route::post('/upravit/{id}', [
      'uses' => 'BobrovoController@postEditGroupPage',
      'as' => 'groups.edit'
    ])->where('id', '[0-9]+');
  });


  
  Route::group(['prefix' => 'ziaci'], function(){
    Route::get('/', [
      'uses' => 'BobrovoController@getStudentsPage',
      'as' => 'students.all'
    ]);
    Route::post('/', [
      'uses' => 'BobrovoController@postStudentsPage',
      'as' => 'students.all'
    ]);

    Route::get('/pridat', [
      'uses' => 'BobrovoController@getAddStudentPage',
      'as' => 'students.add'
    ]);
    Route::post('/pridat', [
      'uses' => 'BobrovoController@postAddStudentPage',
      'as' => 'students.add'
    ]);

    Route::get('/profil/{id}', [
      'uses' => 'BobrovoController@getStudentProfilPage',
      'as' => 'students.profil'
    ])->where('id', '[0-9]+');

    Route::post('/profil/{id}', [
      'uses' => 'BobrovoController@postAddStudentToGroup',
      'as' => 'students.one'
    ])->where('id', '[0-9]+');

    Route::get('/vymazat/{id}', [
      'uses' => 'BobrovoController@getStudentDeletePage',
      'as' => 'students.delete'
    ])->where('id', '[0-9]+');
    
    Route::get('/vymazat/{student_id}/{group_id}', [
      'uses' => 'BobrovoController@getDeleteFromGroup',
      'as' => 'students.delete.from.group'
    ])->where('student_id', '[0-9]+')->where('group_id', '[0-9]+');

    Route::get('/pridat-zo-suboru', [
      'uses' => 'BobrovoController@getAddStudentFromFilePage',
      'as' => 'students.file'
    ]);
    Route::post('/pridat-zo-suboru', [
      'uses' => 'BobrovoController@postAddStudentFromFilePage',
      'as' => 'students.file'
    ]);
  });
});
