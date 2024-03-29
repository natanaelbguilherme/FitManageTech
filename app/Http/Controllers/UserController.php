<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailWelcomeToUser;
use App\Models\Plan;
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

            $planType = Plan::find($user->plan_id);

            Mail::to($user->email, $user->name)
                ->send(new SendEmailWelcomeToUser($user->name, $planType->description, $planType->limit));

            return $user;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
