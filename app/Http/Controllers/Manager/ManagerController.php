<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ManagerController extends Controller
{
    /**
     * Display a listing of all managers.
     */
    public function index()
    {
        $managers = Manager::latest()->paginate(20);
        return view('manager.managers.index', compact('managers'));
    }

    /**
     * Show the form for creating a new manager.
     */
    public function create()
    {
        return view('manager.managers.create');
    }

    /**
     * Store a newly created manager.
     * Security: Validates passwords, ensures passwords are different, logs creation
     */
    public function store(Request $request)
    {
        // Strong validation rules
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:managers,username|regex:/^[a-zA-Z0-9_]+$/',
            'password_1' => [
                'required',
                'string',
                Password::min(12)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed'
            ],
            'password_2' => [
                'required',
                'string',
                Password::min(12)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed'
            ],
            'is_active' => 'boolean',
        ]);

        // Security: Ensure the two passwords are different
        if ($request->password_1 === $request->password_2) {
            return back()
                ->withErrors(['password_2' => __('The two passwords must be different for security.')])
                ->withInput();
        }

        // Security: Check if passwords are not compromised (basic check)
        if ($this->isCommonPassword($request->password_1) || $this->isCommonPassword($request->password_2)) {
            return back()
                ->withErrors(['password_1' => __('Password is too common or weak. Please choose a stronger password.')])
                ->withInput();
        }

        // Create the manager
        $manager = Manager::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password_1' => Hash::make($validated['password_1']),
            'password_2' => Hash::make($validated['password_2']),
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Security: Log the creation for audit trail
        \Log::info('New manager created', [
            'created_manager_id' => $manager->id,
            'created_by' => Auth::guard('manager')->id(),
            'username' => $manager->username,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('manager.managers.index')
            ->with('success', __('Manager :name created successfully.', ['name' => $manager->name]));
    }

    /**
     * Remove the specified manager.
     * Security: Prevent self-deletion, log deletion
     */
    public function destroy(Manager $manager)
    {
        $currentManagerId = Auth::guard('manager')->id();

        // Security: Prevent manager from deleting themselves
        if ($manager->id === $currentManagerId) {
            return back()->with('error', __('You cannot delete your own account.'));
        }

        // Security: Prevent deleting the last active manager
        $activeManagersCount = Manager::where('is_active', true)->count();
        if ($activeManagersCount <= 1 && $manager->is_active) {
            return back()->with('error', __('Cannot delete the last active manager.'));
        }

        // Log the deletion before actually deleting
        \Log::warning('Manager deleted', [
            'deleted_manager_id' => $manager->id,
            'deleted_by' => $currentManagerId,
            'username' => $manager->username,
            'ip' => request()->ip(),
        ]);

        $managerName = $manager->name;
        $manager->delete();

        return redirect()->route('manager.managers.index')
            ->with('success', __('Manager :name deleted successfully.', ['name' => $managerName]));
    }

    /**
     * Check if password is commonly used (basic list)
     */
    private function isCommonPassword(string $password): bool
    {
        $commonPasswords = [
            'password', '123456', '12345678', 'qwerty', 'abc123',
            'password123', 'admin', 'letmein', 'welcome', 'monkey',
            '1234567890', 'football', 'iloveyou', 'admin123', 'welcome123'
        ];

        return in_array(strtolower($password), $commonPasswords);
    }
}
