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




Route::group(['prefix' => 'ucitel', 'middleware'=>'auth'], function(){
    Route::get('/', [
        'uses' => 'UserController@getUcitelAdminPage',
        'as' => 'admin'
    ]);
    Route::get('/odhlasit', [
        'uses' => 'UserController@getLogut',
        'as' => 'logout'
    ]);

    Route::get('/nespravny-link', [
        'uses' => 'UserController@getBadLinkPage',
        'as' => 'badlink'
    ]);

    // USERS
    Route::group(['prefix' => 'pouzivatelia'], function(){
        Route::get('/', [
            'uses' => 'UserController@getAllUsersPage',
            'as' => 'users.all'
        ]);

        Route::get('/toggle-admin/{id}', [
            'uses' => 'UserController@getToggleAdminUser',
            'as' => 'users.toggle-admin'
        ])->where('id', '[0-9]+');

        Route::get('/delete/{id}', [
            'uses' => 'UserController@getDeleteUser',
            'as' => 'users.delete'
        ])->where('id', '[0-9]+');;
    });


    // --------
    // |  NewsController / only for admin
    // --------

    Route::group(['prefix' => 'novinky'], function(){
        Route::get('/', [
            'uses' => 'NewsController@getAllNewsPage',
            'as' => 'news.all'
        ]);

        Route::get('/pridaj', [
            'uses' => 'NewsController@getAddNewsPage',
            'as' => 'news.addnew'
        ]);
        Route::post('/pridaj', [
            'uses' => 'NewsController@postAddNewsPage',
            'as' => 'news.addnew'
        ]);

        Route::get('/upravit/{news_id}', [
            'uses' => 'NewsController@getEditNewsPage',
            'as' => 'news.edit'
        ])->where('nesw_id', '[0-9]+');
        Route::post('/upravit/{news_id}', [
            'uses' => 'NewsController@postEditNewsPage',
            'as' => 'news.edit'
        ])->where('nesw_id', '[0-9]+');

        Route::get('/vymazat/{news_id}', [
            'uses' => 'NewsController@getDeleteNews',
            'as' => 'news.delete'
        ])->where('nesw_id', '[0-9]+');
    });


    // ------------
    // |  FaqController / only for admins
    // ---------

    Route::group(['prefix' => 'faq'], function(){
        Route::get('/', [
            'uses' => 'FaqController@getAllFAQPage',
            'as' => 'faq.all'
        ]);

        Route::get('/pridaj', [
            'uses' => 'FaqController@getAddFAQPage',
            'as' => 'faq.addnew'
        ]);
        Route::post('/pridaj', [
            'uses' => 'FaqController@postAddFAQPage',
            'as' => 'faq.addnew'
        ]);

        Route::get('/upravit/{id}', [
            'uses' => 'FaqController@getEditFAQPage',
            'as' => 'faq.edit'
        ])->where('id', '[0-9]+');
        Route::post('/upravit/{id}', [
            'uses' => 'FaqController@postEditFAQPage',
            'as' => 'faq.edit'
        ])->where('id', '[0-9]+');

        Route::get('/vymazat/{id}', [
            'uses' => 'FaqController@getDeleteFAQ',
            'as' => 'faq.delete'
        ])->where('id', '[0-9]+');
    });


    // ------
    // |  MessageController / for admins and teachers
    // ------

    Route::group(['prefix' => 'spravy'], function(){
        Route::get('/', [
            'uses' => 'MessageController@getMessagesPage',
            'as' => 'msg.all'
        ]);
        Route::get('/poslat', [
            'uses' => 'MessageController@getSendMessagePage',
            'as' => 'msg.send'
        ]);
        Route::post('/poslat', [
            'uses' => 'MessageController@postSendMessagePage',
            'as' => 'msg.send'
        ]);

        Route::get('/posta/{id}', [
            'uses' => 'MessageController@getOneMessagePage',
            'as' => 'msg.one'
        ])->where('id', '[0-9]+');

        Route::get('/odpovedat/{id}', [
            'uses' => 'MessageController@getAnswerPage',
            'as' => 'msg.answer'
        ])->where('id', '[0-9]+');
        Route::post('/odpovedat/{id}', [
            'uses' => 'MessageController@postAnswerPage',
            'as' => 'msg.answer'
        ])->where('id', '[0-9]+');

        Route::get('/vymazat/{id}', [
            'uses' => 'MessageController@getDeleteMessagePage',
            'as' => 'msg.delete'
        ])->where('id', '[0-9]+');
    });

    // -------
    // |   GroupController / for admins and teachers /
    // ------
    Route::group(['prefix' => 'skupiny'], function(){
        Route::get('/', [
            'uses' => 'GroupController@getGroupsPage',
            'as' => 'groups.all'
        ]);

        Route::get('/{id}', [
            'uses' => 'GroupController@getGroupOnePage',
            'as' => 'groups.one'
        ])->where('id', '[0-9]+');

        Route::get('/talcit/{id}', [
            'uses' => 'PdfController@getStudentsInGroupPdfExport',
            'as' => 'groups.export'
        ])->where('id', '[0-9]+');

        Route::get('/pridat', [
            'uses' => 'GroupController@getAddGroupPage',
            'as' => 'groups.add'
        ]);
        Route::post('/pridat', [
            'uses' => 'GroupController@postAddGroupPage',
            'as' => 'groups.add'
        ]);

        Route::get('/vymazat/{id}', [
            'uses' => 'GroupController@getDeleteGroup',
            'as' => 'groups.delete'
        ])->where('id', '[0-9]+');

        Route::get('/upravit/{id}', [
            'uses' => 'GroupController@getEditGroupPage',
            'as' => 'groups.edit'
        ])->where('id', '[0-9]+');

        Route::post('/upravit/{id}', [
            'uses' => 'GroupController@postEditGroupPage',
            'as' => 'groups.edit'
        ])->where('id', '[0-9]+');
    });


    // -------
    // |  StudentController / for admins and teachers
    // -----

    Route::group(['prefix' => 'ziaci'], function(){
        Route::get('/', [
            'uses' => 'StudentController@getStudentsPage',
            'as' => 'students.all'
        ]);
        Route::post('/', [
            'uses' => 'StudentController@postStudentsPage',
            'as' => 'students.all'
        ]);

        Route::get('/tlacit', [
            'uses' => 'PdfController@getStudentsPdfExport',
            'as' => 'students.export'
        ]);

        Route::get('/pridat', [
            'uses' => 'StudentController@getAddStudentPage',
            'as' => 'students.add'
        ]);
        Route::post('/pridat', [
            'uses' => 'StudentController@postAddStudentPage',
            'as' => 'students.add'
        ]);

        Route::get('/profil/{id}', [
            'uses' => 'StudentController@getStudentProfilPage',
            'as' => 'students.profil'
        ])->where('id', '[0-9]+');

        Route::post('/profil/{id}', [
            'uses' => 'StudentController@postAddStudentToGroup',
            'as' => 'students.one'
        ])->where('id', '[0-9]+');

        Route::get('/vymazat/{id}', [
            'uses' => 'StudentController@getStudentDeletePage',
            'as' => 'students.delete'
        ])->where('id', '[0-9]+');

        Route::get('/vymazat/{student_id}/{group_id}', [
            'uses' => 'StudentController@getDeleteFromGroup',
            'as' => 'students.delete.from.group'
        ])->where('student_id', '[0-9]+')->where('group_id', '[0-9]+');

        Route::get('/pridat-zo-suboru', [
            'uses' => 'StudentController@getAddStudentFromFilePage',
            'as' => 'students.file'
        ]);
        Route::post('/pridat-zo-suboru', [
            'uses' => 'StudentController@postAddStudentFromFilePage',
            'as' => 'students.file'
        ]);
    });


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

        Route::get('/{id}', [
            'uses' => 'QuestionController@getQuestionPage',
            'as' => 'questions.one'
        ])->where('id', '[0-9]+');
        Route::post('/{id}', [
            'uses' => 'QuestionController@postQuestionPage',
            'as' => 'questions.one'
        ])->where('id', '[0-9]+');

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
