<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateType;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_active' => 'nullable',
            'max_participants' => 'nullable|integer|min:1',
            'certificate_template' => 'nullable|file|mimes:png,jpg,jpeg|max:5120',
            'poster' => 'nullable|file|mimes:png,jpg,jpeg|max:5120',
            'certificate_number_prefix' => 'nullable|string|max:255',
            'claim_deadline' => 'nullable|date',
            'requires_attendance_proof' => 'nullable',
            'requires_payment_proof' => 'nullable',
        ]);

        $templatePath = null;
        if ($request->hasFile('certificate_template')) {
            $templatePath = $request->file('certificate_template')->store('certificate-templates', 'public');
        }

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('event-posters', 'public');
        }

        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'is_active' => $request->has('is_active'),
            'max_participants' => $request->max_participants,
            'certificate_template' => $templatePath,
            'poster' => $posterPath,
            'overlay_name_top' => $request->input('overlay_name_top', 40),
            'overlay_name_left' => $request->input('overlay_name_left', 50),
            'overlay_name_size' => $request->input('overlay_name_size', 26),
            'overlay_name_color' => $request->input('overlay_name_color', '#1a2e6e'),
            'overlay_role_top' => $request->input('overlay_role_top', 52),
            'overlay_role_left' => $request->input('overlay_role_left', 50),
            'overlay_role_size' => $request->input('overlay_role_size', 20),
            'overlay_role_text' => $request->input('overlay_role_text', 'Peserta'),
            'overlay_role_color' => $request->input('overlay_role_color', '#1a2e6e'),
            'certificate_number_prefix' => $request->certificate_number_prefix,
            'claim_deadline' => $request->claim_deadline ?: null,
            'requires_attendance_proof' => $request->has('requires_attendance_proof'),
            'requires_payment_proof' => $request->has('requires_payment_proof'),
        ]);

        $this->syncCertificateTypes($event, $request->input('certificate_types', []));

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $event->load('certificateTypes');
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $event->load('certificateTypes');
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_active' => 'nullable',
            'max_participants' => 'nullable|integer|min:1',
            'certificate_template' => 'nullable|file|mimes:png,jpg,jpeg|max:5120',
            'poster' => 'nullable|file|mimes:png,jpg,jpeg|max:5120',
            'certificate_number_prefix' => 'nullable|string|max:255',
            'claim_deadline' => 'nullable|date',
            'requires_attendance_proof' => 'nullable',
            'requires_payment_proof' => 'nullable',
        ]);

        $templatePath = $event->certificate_template;
        if ($request->hasFile('certificate_template')) {
            // Delete old template if exists
            if ($event->certificate_template) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->certificate_template);
            }
            $templatePath = $request->file('certificate_template')->store('certificate-templates', 'public');
        }

        $posterPath = $event->poster;
        if ($request->hasFile('poster')) {
            // Delete old poster if exists
            if ($event->poster) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->poster);
            }
            $posterPath = $request->file('poster')->store('event-posters', 'public');
        }

        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'is_active' => $request->has('is_active'),
            'max_participants' => $request->max_participants,
            'certificate_template' => $templatePath,
            'poster' => $posterPath,
            'overlay_name_top' => $request->input('overlay_name_top', $event->overlay_name_top),
            'overlay_name_left' => $request->input('overlay_name_left', $event->overlay_name_left),
            'overlay_name_size' => $request->input('overlay_name_size', $event->overlay_name_size),
            'overlay_name_color' => $request->input('overlay_name_color', $event->overlay_name_color),
            'overlay_role_top' => $request->input('overlay_role_top', $event->overlay_role_top),
            'overlay_role_left' => $request->input('overlay_role_left', $event->overlay_role_left),
            'overlay_role_size' => $request->input('overlay_role_size', $event->overlay_role_size),
            'overlay_role_text' => $request->input('overlay_role_text', $event->overlay_role_text),
            'overlay_role_color' => $request->input('overlay_role_color', $event->overlay_role_color),
            'certificate_number_prefix' => $request->certificate_number_prefix,
            'claim_deadline' => $request->claim_deadline ?: null,
            'requires_attendance_proof' => $request->has('requires_attendance_proof'),
            'requires_payment_proof' => $request->has('requires_payment_proof'),
        ]);

        $this->syncCertificateTypes($event, $request->input('certificate_types', []));

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    private function syncCertificateTypes(Event $event, array $types): void
    {
        $existingIds = $event->certificateTypes()->pluck('id')->toArray();
        $submittedIds = [];

        foreach ($types as $i => $type) {
            if (empty($type['name'])) continue;

            $data = [
                'event_id'                   => $event->id,
                'name'                       => $type['name'],
                'role_text'                  => $type['role_text'] ?? null,
                'certificate_number_prefix'  => $type['certificate_number_prefix'] ?? null,
                'sort_order'                 => $i,
                'is_active'                  => true,
            ];

            if (!empty($type['id']) && in_array($type['id'], $existingIds)) {
                CertificateType::where('id', $type['id'])->update($data);
                $submittedIds[] = (int) $type['id'];
            } else {
                $ct = CertificateType::create($data);
                $submittedIds[] = $ct->id;
            }
        }

        // Delete removed types only if no certificates depend on them
        $toDelete = array_diff($existingIds, $submittedIds);
        foreach ($toDelete as $id) {
            $ct = CertificateType::find($id);
            if ($ct && $ct->certificates()->count() === 0) {
                $ct->delete();
            }
        }
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function toggleStatus(Event $event)
    {
        $event->update(['is_active' => !$event->is_active]);
        return redirect()->back()
            ->with('success', 'Event status updated successfully.');
    }
}
