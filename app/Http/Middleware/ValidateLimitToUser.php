<?php

namespace App\Http\Middleware;

use App\Models\Plan;
use App\Models\Student;
use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateLimitToUser
{

    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user_id = $request->user()->id;
        $plan_id = $request->user()->plan_id;

        $planType = Plan::find($plan_id);

        $count = Student::where('user_id', $user_id)->count();

        if ($planType->limit == 0) return $next($request);

        if ($count >= $planType->limit) return $this->error('voce atingiu o maximo de estudantes', Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}