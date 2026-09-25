<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Services\ActivityService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $activities = Activity::query()
            ->filterStatus($status)
            ->orderBy('activity_date')
            ->get();

        return view('activities.index', compact('activities', 'status'));
    }



    public function create(): View
    {
        return view('activities.create');
    }

    // Menggunakan ActivityService untuk create
    public function store(StoreActivityRequest $request, ActivityService $service): RedirectResponse
    {
        $service->create($request->validated());

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show(Activity $activity): View
    {
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', compact('activity'));
    }

    // Menggunakan ActivityService dan menangani DomainException
    public function update(
        UpdateActivityRequest $request,
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        try {
            $service->update($activity, $request->validated());

            return redirect()
                ->route('activities.show', $activity)
                ->with('success', 'Kegiatan berhasil diperbarui.');
        } catch (DomainException $e) {
            // Jika transisi status ilegal, kembalikan user ke form dengan pesan error pada field status
            return back()
                ->withInput()
                ->withErrors(['status' => $e->getMessage()]);
        }
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
