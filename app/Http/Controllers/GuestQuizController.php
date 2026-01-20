<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuestQuizController extends Controller
{
    // Halaman utama (Input Kode)
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('guest.join');
    }

    // Cek Kode dan Redirect ke Input Nama
    public function checkCode(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);

        // Cari kuis berdasarkan kode saja dulu
        $quiz = Quiz::where('access_password', $request->access_code)->first();

        if (!$quiz) {
            return back()->with('error', 'Kode kuis salah! Pastikan huruf besar/kecil sesuai.');
        }

        if ($quiz->status !== 'active') {
            return back()->with('error', 'Kuis ini sedang tidak aktif (Status: ' . ucfirst($quiz->status) . ').');
        }

        if (!$quiz->isAvailable()) {
            return back()->with('error', 'Kuis belum dimulai atau jadwal sudah berakhir.');
        }

        // Simpan kode di session sementara
        session(['guest_quiz_code' => $request->access_code]);
        session(['guest_quiz_id' => $quiz->id]);

        return redirect()->route('guest.name');
    }

    // Halaman Input Nama
    public function nameForm()
    {
        if (!session('guest_quiz_code')) {
            return redirect()->route('guest.join');
        }

        $quiz = Quiz::find(session('guest_quiz_id'));
        return view('guest.name', compact('quiz'));
    }

    // Proses Join (Create Guest User & Auto Login)
    public function join(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $quizId = session('guest_quiz_id');
        $quiz = Quiz::find($quizId);

        if (!$quiz) {
            return redirect()->route('guest.join')->with('error', 'Sesi kadaluarsa, silakan masukkan kode lagi.');
        }

        // Buat Guest User
        // Format email unik: guest_TIMESTAMP_RANDOM@temp.com
        $guestEmail = 'guest_' . time() . '_' . Str::random(5) . '@temp.com';

        $user = User::create([
            'name' => $request->name,
            'email' => $guestEmail,
            'password' => Hash::make(Str::random(16)), // Password acak
            'role' => 'user', // Role user biasa
            'email_verified_at' => now(), // Auto verified
        ]);

        // Auto Login
        Auth::login($user);

        // Bersihkan session
        session()->forget(['guest_quiz_code', 'guest_quiz_id']);

        // Redirect langsung ke Start Quiz
        return redirect()->route('user.quizzes.show', $quiz)
            ->with('success', 'Selamat datang ' . $user->name . '! Silakan mulai kuisnya.');
    }
}
