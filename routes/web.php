<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ResumeController;
use App\Http\Controllers\JobseekerController;
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




function getInertiaData()
{
    return [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => app()->version(),
        'phpVersion' => phpversion(),
    ];
}

// Welcome Routes
Route::group([], function () {

    // HOME ↓
    Route::get('/', function () {
        return Inertia::render('Welcome', getInertiaData());
    })->name('home');

    // Announcement ↓
    Route::get('/announcement', function () {
        return Inertia::render('Announcement/Index', getInertiaData());
    })->name('announcement');
      // Dashboard Announcement ↓
      Route::get('/dashboard/announcement', function () {
        return Inertia::render('Dashboard/Jobseeker-Page/Announcement', getInertiaData());
    })->name('dashboard-announcement');


    // JOBS SEARCH ↓
    Route::get('/jobs', function () {
        return Inertia::render('Job/Index', getInertiaData());
    })->name('job');

    // COMPANIES ↓
    Route::get('/company', function () {
        return Inertia::render('Company/Index', getInertiaData());
    })->name('company');

     // COMPANIES Info ↓
     Route::get('company/company-info', function () {
        return Inertia::render('Company/Info', getInertiaData());
    })->name('company/company-info');


    // ABOUT US ↓
    Route::get('/about-us', function () {
        return Inertia::render('AboutUs/Index', getInertiaData());
    })->name('about-us');

    // ADMIN ↓
    Route::get('/admin', function () {
        return Inertia::render('Dashboard/Admin', getInertiaData());
    })->middleware(['auth', 'role:admin'])->name('admin');


    Route::resource('jobseeker',JobseekerController::class) // Jobseeker DASHBOARD  
    ->only(['index','show'])
    ->middleware(['auth', 'role:jobseeker']);


    Route::resource('resume-profile', ResumeController::class)
    ->only(['show']) // Use 'show'
    ->middleware(['auth', 'role:jobseeker']);
    
  

    Route::resource('resume-build',ResumeController::class) //Resume Building  ROUTE
    ->only(['index','create', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'role:jobseeker']);

});

// Resume Routes
Route::group([], function () {

    Route::post('resume-profile/{id}/add-education', [ResumeController::class, 'addEducation']) // Adding Education Route
    ->name('resume-profile.addEducation')
    ->middleware(['auth', 'role:jobseeker']);

    Route::post('resume-profile/{id}/add-experience', [ResumeController::class, 'addExperience']) // Adding Experience Route
    ->name('resume-profile.addExperience')
    ->middleware(['auth', 'role:jobseeker']);


    Route::post('resume-profile/{id}/update-pfp', [ResumeController::class, 'updatePFP']) // Update Contact Route
    ->name('resume-profile.updatePFP')
    ->middleware(['auth', 'role:jobseeker']);


    Route::post('resume-profile/{id}/update-head', [ResumeController::class, 'updateHead']) // Update Head Route
    ->name('resume-profile.updateHead')
    ->middleware(['auth', 'role:jobseeker']);

    Route::post('resume-profile/{id}/update-contact', [ResumeController::class, 'updateContact']) // Update Contact Route
    ->name('resume-profile.updateContact')
    ->middleware(['auth', 'role:jobseeker']);



    Route::post('resume-profile/{id}/add-skill', [ResumeController::class, 'addSkill']) // Adding Skill Route
    ->name('resume-profile.addSkill')
    ->middleware(['auth', 'role:jobseeker']);
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
