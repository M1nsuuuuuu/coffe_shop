<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }
    
    // Переопределяем метод для проверки номера телефона
    protected function validatePhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone',
        ], [
            'phone.exists' => 'Неправильно введён номер телефона.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}