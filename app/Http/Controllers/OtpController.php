<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['NISN_NIP' => 'required']);

        // Mencari user berdasarkan NISN atau NIP
        $user = User::where('NISN_NIP', $request->NISN_NIP)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return back()->withErrors(['NISN_NIP' => 'NIP atau NISN Tidak Ditemukan']);
        }

        // Jika user ditemukan tetapi email kosong
        if (empty($user->email)) {
            return back()->withErrors(['NISN_NIP' => 'Anda Belum Mempunyai Email Terdaftar untuk Reset Password, Harap Menghubungi Admin']);
        }

        // Generate OTP dan token
        $otp = rand(100000, 999999);
        $otpToken = Str::random(60); // Generate random otp token
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->otp_token = $otpToken; // Menyimpan otp token untuk verifikasi
        $user->save();

        // Mengirim OTP ke Email
        Mail::to($user->email)->send(new SendOtpMail($otp, $otpToken));

        return redirect()->route('otp.verify.form')->with('status', 'Kode OTP Berhasil Dikirim ke Email Anda');
    }


    public function showOtpVerificationForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $user = User::where('otp', $request->otp)
                    ->where('otp_expires_at', '>', now())
                    ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Kode OTP Anda Salah atau Sudah Kadaluarsa']);
        }

        // Menyimpan ID User ke dalam Session untuk reset password
        session(['reset_user_id' => $user->id]);

        // Mengalihkan User ke password reset jika otp benar
        return redirect()->route('password.reset.form')->with('status', 'OTP Anda Benar, Silakan Reset Password');
    }

    public function showResetForm()
    {
        // Mengecek user id ada dalam session ini
        if (!session('reset_user_id')) {
            return redirect()->route('password.forgot')->withErrors(['error' => 'Unauthorized access']);
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $userId = session('reset_user_id');

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('password.forgot')->withErrors(['error' => 'User not found']);
        }

        // Reset password
        $user->password = Hash::make($request->password);
        $user->otp = null; // Clear OTP
        $user->otp_expires_at = null;
        $user->otp_token = null;
        $user->save();

        // Menghapus session user jika berhasil reset password
        session()->forget('reset_user_id');

        return redirect()->route('login')->with('status', 'Password Berhasil Diubah, Sekarang Anda Dapat Login');
    }
}
