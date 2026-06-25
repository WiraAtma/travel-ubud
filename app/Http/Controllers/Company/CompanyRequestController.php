<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company\CompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'field'        => 'required|in:restaurant,destination,hotel',
            'reason'       => 'required|string|min:20',
            'proof_file'   => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ], [
            'proof_file.mimes' => 'File bukti harus berupa JPG, PNG, PDF, atau DOC.',
            'proof_file.max'   => 'Ukuran file maksimal 5MB.',
            'reason.min'       => 'Alasan minimal 20 karakter.',
        ]);

        $user = Auth::user();

        $existing = $user->latestCompanyRequest;
        if ($existing && $existing->isPending()) {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Pengajuan Masih Diproses',
                'text' => 'Anda sudah memiliki pengajuan yang sedang diproses.',
            ]);
        }

        $path = $request->file('proof_file')->store('company-proofs', 'supabase');

        CompanyRequest::create([
            'user_id'      => $user->id,
            'company_name' => $request->company_name,
            'field'        => $request->field,
            'reason'       => $request->reason,
            'proof_file'   => $path,
            'status'       => 'pending',
        ]);

        return back()->with('swal', [
            'icon' => 'success',
            'title' => 'Pengajuan Dikirim',
            'text' => 'Pengajuan berhasil dikirim! Silakan tunggu konfirmasi admin.',
            'toast' => true,
        ]);
    }

    public function cancel()
    {
        $user           = Auth::user();
        $companyRequest = $user->latestCompanyRequest;

        if (!$companyRequest || !$companyRequest->isPending()) {
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Tidak Bisa Dibatalkan',
                'text' => 'Hanya pengajuan aktif yang sedang diproses yang bisa dibatalkan.',
            ]);
        }

        if ($companyRequest->proof_file) {
            Storage::disk('supabase')->delete($companyRequest->proof_file);
        }
        
        $companyRequest->delete();

        return back()->with('swal', [
            'icon' => 'success',
            'title' => 'Pengajuan Dibatalkan',
            'text' => 'Pengajuan berhasil dibatalkan.',
            'toast' => true,
        ]);
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = CompanyRequest::with('user')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $requests = $query->paginate(10);

        return view('features.admin.request-company-admin', compact('requests', 'status'));
    }

    public function approve(CompanyRequest $companyRequest)
    {
        $companyRequest->update(['status' => 'approved']);

        $companyRequest->user->update([
            'role'         => 'company',
            'company_role' => $companyRequest->field 
        ]);

        return back()->with('swal', [
            'icon' => 'success',
            'title' => 'Pengajuan Disetujui',
            'text' => "Pengajuan {$companyRequest->user->name} telah disetujui.",
            'toast' => true,
        ]);
    }

    public function reject(Request $request, CompanyRequest $companyRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min'      => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $companyRequest->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('swal', [
            'icon' => 'success',
            'title' => 'Pengajuan Ditolak',
            'text' => "Pengajuan {$companyRequest->user->name} telah ditolak.",
            'toast' => true,
        ]);
    }

    public function viewProof(CompanyRequest $companyRequest)
    {
        $path = storage_path('app/public/' . $companyRequest->proof_file);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($path);
    }
}
