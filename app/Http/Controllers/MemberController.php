<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use Illuminate\Support\Facades\Hash;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class MemberController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:members',
            'password' => 'required|min:3|max:60|confirmed',
        ]);

        $newMember = new Member;
        $newMember->name = $request->name;
        $newMember->email = $request->email;
        $newMember->password = Hash::make($request->password);
        $newMember->bio = $request->bio;
        $newMember->activated = false;
        //Process upload file:
        if ( $request->hasFile('uploadFile') ){
            $profilePicture = $request->file('uploadFile');
            $fileName = 'Profile_Picture'.$profilePicture->getClientOriginalExtension();
            $profilePicture->move('storage/profile_pictures/'.$request->email, $fileName);

            $newMember->profile_picture = 'storage/profile_pictures/'.$request->email.'/'.$fileName;
        };
        $newMember->save();

        //Send registration email containing token to verify:
        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587))
            ->setUsername('huy.thevip@gmail.com')
            ->setPassword('hellokitty123');
        $mailer = new Swift_Mailer($transport);

        $token = base64_encode($request->email);
        $confirmationLink = '<a href="/register/token='.$token.'">link</a>';
        $emailBody = '<b>Congratulations!</b> on joining us!<br>Please click the following'.$confirmationLink.
            ' to finish your registration';

        $message = (new Swift_Message('Confirm your registration, '.$request->name))
            ->setFrom(['huy.thevip@gmail.com' => 'My Diary'])
            ->setTo([$request->email => $request->name])
            ->setBody($emailBody);

        $mailer->send($message);

        return redirect('/home');

    }
}
