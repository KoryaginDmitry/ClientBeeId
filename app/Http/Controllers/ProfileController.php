<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Services\BeeOnline\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    /**
     * Страница просмотра профиля
     *
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('pages.profile.show', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Страница редактирования профиля
     *
     * @return Application|Factory|View
     */
    public function edit()
    {
        return view('pages.profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(UpdateUserRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $user->update($request->validated());

        $this->service->updateUser($user, $request->validated());

        return redirect()->route('profile.show');
    }
}
