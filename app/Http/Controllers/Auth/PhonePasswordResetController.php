<?
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class PhonePasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password-phone');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'no_telp' => 'required|exists:users,no_telp'
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);
        
        // Store OTP in cache with expiry
        cache()->put(
            'password_reset_' . $request->no_telp,
            $otp,
            now()->addMinutes(10)
        );

        // Format nomor telepon untuk WhatsApp
        $phone = $this->formatPhoneNumber($request->no_telp);

        // Kirim OTP via WhatsApp
        try {
            $response = Http::withToken(config('services.whatsapp.token'))
                ->post(config('services.whatsapp.api_url') . '/messages', [
                    'messaging_product' => 'whatsapp',
                    'to' => $phone,
                    'type' => 'template',
                    'template' => [
                        'name' => 'reset_password_otp',
                        'language' => [
                            'code' => 'id'
                        ],
                        'components' => [
                            [
                                'type' => 'body',
                                'parameters' => [
                                    [
                                        'type' => 'text',
                                        'text' => $otp
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);

            if (!$response->successful()) {
                return back()->withErrors(['no_telp' => 'Gagal mengirim OTP. Silakan coba lagi.']);
            }

        } catch (\Exception $e) {
            return back()->withErrors(['no_telp' => 'Gagal mengirim OTP. Silakan coba lagi.']);
        }

        return redirect()->route('password.reset.phone.verify')
            ->with(['no_telp' => $request->no_telp]);
    }

    public function showVerifyForm()
    {
        if (!session('no_telp')) {
            return redirect()->route('password.request.phone');
        }
        return view('auth.verify-reset-code');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'no_telp' => 'required|exists:users,no_telp',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|min:8|confirmed'
        ]);

        $cachedOTP = cache()->get('password_reset_' . $request->no_telp);

        if (!$cachedOTP || $cachedOTP != $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid']);
        }

        $user = User::where('no_telp', $request->no_telp)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        cache()->forget('password_reset_' . $request->no_telp);

        return redirect()->route('login')
            ->with('status', 'Password berhasil direset!');
    }

    protected function formatPhoneNumber($phone)
    {
        // Hapus karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Hapus 0 di depan jika ada
        if (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }
        
        // Tambahkan kode negara Indonesia (62)
        return '62' . $phone;
    }
}