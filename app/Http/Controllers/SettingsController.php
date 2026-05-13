<?php

namespace App\Http\Controllers;

use App\Models\GymInfo;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct(protected SettingService $settings)
    {
    }

    /**
     * Show the settings form.
     */
    public function index(Request $request)
    {
        $settings = $this->settings->all([
            'currency' => 'USD',
            'currency_symbol' => '$',
            'currency_position' => 'before',
            'default_plan_duration' => 1,
            'allow_partial_payments' => false,
            'enable_debt_system' => false,
            'enable_email_notifications' => true,
            'notification_reminder_days' => 3,
            'enable_whatsapp_notifications' => false,
            'enable_offline_mode' => false,
            'auto_backup_enabled' => false,
            'backup_retention_count' => 7,
            'theme' => 'light',
            'accent_color' => 'blue',
            'gym_name' => GymInfo::getInstance()->gym_name,
            'address' => GymInfo::getInstance()->address,
            'phone' => GymInfo::getInstance()->phone,
            'email' => GymInfo::getInstance()->email,
        ]);

        $gymInfo = GymInfo::getInstance();
        $activeSection = $request->query('section', 'general');

        return view('settings.index', compact('settings', 'gymInfo', 'activeSection'));
    }

    /**
     * Update section-specific settings.
     */
    public function update(Request $request, string $section = 'general')
    {
        match ($section) {
            'currency' => $this->updateCurrency($request),
            'membership' => $this->updateMembership($request),
            'notifications' => $this->updateNotifications($request),
            'system' => $this->updateSystem($request),
            'ui' => $this->updateUi($request),
            default => abort(404),
        };

        return redirect()->route('settings.index', ['section' => $section])
            ->with('success', ucfirst($section) . ' settings saved successfully.');
    }

    protected function updateCurrency(Request $request): void
    {
        $data = $request->validate([
            'currency' => 'required|string|max:8',
            'currency_symbol' => 'required|string|max:8',
            'currency_position' => 'required|in:before,after',
        ]);

        $this->settings->set('currency', $data['currency'], 'string');
        $this->settings->set('currency_symbol', $data['currency_symbol'], 'string');
        $this->settings->set('currency_position', $data['currency_position'], 'string');
    }

    protected function updateMembership(Request $request): void
    {
        $data = $request->validate([
            'default_plan_duration' => 'required|integer|min:1|max:24',
            'allow_partial_payments' => 'sometimes|boolean',
            'enable_debt_system' => 'sometimes|boolean',
        ]);

        $this->settings->set('default_plan_duration', $data['default_plan_duration'], 'integer');
        $this->settings->set('allow_partial_payments', $request->boolean('allow_partial_payments'), 'boolean');
        $this->settings->set('enable_debt_system', $request->boolean('enable_debt_system'), 'boolean');
    }

    protected function updateNotifications(Request $request): void
    {
        $data = $request->validate([
            'enable_email_notifications' => 'sometimes|boolean',
            'notification_reminder_days' => 'required|integer|min:1|max:30',
            'enable_whatsapp_notifications' => 'sometimes|boolean',
        ]);

        $this->settings->set('enable_email_notifications', $request->boolean('enable_email_notifications'), 'boolean');
        $this->settings->set('notification_reminder_days', $data['notification_reminder_days'], 'integer');
        $this->settings->set('enable_whatsapp_notifications', $request->boolean('enable_whatsapp_notifications'), 'boolean');
    }

    protected function updateSystem(Request $request): void
    {
        $data = $request->validate([
            'enable_offline_mode' => 'sometimes|boolean',
            'auto_backup_enabled' => 'sometimes|boolean',
            'backup_retention_count' => 'required|integer|min:1|max:30',
        ]);

        $this->settings->set('enable_offline_mode', $request->boolean('enable_offline_mode'), 'boolean');
        $this->settings->set('auto_backup_enabled', $request->boolean('auto_backup_enabled'), 'boolean');
        $this->settings->set('backup_retention_count', $data['backup_retention_count'], 'integer');
    }

    protected function updateUi(Request $request): void
    {
        $data = $request->validate([
            'theme' => 'required|in:light,dark',
            'accent_color' => 'required|in:blue,green,pink',
        ]);

        $this->settings->set('theme', $data['theme'], 'string');
        $this->settings->set('accent_color', $data['accent_color'], 'string');
    }

    /**
     * Update gym information.
     */
    public function updateGymInfo(Request $request)
    {
        $data = $request->validate([
            'gym_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $gymInfo = GymInfo::getInstance();

        if ($request->hasFile('logo')) {
            if ($gymInfo->logo_path && Storage::disk('public')->exists($gymInfo->logo_path)) {
                Storage::disk('public')->delete($gymInfo->logo_path);
            }

            $path = $request->file('logo')->store('gym-logos', 'public');
            $data['logo_path'] = $path;
        }

        $gymInfo->update($data);

        return redirect()->route('settings.index', ['section' => 'general'])->with('success', 'Gym information updated successfully.');
    }

    /**
     * Delete gym information (reset to defaults).
     */
    public function deleteGymInfo()
    {
        $gymInfo = GymInfo::getInstance();

        $gymInfo->update([
            'gym_name' => 'My Gym',
            'address' => '',
            'phone' => '',
            'email' => '',
            'logo_path' => null,
        ]);

        if ($gymInfo->logo_path && Storage::disk('public')->exists($gymInfo->logo_path)) {
            Storage::disk('public')->delete($gymInfo->logo_path);
        }

        return redirect()->route('settings.index', ['section' => 'general'])->with('success', 'Gym information reset to defaults.');
    }

    /**
     * Delete gym logo.
     */
    public function deleteLogo()
    {
        $gymInfo = GymInfo::getInstance();

        if ($gymInfo->logo_path && Storage::disk('public')->exists($gymInfo->logo_path)) {
            Storage::disk('public')->delete($gymInfo->logo_path);
        }

        $gymInfo->update(['logo_path' => null]);

        return redirect()->route('settings.index', ['section' => 'general'])->with('success', 'Logo deleted successfully.');
    }
}
