<?php
session_start();

// Simple Autoloader
spl_autoload_register(function ($class) {
    if (file_exists("core/$class.php")) {
        require_once "core/$class.php";
    } elseif (file_exists("app/Controllers/$class.php")) {
        require_once "app/Controllers/$class.php";
    } elseif (file_exists("app/Models/$class.php")) {
        require_once "app/Models/$class.php";
    }
});
$router = new Router();

// Define routes here
$router->add('/', 'HomeController@index');
$router->add('/login', 'AuthController@login');
$router->add('/signup', 'AuthController@signup');
$router->add('/register', 'AuthController@register');
$router->add('/logout', 'AuthController@logout');
$router->add('/verify_code', 'AuthController@verifyCode');
$router->add('/resend_code', 'AuthController@resendCode');

$router->add('/assessment', 'AssessmentController@index');
$router->add('/results', 'AssessmentController@results');
$router->add('/api/save_assessment', 'AssessmentController@save');
$router->add('/api/get_degrees', 'AssessmentController@getDegrees');
$router->add('/api/get_recommended_degrees', 'AssessmentController@getRecommendedDegrees');
$router->add('/api/get_role_model', 'AssessmentController@getRoleModel');
$router->add('/api/get_questions', 'AssessmentController@getQuestions');
$router->add('/api/pause_assessment', 'AssessmentController@pauseAssessment');
$router->add('/api/check_progress', 'AssessmentController@checkProgress');
$router->add('/api/get_degree', 'AssessmentController@getDegree');
$router->add('/api/get_college', 'AssessmentController@getCollege');
$router->add('/api/get_latest_assessment', 'AssessmentController@getLatestAssessment');
$router->add('/api/get_colleges', 'AssessmentController@getColleges');

$router->add('/course-quiz', 'CourseQuizController@index');
$router->add('/api/get_course_questions', 'CourseQuizController@getQuestions');

$router->add('/profile', 'ProfileController@index');
$router->add('/settings', 'ProfileController@settings');
$router->add('/api/get_current_user', 'ProfileController@getCurrentUser');
$router->add('/api/save_college', 'ProfileController@saveCollege');
$router->add('/api/save_degree', 'ProfileController@saveDegree');
$router->add('/api/save_favorite_subjects', 'ProfileController@saveFavoriteSubjects');
$router->add('/api/get_favorite_subjects', 'ProfileController@getFavoriteSubjects');
$router->add('/api/change_password', 'ProfileController@changePassword');
$router->add('/api/update_profile_name', 'ProfileController@updateProfileName');

$router->add('/careers', 'PagesController@careers');
$router->add('/colleges', 'PagesController@colleges');
$router->add('/degrees', 'PagesController@degrees');
$router->add('/degree-profile', 'PagesController@degreeProfile');
$router->add('/lesson', 'PagesController@lesson');
$router->add('/scholarships', 'PagesController@scholarships');
$router->add('/admin', 'PagesController@admin');
$router->add('/details', 'PagesController@details');
$router->add('/school-map', 'PagesController@schoolMap');

$router->add('/how-it-works', 'PagesController@howItWorks');
$router->add('/holland', 'PagesController@holland');
$router->add('/course-intro', 'PagesController@courseIntro');

// School Specific Routes
$router->add('/pcu-profile', 'PagesController@pcuProfile');
$router->add('/pcu-campus', 'PagesController@pcuCampus');
$router->add('/pcu-programs', 'PagesController@pcuPrograms');
$router->add('/pcu-tuition', 'PagesController@pcuTuition');

$router->add('/tup-profile', 'PagesController@tupProfile');
$router->add('/tup-campus', 'PagesController@tupCampus');
$router->add('/tup-programs', 'PagesController@tupPrograms');
$router->add('/tup-tuition', 'PagesController@tupTuition');

$router->add('/school-profile', 'PagesController@schoolProfile');
$router->add('/school-campus', 'PagesController@schoolCampus');
$router->add('/school-programs', 'PagesController@schoolPrograms');
$router->add('/school-tuition', 'PagesController@schoolTuition');

$router->add('/cvsu-profile', 'PagesController@cvsuProfile');
$router->add('/cvsu-campus', 'PagesController@cvsuCampus');
$router->add('/cvsu-programs', 'PagesController@cvsuPrograms');
$router->add('/cvsu-tuition', 'PagesController@cvsuTuition');

$router->add('/dlsu-profile', 'PagesController@dlsuProfile');
$router->add('/dlsu-campus', 'PagesController@dlsuCampus');
$router->add('/dlsu-programs', 'PagesController@dlsuPrograms');
$router->add('/dlsu-tuition', 'PagesController@dlsuTuition');

$router->add('/eac-profile', 'PagesController@eacProfile');
$router->add('/eac-campus', 'PagesController@eacCampus');
$router->add('/eac-programs', 'PagesController@eacPrograms');
$router->add('/eac-tuition', 'PagesController@eacTuition');

$router->add('/ncst-profile', 'PagesController@ncstProfile');
$router->add('/ncst-campus', 'PagesController@ncstCampus');
$router->add('/ncst-programs', 'PagesController@ncstPrograms');
$router->add('/ncst-tuition', 'PagesController@ncstTuition');

// Dispatch
$url = isset($_GET['url']) ? $_GET['url'] : '/';
$router->dispatch($url);







