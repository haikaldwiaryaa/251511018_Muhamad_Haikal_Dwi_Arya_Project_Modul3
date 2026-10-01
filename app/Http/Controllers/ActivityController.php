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
use App\Models\Category;
class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $status = $request->query('status');
        $sort = $request->query('sort', 'desc'); // default terbaru
        $activities = Activity::query()
            ->with('category') // eager loading
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($q, $catId) {
                $q->where('category_id', $catId);
            })
            ->when($status, function ($q, $st) {
                $q->where('status', $st);
            })
            ->orderBy('activity_date', $sort === 'asc' ? 'asc' : 'desc')
            ->paginate(10)
            ->withQueryString();
        $categories = Category::all();
        return view('activities.index', compact('activities', 'categories', 'search', 'categoryId', 'status', 'sort'));
    }



    public function create(): View
    {
        $categories = Category::all();
        return view('activities.create', compact('categories'));
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
        $categories = Category::all();
        return view('activities.edit', compact('activity', 'categories'));
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
    public function publish(Activity $activity, ActivityService $service): RedirectResponse
    {
        try {
            $service->publish($activity);
            return back()->with('success', 'Kegiatan berhasil dipublikasikan.');
        } catch (DomainException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function complete(Activity $activity, ActivityService $service): RedirectResponse
    {
        try {
            $service->complete($activity);
            return back()->with('success', 'Kegiatan berhasil diselesaikan.');
        } catch (DomainException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function trash(): View
    {
        $activities = Activity::onlyTrashed()
            ->with('category')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('activities.trash', compact('activities'));
    }

    public function restore(int $id): RedirectResponse
    {
        $activity = Activity::onlyTrashed()->findOrFail($id);
        $activity->restore();

        return redirect()
            ->route('activities.trash')
            ->with('success', 'Kegiatan berhasil dipulihkan (restore).');
    }
}
