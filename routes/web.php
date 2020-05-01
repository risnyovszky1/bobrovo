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
    'middleware' => 'guest',
    'namespace' => 'Admin'
]);

Route::post('/prihlasenie-ucitel', [
    'uses' => 'UserController@postLoginTeacherPage',
    'as' => 'login_teacher',
    'middleware' => 'guest',
    'namespace' => 'Admin'
]);

Route::post('/upload-img', [
    'uses' => 'UploadRequestController@postUploadQuestionImage',
    'as' => 'upload.req',
]);


Route::group(['prefix' => 'ucitel', 'middleware' => 'auth', 'namespace' => 'Admin'], function () {
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
    Route::resource('test', 'TestManageController');
    Route::patch('test/{test}/remove-question/{question}', 'TestManageController@removeQuestion')->name('test.remove-question');
    Route::get('/test/{test}/result', 'TestManageController@result')->name('test.result');
    Route::get('/test/{test}/result/{student}', 'TestManageController@student')->name('test.student');

    // ------
    // |  Questions
    // ------
    Route::get('question/moje', 'QuestionController@myQuestions')->name('question.index.my');
    Route::get('question/other', 'QuestionController@otherQuestions')->name('question.index.other');
    Route::get('question/filter', 'QuestionController@filter')->name('question.filter');
    Route::post('question/filter', 'QuestionController@saveFilter')->name('question.filter');
    Route::delete('question/reset', 'QuestionController@resetFilter')->name('question.filter.reset');
    Route::post('question/add-to-test', 'QuestionController@addQuestionsToTest')->name('question.add-to-test');
    Route::post('question/{question}/comment', 'QuestionController@comment')->name('question.comment');
    Route::post('question/{question}/rating', 'QuestionController@rating')->name('question.rating');
    Route::post('question/{question}', 'QuestionController@addToTest')->name('question.test');
    Route::resource('question', 'QuestionController');

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
