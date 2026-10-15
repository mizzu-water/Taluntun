<?php
require_once __DIR__ . '/auth/config.php';
startAuthSession();

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

$router->add('/assessment', 'AssessmentController@index', true);
$router->add('/results', 'AssessmentController@results', true);
$router->add('/api/save_assessment', 'AssessmentController@save', true);
$router->add('/api/get_degrees', 'AssessmentController@getDegrees');
$router->add('/api/get_recommended_degrees', 'AssessmentController@getRecommendedDegrees', true);
$router->add('/api/get_my_assessment', 'AssessmentController@getMyAssessment', true);
$router->add('/api/get_role_model', 'AssessmentController@getRoleModel');
$router->add('/api/get_questions', 'AssessmentController@getQuestions', true);
$router->add('/api/pause_assessment', 'AssessmentController@saveProgress', true);
$router->add('/api/check_progress', 'AssessmentController@checkProgress', true);
$router->add('/api/discard_assessment', 'AssessmentController@discardProgress', true);
$router->add('/assessment/discard', 'AssessmentController@discardProgress', true);
$router->add('/api/get_degree', 'AssessmentController@getDegree');
$router->add('/api/get_college', 'AssessmentController@getCollege');
$router->add('/api/get_colleges', 'AssessmentController@getColleges');

$router->add('/course-quiz', 'CourseQuizController@index', true);
$router->add('/api/get_course_questions', 'CourseQuizController@getQuestions', true);
$router->add('/api/authorize_assessment', 'CourseQuizController@authorize', true);
$router->add('/api/submit_course_quiz', 'CourseQuizController@submit', true);

$router->add('/profile', 'ProfileController@index', true);
$router->add('/settings', 'ProfileController@settings', true);
$router->add('/api/get_profile_data', 'ProfileController@getProfileData', true);
$router->add('/api/update_settings', 'ProfileController@updateSettings', true);
$router->add('/api/save_college', 'ProfileController@saveCollege', true);
$router->add('/api/save_degree', 'ProfileController@saveDegree', true);

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







