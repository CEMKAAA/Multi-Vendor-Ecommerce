<?php

namespace App\Http\Controllers\AuthUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function sendVerificationEmail($email, $token)
    {
        Mail::to($email)->send(new EmailVerification($token));

        // Additional code or response as needed
    }

    public function register(Request $request)
    {
        // Check if method is POST
        if ($request->isMethod('post')) {
            $data = $request->all(); // Add request data to an array

            // Validate the request
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'real_email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                'name.required' => 'ad zorunludur',
                'name.string' => 'ad rakam içeremez',
                'password.required' => 'şifre zorunludur',
                'email.unique' => 'aldığınız emaile sahip bir kullanıcı zaten bulunmakta'
            ]);

            $validator->sometimes('email', 'real_email', function ($data) {
                // Additional condition to only perform email verification if other validation rules pass
                return !empty($data['email']);
            });

            $validator->addExtension('real_email', function ($attribute, $value, $parameters) {
                // Perform email verification here using an email verification service or custom logic
                // Return true if the email is considered real, or false if it's not

                // Example using a simple domain existence check
                $domain = explode('@', $value)[1];
                return checkdnsrr($domain, 'MX');
            });

            if ($validator->fails()) {
                return new JsonResponse([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $verificationToken = Str::random(60);
            $expirationTime = Carbon::now()->addMinutes(5);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verification_token' => $verificationToken,
                'verification_token_expires_at' => $expirationTime
            ]);

            event(new Registered($user));

            //$this->sendVerificationEmail($user->email, $verificationToken);

            return new JsonResponse([
                'message' => 'Email addressinize onay maili gönderilmiştir. Onu onaylamanız gerekiyor.',
                'user' => $user
            ]);
        }
    }

    public function hello()
    {

        return new JsonResponse([
            'data' => [
                'message' =>  'hello'
            ]
        ]);
    }

    public function sendAgain(User $user)
    {
        $verificationToken = Str::random(60);
        $expirationTime = Carbon::now()->addMinutes(5);

        $email = $user->email;

        $user->verification_token = $verificationToken;
        $user->verification_token_expires_at = $expirationTime;

        if ($user->save()) {
            $this->sendVerificationEmail($email, $verificationToken);
            return new JsonResponse([
                'message' => 'Yeni bir onay tokeni gönderildi.'
            ]);
        } else {
            return new JsonResponse([
                'errors' => 'Beklenmedik bir hata oluştu.'
            ]);
        }
    }

    public function verify($token)
    {
        if (empty($token)) {
            return new JsonResponse([
                'error' => 'Token yok.'
            ]);
        } else {
            $user = User::where('verification_token', $token)
                ->whereNull('email_verified_at')
                ->where('verification_token_expires_at', '>', Carbon::now())
                ->first();

            if (!$user) {
                return response()->json([
                    'message' => 'Geçersiz veya süresi dolmuş onaylama kodu.',
                ], 404);
            }

            $user->email_verified_at = Carbon::now();
            $user->verification_token = null;
            $user->verification_token_expires_at = null;
            $user->is_verified = "Yes";

            if ($user->save()) {
                Auth::login($user);

                return response()->json([
                    'message' => 'Email onaylama işlemi başarılı.',
                    'user' => $user
                ]);
            } else {
                return new JsonResponse([
                    'error' => 'Beklenmedik bir hata oluştu.'
                ]);
            }
        }
    }
}

