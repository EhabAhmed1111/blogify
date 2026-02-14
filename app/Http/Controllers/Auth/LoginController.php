<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): array
    {
        $request->authenticate();

        $user = $request->user();
        $token = $user->createToken("main")->plainTextToken;

        return [
            'user' => new UserResource($user),
            'token' => $token
        ]; 
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        \Log::info('Logout attempt', [
            'headers' => $request->headers->all(),
            'bearer_token' => $request->bearerToken(),
            'user' => $request->user(),
            'all_tokens' => $request->user() ? $request->user()->tokens->toArray() : 'No user'
        ]);
    
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    
        // Try different approaches
        try {
            // Approach 1: Delete current token
            $request->user()->currentAccessToken()->delete();
            
            // Approach 2: If above fails, delete by token string
            // $token = $request->bearerToken();
            // $request->user()->tokens()->where('token', hash('sha256', $token))->delete();
            
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Logout failed: ' . $e->getMessage()], 500);
        }
    }
}
