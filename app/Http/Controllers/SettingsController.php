<?php

namespace App\Http\Controllers;

use App\Helpers\Notifier;
use App\Http\Requests\Settings\DestroyAccountRequest;
use App\Http\Requests\Settings\UpdateAppearanceRequest;
use App\Http\Requests\Settings\UpdateNotificationsRequest;
use App\Http\Requests\Settings\UpdatePasswordRequest;
use App\Http\Requests\Settings\UpdateProfileRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();

        $setting = $user->setting()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        return view('settings.show', compact('setting'));
    }

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $user->update($request->validated());

        return redirect()
            ->route('settings.show', ['tab' => 'profile'])
            ->with('status', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        Notifier::notify($user, 'password_change', 'Contraseña cambiada', 'Tu contraseña fue actualizada exitosamente.');

        return redirect()
            ->route('settings.show', ['tab' => 'security'])
            ->with('status', 'Contraseña actualizada correctamente.');
    }

    public function updateNotifications(UpdateNotificationsRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $setting = $user->setting()->firstOrCreate(['user_id' => $user->id]);
        $setting->update($request->validated());

        return redirect()
            ->route('settings.show', ['tab' => 'notifications'])
            ->with('status', 'Preferencias de notificaciones actualizadas.');
    }

    public function updateAppearance(UpdateAppearanceRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $setting = $user->setting()->firstOrCreate(['user_id' => $user->id]);
        $setting->update($request->validated());

        return redirect()
            ->route('settings.show', ['tab' => 'appearance'])
            ->with('status', 'Apariencia actualizada.');
    }

    public function destroy(DestroyAccountRequest $request): RedirectResponse
    {
        $user = auth()->user();

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/');
    }
}
