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
    'uses' => 'PagesController@index',
    'as' => 'index'
]);

Route::post('/', [
    'uses' => 'PagesController@sendContactForm',
    'as' => 'contact-form'
]);

Route::get('/registracia', [
    'uses' => 'PagesController@registration',
    'as' => 'register'
]);

Route::post('/registracia', [
    'uses' => 'PagesController@sendRegistration',
    'as' => 'register'
]);

Route::get('/novinky', [
    'uses' => 'PagesController@news',
    'as' => 'general.news.index'
]);
Route::get('/novinky/{news}', [
    'uses' => 'PagesController@showNews',
    'as' => 'general.news.show'
])->where('id', '[0-9]+');;

Route::get('/vseobecne-podmienky', [
    'uses' => 'PagesController@defaultConditions',
    'as' => 'default_cond'
]);

Route::get('/faq', [
    'uses' => 'PagesController@faq',
    'as' => 'faq'
]);


// --------
// | TestController / Pages for students
// --------

Route::get('/prihlasenie-ziak', [
    'uses' => 'TestController@getLoginStudentPage',
    'as' => 'login_student',
]);
Route::post('/prihlasenie-ziak', [
    'uses' => 'TestController@postLoginStudentPage',
    'as' => 'login_student',
]);


Route::group(['prefix' => 'ziak', 'middleware' => 'auth:bobor'], function () {
    Route::get('/', [
        'uses' => 'TestController@getStudentHomePage',
        'as' => 'student_home',
    ]);

    Route::get('/odhlasit', [
        'uses' => 'TestController@getLogoutStudent',
        'as' => 'logout_student',
    ]);

    Route::get('/testy', [
        'uses' => 'TestController@getStudentTestsPage',
        'as' => 'tests_student',
    ]);

    Route::get('/testy/{id}', [
        'uses' => 'TestController@getTestPage',
        'as' => 'testone_student',
    ])->where('id', '[0-9]+');

    Route::get('/vysledky/{id}', [
        'uses' => 'TestController@getResultsPage',
        'as' => 'results_student',
    ])->where('id', '[0-9]+');

    Route::get('/testuj/{id}', [
        'uses' => 'TestController@getSolvingPage',
        'as' => 'solving_student',
    ])->where('id', '[0-9]+');

    Route::get('/testuj/dokoncit/{id}', [
        'uses' => 'TestController@getFinishPage',
        'as' => 'finish_student',
    ])->where('id', '[0-9]+');
    Route::post('/testuj/dokoncit/{id}', [
        'uses' => 'TestController@postFinishPage',
        'as' => 'finish_student',
    ])->where('id', '[0-9]+');

    Route::get('/testuj/dokoncit-timer/{id}', [
        'uses' => 'TestController@getFinishTimer',
        'as' => 'finish_student_timer',
    ])->where('id', '[0-9]+');

    Route::get('/testuj/{id}/{ord}', [
        'uses' => 'TestController@getQuestionPage',
        'as' => 'question_student',
    ])->where('id', '[0-9]+')->where('ord', '[0-9]+');
    Route::post('/testuj/{id}/{ord}', [
        'uses' => 'TestController@postQuestionPage',
        'as' => 'question_student',
    ])->where('id', '[0-9]+')->where('ord', '[0-9]+');

    Route::get('/measure', [
        'uses' => 'TestController@getMeasereQuestionTime',
        'as' => 'measure_student'
    ]);

    Route::get('/skupiny', [
        'uses' => 'TestController@getGroupsPage',
        'as' => 'groups_student',
    ]);
    Route::get('/skupiny/{id}', [
        'uses' => 'TestController@getOneGroupPage',
        'as' => 'groups_one_student',
    ])->where('id', '[0-9]+');
});


// --------
// | QuestionController / admin pages
// --------

Route::get('/prihlasenie-ucitel', [
    'uses' => 'UserController@getLoginTeacherPage',
    'as' => 'login_teacher',
    'middleware' => 'guest'
]);

Route::post('/prihlasenie-ucitel', [
    'uses' => 'UserController@postLoginTeacherPage',
    'as' => 'login_teacher',
    'middleware' => 'guest'
]);

Route::post('/upload-img', [
    'uses' => 'UploadRequestController@postUploadQuestionImage',
    'as' => 'upload.req',
]);


Route::group(['prefix' => 'ucitel', 'middleware' => 'auth'], function () {
    Route::get('/', [
        'uses' => 'UserController@getUcitelAdminPage',
        'as' => 'admin'
    ]);
    Route::get('/odhlasit', [
        'uses' => 'UserController@getLogout',
        'as' => 'logout'
    ]);

    Route::get('/nespravny-link', [
        'uses' => 'UserController@getBadLinkPage',
        'as' => 'badlink'
    ]);

    // --------
    // |  UserController / only for admin
    // --------
    Route::resource('user', 'UserController')->only(['index', 'destroy']);
    Route::patch('user/{user}/toggle', 'UserController@toggle')->name('user.toggle');

    // --------
    // |  NewsController / only for admin
    // --------
    Route::resource('news', 'NewsController')->except(['show']);


    // ------------
    // |  FaqController / only for admins
    // ---------
    Route::resource('faq', 'FaqController')->except(['show']);

    // ------
    // |  MessageController / for admins and teachers
    // ------
    Route::resource('message', 'MessageController')->except(['edit', 'update']);
    Route::get('message/{message}/answer', 'MessageController@answer')->name('message.answer');
    Route::post('message/{message}/answer', 'MessageController@answer')->name('message.answer');

    // -------
    // |   GroupController / for admins and teachers /
    // ------
    Route::resource('group', 'GroupController');

    // -------
    // |  StudentController / for admins and teachers
    // -----
    Route::resource('student', 'StudentController')->except(['edit']);
    Route::patch('student', 'StudentController@addStudentsToGroup')->name('student.index');
    Route::patch('student/remove/{student}/{group}', 'StudentController@removeFromGroup')->name('student.remove-from-group');
    // TODO
    Route::get('student/import', 'StudentController@import')->name('student.import');
    Route::post('student/import', 'StudentController@importSave')->name('student.import-save');

    Route::get('student/print', [
        'uses' => 'PdfController@getStudentsPdfExport',
        'as' => 'students.export'
    ]);

    // -------
    // |  TestManageController / for edit, add, delete, manage tests
    // -------
    Route::group(['prefix' => 'testy'], function () {
        Route::get('/', [
            'uses' => 'TestManageController@getAllTestsPage',
            'as' => 'tests.all'
        ]);
        Route::get('/{id}', [
            'uses' => 'TestManageController@getTestPage',
            'as' => 'tests.one'
        ])->where('id', '[0-9]+');

        Route::get('/upravit/{id}', [
            'uses' => 'TestManageController@getTestEditPage',
            'as' => 'tests.edit'
        ])->where('id', '[0-9]+');
        Route::post('/upravit/{id}', [
            'uses' => 'TestManageController@postTestEditPage',
            'as' => 'tests.edit'
        ])->where('id', '[0-9]+');

        Route::get('/pridat', [
            'uses' => 'TestManageController@getAddTestPage',
            'as' => 'tests.add'
        ]);
        Route::post('/pridat', [
            'uses' => 'TestManageController@postAddTestPage',
            'as' => 'tests.add'
        ]);

        Route::get('/vymzat/{id}', [
            'uses' => 'TestManageController@getDeleteTest',
            'as' => 'tests.delete'
        ])->where('id', '[0-9]+');

        Route::get('/vymazat-otazku/{test_id}/{question_id}', [
            'uses' => 'TestManageController@getDeleteQuestionFromTest',
            'as' => 'tests.delete.question'
        ])->where('test_id', '[0-9]+')
            ->where('question_id', '[0-9]+');;

        Route::get('/vysledky/{id}', [
            'uses' => 'TestManageController@getResultsOfTestPage',
            'as' => 'tests.results'
        ])->where('id', '[0-9]+');
        Route::get('/vysledky/{id}/{sid}', [
            'uses' => 'TestManageController@getResultOfStudentForPage',
            'as' => 'tests.results.student'
        ])->where('id', '[0-9]+')->where('sid', '[0-9]+');
    });


    // ------
    // |  Questions
    // ------

    Route::group(['prefix' => 'otazky'], function () {
        Route::get('/', [
            'uses' => 'QuestionController@getAllQuestionsPage',
            'as' => 'questions.all'
        ]);
        Route::post('/', [
            'uses' => 'QuestionController@postAllQuestionsPage',
            'as' => 'questions.all'
        ]);

        Route::get('/moje', [
            'uses' => 'QuestionController@getMyQuestionsPage',
            'as' => 'questions.my'
        ]);
        Route::post('/moje', [
            'uses' => 'QuestionController@postMyQuestionsPage',
            'as' => 'questions.my'
        ]);

        Route::get('/ostatne', [
            'uses' => 'QuestionController@getOtherQuestionsPage',
            'as' => 'questions.other'
        ]);
        Route::post('/ostatne', [
            'uses' => 'QuestionController@postOtherQuestionsPage',
            'as' => 'questions.other'
        ]);

        Route::get('/pridat', [
            'uses' => 'QuestionController@getAddQuestionPage',
            'as' => 'questions.add'
        ]);
        Route::post('/pridat', [
            'uses' => 'QuestionController@postAddQuestionPage',
            'as' => 'questions.add'
        ]);

        Route::get('/filter', [
            'uses' => 'QuestionController@getFilterPage',
            'as' => 'questions.filter'
        ]);
        Route::post('/filter', [
            'uses' => 'QuestionController@postFilterPage',
            'as' => 'questions.filter'
        ]);
        Route::get('/filter/reset', [
            'uses' => 'QuestionController@getFilterReset',
            'as' => 'questions.filter.reset'
        ]);

        Route::get('/vymazat/{id}', [
            'uses' => 'QuestionController@getDeleteQuestion',
            'as' => 'questions.delete'
        ])->where('id', '[0-9]+');

        Route::get('/upravit/{id}', [
            'uses' => 'QuestionController@getEditQuestionPage',
            'as' => 'questions.edit'
        ])->where('id', '[0-9]+');

        Route::post('/upravit/{id}', [
            'uses' => 'QuestionController@postEditQuestionPage',
            'as' => 'questions.edit'
        ])->where('id', '[0-9]+');

        Route::get('/hodnotit/{id}/{rating}', [
            'uses' => 'QuestionController@getQuestionRating',
            'as' => 'questions.rating'
        ])->where('id', '[0-9]+')
            ->where('rating', '[1-5]');

        Route::post('/comment/{id}/', [
            'uses' => 'QuestionController@postAddComment',
            'as' => 'questions.addcomment'
        ])->where('id', '[0-9]+');

        Route::get('/{id}', [
            'uses' => 'QuestionController@getQuestionPage',
            'as' => 'questions.one'
        ])->where('id', '[0-9]+');
        Route::post('/{id}', [
            'uses' => 'QuestionController@postQuestionPage',
            'as' => 'questions.one'
        ])->where('id', '[0-9]+');
    });


    // -------
    // |   ProfileController / for edit user profile
    // -------

    Route::group(['prefix' => 'profil'], function () {
        Route::get('/', [
            'uses' => 'ProfileController@getProfilPage',
            'as' => 'admin.profil'
        ]);
        Route::post('/', [
            'uses' => 'ProfileController@postProfilPage',
            'as' => 'admin.profil'
        ]);

        Route::get('/delete', [
            'uses' => 'ProfileController@getProfilDeletePage',
            'as' => 'admin.profil.delete'
        ]);
        Route::post('/delete', [
            'uses' => 'ProfileController@postProfilDeletePage',
            'as' => 'admin.profil.delete'
        ]);
    });
});
