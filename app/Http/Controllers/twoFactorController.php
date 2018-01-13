<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Crypt;
use Google2FA;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \ParagonIE\ConstantTime\Base32;

class twoFactorController extends Controller
{
    //

    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('web');
    }

    public function enableTwoFactor(Request $request)
    {
        /*getting user*/
        $user = $request->user();

        /*generating the secret*/
        $secret = $this->generateSecret();

        /*encrypt and then save secret*/
        $user->google2fa_secret = Crypt::encrypt($secret);
        $user->save();

        /*generating a QR barcode image*/
        $imageDataUri = Google2FA::getQRCodeInline(
            $request->getHttpHost(),
            $user->email,
            $secret,
            200
        );

        return view('twofactor/enableTwoFactor', ['image' => $imageDataUri,
            'secret' => $secret]);
    }

    public function disableTwoFactor(Request $request)
    {
        /*getting user*/
        $user = $request->user();

        //make secret column blank
        $user->google2fa_secret = null;
        $user->save();

        return view('twofactor/disableTwoFactor');
    }

    public function generateSecret()
    {
        $randomBytes = random_bytes(10);

        return Base32::encodeUpper($randomBytes);
    }
}
