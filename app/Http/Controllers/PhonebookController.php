<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Phonebook;
use App\Models\Contact;

class PhonebookController extends Controller
{
    // --- WhatsApp Phonebooks ---

    public function indexWa()
    {
        $phonebooks = Phonebook::where('user_id', Auth::id())
            ->withCount('contacts')
            ->where('type', 'wa')
            ->latest()
            ->get();
        return view('phonebook', compact('phonebooks'));
    }

    public function storeWa(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100', 'description' => 'nullable|string|max:255']);
        Phonebook::create([
            'user_id'     => Auth::id(),
            'name'        => $request->name, 
            'description' => $request->description, 
            'type'        => 'wa'
        ]);
        return back()->with('success', 'Phonebook berhasil dibuat!');
    }

    public function destroyWa(Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id(), 403);
        $phonebook->contacts()->delete();
        $phonebook->delete();
        return back()->with('success', 'Phonebook berhasil dihapus.');
    }

    public function contactsWa(Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id(), 403);
        $contacts = $phonebook->contacts()->latest()->get();
        return view('phonebook-contacts', compact('phonebook', 'contacts'));
    }

    public function contactsJson(Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id(), 403);
        $contacts = $phonebook->contacts()->select('id', 'name', 'phone')->orderBy('name')->get();
        return response()->json(['success' => true, 'contacts' => $contacts]);
    }

    public function storeContactWa(Request $request, Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id(), 403);
        $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|string|max:50',
        ]);
        
        $phone = preg_replace('/@.*$/', '', (string)$request->phone);
        $phone = preg_replace('/:\d+$/', '', $phone);
        $phone = preg_replace('/\D/', '', $phone);
        
        if (str_starts_with($phone, '08')) {
            $phone = '628' . substr($phone, 2);
        } elseif (str_starts_with($phone, '8') && strlen($phone) >= 9 && strlen($phone) <= 13) {
            $phone = '628' . substr($phone, 1);
        }
        
        if (empty($phone) || strlen($phone) < 9 || strlen($phone) > 16) {
            return back()->with('error', 'Nomor telepon tidak valid. Pastikan memasukkan nomor HP asli minimal 9 digit (contoh: 08123456789 atau 628123456789).')->withInput();
        }
        
        if ($phonebook->contacts()->where('phone', $phone)->exists()) {
            return back()->with('error', 'Nomor +' . $phone . ' sudah ada di phonebook ini.')->withInput();
        }
        
        $name = trim((string)$request->name);
        if (empty($name) || str_contains($name, '@') || $name === $phone) {
            $name = '+' . $phone;
        }

        $phonebook->contacts()->create([
            'name'  => $name,
            'phone' => $phone,
        ]);
        return back()->with('success', 'Kontak +' . $phone . ' berhasil ditambahkan!');
    }

    public function destroyContactWa(Phonebook $phonebook, Contact $contact)
    {
        abort_if($phonebook->user_id !== Auth::id() || $contact->phonebook_id !== $phonebook->id, 403);
        $contact->delete();
        return back()->with('success', 'Kontak dihapus.');
    }

    public function importContacts(Request $request, Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id(), 403);
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        if (!$handle) {
            return back()->with('error', 'Gagal membaca file CSV.');
        }

        $now = now()->toDateTimeString();
        $importedCount = 0;
        $contacts = [];
        $existingPhones = $phonebook->contacts()->pluck('phone')->flip()->toArray();

        $rowIndex = 0;
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($row) === 1 && str_contains($row[0], ';')) {
                $row = explode(';', $row[0]);
            }

            $rowIndex++;
            if ($rowIndex === 1) {
                $firstCol = strtolower(trim($row[0] ?? ''));
                if (in_array($firstCol, ['nama', 'name', 'phone', 'nomor', 'no_hp', 'no hp', 'telepon', 'kontak'])) {
                    continue;
                }
            }

            $name = trim($row[0] ?? '');
            $rawPhone = trim($row[1] ?? ($row[0] ?? ''));

            if (count($row) === 1 || empty($row[1])) {
                $rawPhone = $name;
                $name = '';
            }

            $phone = preg_replace('/@.*$/', '', $rawPhone);
            $phone = preg_replace('/:\d+$/', '', $phone);
            $phone = preg_replace('/\D/', '', $phone);

            if (str_starts_with($phone, '08')) {
                $phone = '628' . substr($phone, 2);
            } elseif (str_starts_with($phone, '8') && strlen($phone) >= 9 && strlen($phone) <= 13) {
                $phone = '628' . substr($phone, 1);
            }

            if (empty($phone) || strlen($phone) < 8 || strlen($phone) > 16) {
                continue;
            }

            if (isset($existingPhones[$phone])) {
                continue;
            }

            $existingPhones[$phone] = true;

            if (empty($name) || $name === $rawPhone) {
                $name = '+' . $phone;
            }

            $contacts[] = [
                'phonebook_id' => $phonebook->id,
                'name'         => substr($name, 0, 100),
                'phone'        => $phone,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
            $importedCount++;
        }
        fclose($handle);

        if (!empty($contacts)) {
            foreach (array_chunk($contacts, 500) as $chunk) {
                Contact::insertOrIgnore($chunk);
            }
        }

        return back()->with('success', "{$importedCount} kontak berhasil diimpor ke {$phonebook->name}!");
    }

    public function exportContacts(Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id(), 403);

        $fileName = 'contacts_' . \Illuminate\Support\Str::slug($phonebook->name) . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($phonebook) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF"); // UTF-8 BOM
            fputcsv($handle, ['Nama', 'Nomor HP', 'Ditambahkan']);

            $phonebook->contacts()->orderBy('id')->chunk(500, function ($contacts) use ($handle) {
                foreach ($contacts as $c) {
                    fputcsv($handle, [
                        $c->name,
                        '+' . $c->phone,
                        $c->created_at ? $c->created_at->format('Y-m-d H:i:s') : ''
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // --- SMS Phonebooks ---

    public function indexSms()
    {
        $phonebooks = Phonebook::where('user_id', Auth::id())
            ->withCount('contacts')
            ->where('type', 'sms')
            ->latest()
            ->get();
        return view('phonebook-sms', compact('phonebooks'));
    }

    public function storeSms(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        Phonebook::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'type' => 'sms'
        ]);
        return back()->with('success', 'SMS Phonebook created successfully!');
    }

    public function destroySms(Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id() || $phonebook->type !== 'sms', 403);
        $phonebook->contacts()->delete();
        $phonebook->delete();
        return back()->with('success', 'SMS Phonebook deleted successfully.');
    }

    public function contactsSms(Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id() || $phonebook->type !== 'sms', 403);
        $contacts = $phonebook->contacts()->latest()->get();
        return view('phonebook-sms-contacts', compact('phonebook', 'contacts'));
    }

    public function storeContactSms(Request $request, Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id() || $phonebook->type !== 'sms', 403);
        $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|string|max:50',
        ]);
        
        $phone = preg_replace('/@.*$/', '', (string)$request->phone);
        $phone = preg_replace('/:\d+$/', '', $phone);
        $phone = preg_replace('/\D/', '', $phone);
        
        if (str_starts_with($phone, '08')) {
            $phone = '628' . substr($phone, 2);
        } elseif (str_starts_with($phone, '8') && strlen($phone) >= 9 && strlen($phone) <= 13) {
            $phone = '628' . substr($phone, 1);
        }
        
        if (empty($phone) || strlen($phone) < 9 || strlen($phone) > 16) {
            return back()->with('error', 'Nomor telepon SMS tidak valid. Masukkan nomor HP asli minimal 9 digit.')->withInput();
        }
        
        if ($phonebook->contacts()->where('phone', $phone)->exists()) {
            return back()->with('error', 'Nomor +' . $phone . ' sudah terdaftar di phonebook ini.')->withInput();
        }
        
        $name = trim((string)$request->name);
        if (empty($name) || str_contains($name, '@') || $name === $phone) {
            $name = '+' . $phone;
        }

        $phonebook->contacts()->create([
            'name'  => $name,
            'phone' => $phone,
        ]);
        return back()->with('success', 'Kontak SMS +' . $phone . ' berhasil ditambahkan.');
    }

    public function destroyContactSms(Phonebook $phonebook, Contact $contact)
    {
        abort_if($phonebook->user_id !== Auth::id() || $contact->phonebook_id !== $phonebook->id, 403);
        $contact->delete();
        return back()->with('success', 'Contact deleted successfully.');
    }

    // --- VoIP & TTS Voice Phonebooks ---

    public function indexTts()
    {
        $phonebooks = Phonebook::where('user_id', Auth::id())
            ->withCount('contacts')
            ->where('type', 'tts')
            ->latest()
            ->get();
        return view('phonebook-tts', compact('phonebooks'));
    }

    public function storeTts(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        Phonebook::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'type' => 'tts'
        ]);
        return back()->with('success', 'VoIP / TTS Phonebook berhasil dibuat!');
    }

    public function destroyTts(Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id() || $phonebook->type !== 'tts', 403);
        $phonebook->contacts()->delete();
        $phonebook->delete();
        return back()->with('success', 'VoIP / TTS Phonebook berhasil dihapus.');
    }

    public function contactsTts(Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id() || $phonebook->type !== 'tts', 403);
        $contacts = $phonebook->contacts()->latest()->get();
        return view('phonebook-tts-contacts', compact('phonebook', 'contacts'));
    }

    public function storeContactTts(Request $request, Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id() || $phonebook->type !== 'tts', 403);
        $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|string|max:50',
        ]);
        
        $phone = preg_replace('/@.*$/', '', (string)$request->phone);
        $phone = preg_replace('/:\d+$/', '', $phone);
        $phone = preg_replace('/\D/', '', $phone);
        
        if (empty($phone) || strlen($phone) < 3 || strlen($phone) > 16) {
            return back()->with('error', 'Nomor telepon / ekstensi tidak valid. Masukkan nomor ekstensi (misal: 9999, 101) atau nomor telepon minimal 3 digit.')->withInput();
        }
        
        if ($phonebook->contacts()->where('phone', $phone)->exists()) {
            return back()->with('error', 'Nomor/ekstensi ' . $phone . ' sudah terdaftar di phonebook ini.')->withInput();
        }
        
        $name = trim((string)$request->name);
        if (empty($name) || str_contains($name, '@') || $name === $phone) {
            $name = (strlen($phone) <= 5 ? 'Ekstensi ' : 'Kontak ') . $phone;
        }

        $phonebook->contacts()->create([
            'name'  => $name,
            'phone' => $phone,
        ]);
        return back()->with('success', 'Kontak ' . $phone . ' (' . $name . ') berhasil ditambahkan!');
    }

    public function destroyContactTts(Phonebook $phonebook, Contact $contact)
    {
        abort_if($phonebook->user_id !== Auth::id() || $contact->phonebook_id !== $phonebook->id, 403);
        $contact->delete();
        return back()->with('success', 'Kontak berhasil dihapus.');
    }

    public function importContactsTts(Request $request, Phonebook $phonebook)
    {
        abort_if($phonebook->user_id !== Auth::id() || $phonebook->type !== 'tts', 403);
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        if (!$handle) {
            return back()->with('error', 'Gagal membaca file CSV.');
        }

        $now = now()->toDateTimeString();
        $importedCount = 0;
        $contacts = [];
        $existingPhones = $phonebook->contacts()->pluck('phone')->flip()->toArray();

        $rowIndex = 0;
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($row) === 1 && str_contains($row[0], ';')) {
                $row = explode(';', $row[0]);
            }

            $rowIndex++;
            if ($rowIndex === 1) {
                $firstCol = strtolower(trim($row[0] ?? ''));
                if (in_array($firstCol, ['nama', 'name', 'phone', 'nomor', 'no_hp', 'no hp', 'ekstensi', 'ext', 'telepon', 'kontak'])) {
                    continue;
                }
            }

            $name = trim($row[0] ?? '');
            $rawPhone = trim($row[1] ?? ($row[0] ?? ''));

            if (count($row) === 1 || empty($row[1])) {
                $rawPhone = $name;
                $name = '';
            }

            $phone = preg_replace('/@.*$/', '', $rawPhone);
            $phone = preg_replace('/:\d+$/', '', $phone);
            $phone = preg_replace('/\D/', '', $phone);

            if (empty($phone) || strlen($phone) < 3 || strlen($phone) > 16) {
                continue;
            }

            if (isset($existingPhones[$phone])) {
                continue;
            }

            $existingPhones[$phone] = true;

            if (empty($name) || $name === $rawPhone) {
                $name = (strlen($phone) <= 5 ? 'Ekstensi ' : 'Kontak ') . $phone;
            }

            $contacts[] = [
                'phonebook_id' => $phonebook->id,
                'name'         => substr($name, 0, 100),
                'phone'        => $phone,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
            $importedCount++;
        }
        fclose($handle);

        if (!empty($contacts)) {
            foreach (array_chunk($contacts, 500) as $chunk) {
                Contact::insertOrIgnore($chunk);
            }
        }

        return back()->with('success', "{$importedCount} kontak/ekstensi berhasil diimpor ke {$phonebook->name}!");
    }
}

