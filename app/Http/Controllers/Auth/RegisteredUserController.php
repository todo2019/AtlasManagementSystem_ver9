<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use DB;

use App\Models\Users\Subjects;
use App\Models\Users\User;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

          $message = [
              'over_name.required' => 'ユーザー名は必須です。',
              'over_name.max' => 'ユーザー名は10文字以内で入力してください。',
              'under_name.required' => 'ユーザー名は必須です。',
              'under_name.max' => 'ユーザー名は10文字以内で入力してください。',
              'over_name_kana.required' => 'ユーザー名(カナ)は必須です。',
              'over_name_kana.regex:/^[ァ-ヶー]+$/u' => 'ユーザー名(カナ)はカタカナ表記のみです。',
              'over_name_kana.max' => 'ユーザー名(カナ)は30文字以内で入力してください。',
              'under_name_kana.required' => 'ユーザー名(カナ)は必須です。',
              'under_name_kana.regex:/^[ァ-ヶー]+$/u' => 'ユーザー名(カナ)はカタカナ表記のみです。',
              'under_name_kana.max' => 'ユーザー名(カナ)は30文字以内で入力してください。',
              'mail_address.required' => 'メールアドレスは必須です。',
              'mail_address.email' => '有効なメールアドレスを入力してください。',
              'mail_address.unique' => 'このメールアドレスは既に使用されています。',
              'mail_address.max' =>'メールアドレスは100文字以内で入力してください',
              'sex.required' =>'性別は選択必須です',
              'sex.in' =>'性別は男・女・その他のいずれかを選択してください',
              'old_year.required' => '生年月日の選択は必須です。',
              'old_month.required' => '生年月日の選択は必須です。',
              'old_day.required' => '生年月日の選択は必須です。',
              'role.required' =>'権限の選択は必須です。',
              'role.in' =>'権限は教師（各教科）・生徒から選択してください。',
              'password.required' => 'パスワードは必須です。',
              'password.alpha_num' => 'パスワードは英数字のみで入力してください。',
              'password.min' => 'パスワードは8文字以上で入力してください。',
              'password.max' => 'パスワードは30文字以内で入力してください。',
              'password.confirmed' => 'パスワード確認用と一致させてください。',
          ];

            $request->validate([
                'over_name' => 'required|string|max:10',
                'under_name' => 'required|string|max:10',
                'over_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:30',
                'under_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:30',
                'mail_address' => 'required|email|unique:users,email|max:100',
                'sex' => 'required|in:1,2,3',
                'old_year'  => 'required|integer|between:2000,' . date('Y'),
                'old_month' => 'required|integer|between:1,12',
                'old_day'   => 'required|integer|between:1,31',
                'role'      => 'required|in:1,2,3,4',
                'password'  => 'required|min:8|max:30|confirmed',
            ], $message);

        DB::beginTransaction();
        try{
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            if($request->role == 4){
                $user = User::findOrFail($user_get->id);
                $user->subjects()->attach($subjects);
            }
            DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
