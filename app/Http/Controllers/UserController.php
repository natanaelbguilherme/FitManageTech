<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailWelcomeToUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $request->validate([
                'name' => 'string|required',
                'email' => 'string|required|unique:users',
                'date_birth' => 'string|required',
                'cpf' => 'string|required|max:14|unique:users',
                'password' => 'string|required|min:8|max:32',
                'plan_id' => 'integer|required'
            ]);

            $user = User::create($data);

            Mail::to('natanaelbguilherme@gmail.com', 'natanael')
                ->send(new SendEmailWelcomeToUser());

            return $user;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
