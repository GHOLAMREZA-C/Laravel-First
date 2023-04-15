<?php
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/' , function()
{
    return view('SignUp');
});
Route::post('/' , function ()
{
    $validated_data = Validator::make(request()->all(), [
        'name'=>'required|min:3|max:40',
        'number' =>'required|min:11|max:13|regex:/^([0-9\s\-\+\(\)]*)$/',
        'email'=>'required',
        'password'=>'required|min:8|max:30',
        'address' => 'required'
       ])->validated();
    User::create(
        [
            'name' => $validated_data['name'],
            'number' => $validated_data['number'],
            'email' => $validated_data['email'],
            'password' => $validated_data['password'],
            'address' => $validated_data['address']
        ]);

    return redirect('/LogIn');
});
Route::get('/LogIn' , function()
{
    return view('LogIn');
});
Route::post('/LogIn' , function ()
{
    $validated_user = Validator::make(request()->all() , 
    [
        'number' => 'required|min:11|max:13|regex:/^([0-9\s\-\+\(\)]*)$/',
        'password' => 'required|min:8|max:30'
    ])->validated();

    $user_number = User::where('number' , $validated_user['number'])->value('number');
    $user_password = User::where('password' , $validated_user['password'])->value('password');
    if(!empty($user_number) and !empty($user_password))
    {
        return view('success');
    }
    else{
        return view('unsuccess');
    }
});


Route::get('/success' , function ()
{
    return view('success');
});
Route::get('/unsuccess' , function()
{
    return view('unsuccess');
});