<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MoviesController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;
use DB;
use App\Traits\ActivityLogs;
use App\Models\ActivityLog;
use Spatie\Permission\Models\Role;
use App\Jobs\TestJob;
use App\Jobs\DeleteActivitiesBulk;
use Illuminate\Bus\Batch;
use Throwable;
use Illuminate\Support\Facades\Bus;

class RegisteredUserController extends Controller
{
    use ActivityLogs;
    /**
     * Display the registration view.
     */
    // register page
    public function index(): View
    {
        $roles = Role::all();
        // return view('auth.register');
        return view('auth.registration',compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    //create user
    public function store(Request $request)
    {
       $validate =  Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' =>['required','string']
        ]);
        if($validate->fails()){
            return response()->json([
                'errors' => $validate->errors()
            ]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::find($request->role_id);
        //assign role to user
        $user->assignRole($role->name);

        //if role is user then no need of image
        if($role->name != 'User')
        { 
            //get image 
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'),$imageName);

            //image detail
            $image_detail = [
                'image'   => $imageName,
            ];

            $user->images()->create($image_detail);

        }
        Session::flash('success',''.ucfirst($user->name).' account is successfully created');
        
        $this->activity(Auth::user()->name,Auth::user()->email,$user->name. ' account is successfully created','success');
        return response()->json([
            'location' => route('dashboard')
        ]);
    }
    //Dashboard
    public function dashboard(){
        $users = User::all();
        return view('dashboard',compact('users'));
    }
    //Edit user
    public function edit(Request $request){
        $user_id = $request->id;
        $user = User::find($user_id);
        $roles = Role::all();
        return view('auth.registration',compact('user','roles'));
    }

    //delete user 
    public function trash(Request $request){
        $deleted = User::where('id',$request->id)->delete();    
        if($deleted>0){
            Session::flash('success','Successfully Deleted');
            return redirect()->back();
        }
    }
    //update user
    public function update(Request $request){
        if(!isset($request->password) && !isset($request->password_confirmation))
        {
            $validation = Validator::make($request->all(),[
                'name' => 'required',
                'email' =>'required|email',
                'role_id' =>'required|string'
             ]);
             //if validation fails  
            if($validation->fails()){
                return response()->json([
                    'errors' => $validation->errors()
                ]);
            }
            //updated information
            $updated_info = ['name'=>$request->name,'email'=>$request->email];
            //update user
            $update_user =  User::where('id',$request->id)->update($updated_info);

            //fetch user 
            $user =  User::find($request->id);
            //update role
            $user->roles()->sync([$request->role_id]);
            //if user successfully updated
            if($update_user == 1){
                if(isset($request->image)){
                    $updated_image = $request->image;
                    $image_name = time() .'.'.$updated_image->getClientOriginalExtension();
                    $updated_image->move(public_path('images'),$image_name); 
                    // Image::where('user_id',$request->id)->update(['image'=>$image_name]);
                    $update_image = $user->images->update(['image'=>$image_name]);
                }
                Session::flash('success',''.ucfirst($updated_info['name']).' is successfully updated');
                $this->activity(Auth::user()->name,Auth::user()->email,$updated_info['name'] .' accounts updation successfully','success');
                return response()->json([
                    'message' => 'success',
                    'location' => route('dashboard')
                ]);
            }
            else{
                return response()->json([
                    'error' => 'Not Updated'
                ]);
            }
        }
        else{
            // if all feild is entered
           $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' =>'required|email',
                'password'=>'required|min:8|confirmed'
            ]); 

            if($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }
           //updated info
           $updated_info = [
                            'name' => $request->name,
                            'email'=> $request->email,
                            'password' =>Hash::make($request->password)
                            ];
            //update 
            $updated_user = User::where('id',$request->id)->update($updated_info);
            
            if($updated_user>0)
            {
                if(isset($request->image)){
                    //get image 
                   $imageName = time().'.'.$request->image->getClientOriginalExtension();
                   $request->image->move(public_path('images'),$imageName);
       
                   //image detail
                   $image_detail = [
                       'image'   => $imageName,
                   ];
                   
                   $update_image  = User::find($request->id)->images->update($image_detail);

                   if($update_image != 1){
                   Session::flash('error',''.ucfirst($updated_info['name']).' image not update');
                   $this->activity(Auth::user()->name,Auth::user()->email,$updated_info['name'] .' accounts updation successfully','success');
                   // return redirect()->route('dashboard');
                   return response()->json([
                       'location' => route('dashboard')
                   ]);
                    }
                }
                Session::flash('success',''.ucfirst($updated_info['name']).' successfully updated');
                $this->activity(Auth::user()->name,Auth::user()->email,$updated_info['name'] .' accounts updation successfully','success');
                return response()->json([
                    'location' => route('dashboard')
                ]);
            }
            else{
                return response()->json([
                    'error' => 'Not Updated'
                ]); 
            }
            
        }
      
    }

    //
    public function user_profile(Request $request)
    {
        $user = User::find($request->id);
        $user_image= $user->images;      
        return response()->json([
            'user' => $user,
            'user_image'=>$user_image
        ]);
    }
    public function test_job(Request $request)
    {
        try{
            $users = User::all();
            //create batch 1
            $item = null; 
            if(isset($users) && $users->count() > 0)
            {
                // dispatch your queue job
                $item = new TestJob($users);
            }
            //dispatch batch
            $batch = Bus::batch([$item])->then(function ($batch){
                //get all activities
                $activites = ActivityLog::all();
                //delete opration
                DeleteActivitiesBulk::dispatch($activites);
            })->dispatch();

            return redirect()->route('activity.all',['batch_id'=>$batch->id]);
        }catch(\Exception $err)
        {
            return redirect()->route('activity.all');
        }
    }
}
