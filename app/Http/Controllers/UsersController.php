<?php

namespace App\Http\Controllers;

use DataTables; 
use Carbon\Carbon;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Ui\Presets\React;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminResetNotification;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{

    use SendsPasswordResetEmails;
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       
        if($request->ajax())
        {
            return $this->getUsers();
        }
        return view('users.index')->with(["roles" => Role::get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required', 
            'department' => 'required', 
            'email' => 'required|email:rfc,dns|unique:users,email'
        ],
        [
            'email.unique' => __('messages.email.unique'),
        ]);


        if($request->has('roles'))
        {
            $user->create($request->all())->roles()->sync($request->roles);
        }else{            
            $user->create($request->all());
        }
        if($user)
        {
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
         
            // Mail::to($request->email)->send(new AdminResetNotification($request, 'asaaaaa'));
            toast(__('messages.user_create'),'success');
            return Redirect::to('users');

        }
        toast('Error Creating New User','error');
        return back()->withInput();
    }

    // public function sendResetLinkEmail(Request $request)
    // {
    //     $this->validateEmail($request);
    //     $response = $this->broker()->sendResetLink(
    //         $this->credentials($request)
    //     );
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (empty($user) || Auth::id() ==  $user->id) {
            abort(403);
        }
        return view('users.edit', [
            "user" => $user, 
            "userRole" => $user->roles->pluck('name')->toArray(), 
            "roles" => Role::latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
    //    dd($request->all(),Auth::id(),$user->id);
       if(Auth::id() == $user->id) {
            $this->validate($request, [
                'name' => 'required'
            ]); 
            
            // dd($request->current_password);
            if($request->current_password != null || $request->password != null || $request->password_confirmation != null) {
                $request->validate([
                    'password' => 'required|confirmed|required_with:current_password|min:8',
                    'password_confirmation' => 'required|same:password',
                    'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                        if (!\Hash::check($value, $user->password)) {
                            return $fail(__('validation.current_password_incorrect'));
                        }
                    }],
                ],
                [
                    'password.confirmed' => __('validation.password_required_with_current_password'),
                    'same' => '新しいパスワードパスワードの確認は一致する必要があります。',
                ]);
            }
            $user->update($request->all());
       } else {
            $this->validate($request, [
                'name' => 'required', 
                'email' => 'required|email:rfc,dns|unique:users,email,'.$user->id,
            ]); 
            
            $user->update($request->all());
            $user->roles()->sync($request->input('roles'));
       } 
      
        if($user)
        {
            toast(__('messages.user_update'),'success');
            return Redirect::to('profile');
        }
        toast('Error in User Update','error');
        return back()->withInput();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if($request->ajax() && $user->delete())
        {
            return response(["message" => "User Deleted Successfully"], 200);
        }
        return response(["message" => "Data Delete Error! Please Try again"], 201);
    }

    private function getUsers($id = 0)
    {
        $data = User::with('roles')->where('id', '<>', $id == 0 ? Auth::user()->id : $id)->get();
        return DataTables::of($data)
                ->addColumn('name', function($row){
                    return ucfirst($row->name);
                })
                ->addColumn('date', function($row){
                    return Carbon::parse($row->created_at)->format('d M, Y h:i:s A');
                })
                ->addColumn('roles', function($row){
                    $role = ""; 
                    if($row->roles != null)
                    {
                        foreach($row->roles as $next)
                        {
                            // $role.='<span class="badge badge-primary">'.ucfirst($next->name).'</span> ';
                            $role.=ucfirst($next->name);
                        }
                    }
                    return $role;
                })
                ->addColumn('action', function($row){
                    $action = ""; 
                    if(Auth::user()->can('users.edit'))
                    {
                        $action.="<a class='btn btn-xs btn-warning' id='btnEdit' href='".route('users.edit', $row->id)."'><i class='fas fa-edit'></i></a>"; 
                    }
                    if(Auth::user()->can('users.destroy'))
                    {
                        $action.=" <button class='btn btn-xs btn-outline-danger' id='btnDel' data-id='".$row->id."'><i class='fas fa-trash'></i></button>"; 
                    }
                    return $action;
                })
                ->rawColumns(['name', 'date','roles', 'action'])->make('true');
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();
        if (empty($user)) {
            abort(403);
        }
        return view('users.profile', [
            "user" => $user, 
            "userRole" => $user->roles->pluck('name')->toArray(), 
            "roles" => Role::latest()->get()
        ]);
    }
}
